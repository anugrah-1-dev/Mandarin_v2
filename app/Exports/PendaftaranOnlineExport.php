<?php

namespace App\Exports;

use App\Models\PendaftaranProgramOnline;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class PendaftaranOnlineExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithDrawings, WithTitle
{
    protected $pendaftarans;
    protected $startDate;
    protected $endDate;
    protected $programBahasaFilter;

    protected $rowHeight       = 75;
    protected $rowHeightNoImg  = 22;
    protected $headerRowHeight = 36;
    protected $titleRowHeight  = 38;
    protected $imgColWidth     = 22;
    protected $imgColIndex     = 11; // kolom K — Bukti Pembayaran (1-based)
    protected $totalCols       = 13; // A-M

    const COLOR_HEADER_BG   = 'FF0F4C81';
    const COLOR_HEADER_FONT = 'FFFFFFFF';
    const COLOR_TITLE_BG    = 'FF0369A1';
    const COLOR_TITLE_FONT  = 'FFFFFFFF';
    const COLOR_ROW_EVEN    = 'FFF0F9FF';
    const COLOR_ROW_ODD     = 'FFFFFFFF';
    const COLOR_BORDER      = 'FFB0C4D8';
    const COLOR_TUNAI_BG    = 'FFD1FAE5';
    const COLOR_TRANSFER_BG = 'FFDBEAFE';
    const COLOR_PENDING_BG  = 'FFFFF3CD';
    const COLOR_DITERIMA_BG = 'FFD4EDDA';
    const COLOR_DITOLAK_BG  = 'FFF8D7DA';

    public function __construct($startDate, $endDate, $programBahasa = null)
    {
        $this->startDate           = $startDate;
        $this->endDate             = $endDate;
        $this->programBahasaFilter = $programBahasa;

        $query = PendaftaranProgramOnline::with(['program', 'period', 'bank'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->latest();

        if ($programBahasa) {
            $query->whereHas('program', function ($q) use ($programBahasa) {
                $q->where('program_bahasa', $programBahasa);
            });
        }

        $this->pendaftarans = $query->get();
    }

    public function title(): string
    {
        return 'Data Pendaftar Online';
    }

    public function collection()
    {
        return $this->pendaftarans;
    }

    /**
     * headings() hanya 1 baris header kolom (flat array).
     * Baris judul & sub-info disisipkan via AfterSheet insertNewRowBefore.
     */
    public function headings(): array
    {
        return [
            'No', 'ID Transaksi', 'Nama Lengkap', 'Email', 'No HP', 'Asal Kota',
            'Nama Program', 'Tanggal Periode', 'Tipe Pembayaran', 'Bank Tujuan',
            'Bukti Pembayaran', 'Status', 'Subtotal',
        ];
    }

    public function map($pendaftaran): array
    {
        static $counter = 0;
        $counter++;

        $periodText = '-';
        if ($pendaftaran->period) {
            if ($pendaftaran->period->date) {
                $periodText = \Carbon\Carbon::parse($pendaftaran->period->date)->translatedFormat('d F Y');
            } elseif ($pendaftaran->period->tanggal_mulai && $pendaftaran->period->tanggal_selesai) {
                $tMulai   = \Carbon\Carbon::parse($pendaftaran->period->tanggal_mulai);
                $tSelesai = \Carbon\Carbon::parse($pendaftaran->period->tanggal_selesai);
                $periodText = $tMulai->isSameDay($tSelesai)
                    ? $tMulai->translatedFormat('d F Y')
                    : $tMulai->translatedFormat('d M Y') . ' - ' . $tSelesai->translatedFormat('d M Y');
            }
        }

        return [
            $counter,
            $pendaftaran->trx_id,
            $pendaftaran->nama_lengkap,
            $pendaftaran->email,
            $pendaftaran->no_hp,
            $pendaftaran->asal_kota,
            $pendaftaran->program->nama ?? '-',
            $periodText,
            ucfirst($pendaftaran->payment_type ?? '-'),
            $pendaftaran->payment_type === 'transfer' ? ($pendaftaran->bank->name ?? '-') : '-',
            $pendaftaran->payment_type === 'tunai' ? 'Tunai / Cash' : '',
            ucfirst($pendaftaran->status),
            (float) ($pendaftaran->subtotal ?? 0),
        ];
    }

    public function drawings()
    {
        $drawings     = [];
        $imgColLetter = Coordinate::stringFromColumnIndex($this->imgColIndex);
        $colWidthPx   = $this->imgColWidth * 7.5;

        foreach ($this->pendaftarans as $key => $pendaftaran) {
            if (!$pendaftaran->bukti_pembayaran) {
                continue;
            }

            $pathToFile = public_path('storage/' . $pendaftaran->bukti_pembayaran);
            if (!file_exists($pathToFile) || !@getimagesize($pathToFile)) {
                continue;
            }

            [$origW, $origH] = getimagesize($pathToFile);

            $maxH  = $this->rowHeight - 8;
            $maxW  = $colWidthPx - 8;
            $scale = min($maxW / max($origW, 1), $maxH / max($origH, 1), 1);
            $newH  = (int) round($origH * $scale);
            $newW  = (int) round($origW * $scale);

            // Baris 1 = header, data di baris 2+.
            // Setelah AfterSheet insert 2 baris: data geser ke baris 4+.
            $excelRow = $key + 4;

            $drawing = new Drawing();
            $drawing->setName('Bukti Pembayaran');
            $drawing->setDescription($pendaftaran->nama_lengkap);
            $drawing->setPath($pathToFile);
            $drawing->setCoordinates($imgColLetter . $excelRow);
            $drawing->setHeight($newH);
            $drawing->setOffsetX((int) max(($colWidthPx - $newW) / 2, 0));
            $drawing->setOffsetY((int) max(($this->rowHeight - $newH) / 2, 0));

            $drawings[] = $drawing;
        }

        return $drawings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $ws         = $event->sheet->getDelegate();
                $lastColLtr = Coordinate::stringFromColumnIndex($this->totalCols);
                $totalRows  = $this->pendaftarans->count();
                $imgColLtr  = Coordinate::stringFromColumnIndex($this->imgColIndex);

                // ── Insert 2 baris di paling atas ─────────────────────────────
                $ws->insertNewRowBefore(1, 2);

                $lastRow = $totalRows + 3;

                // ── Baris 1: Judul ─────────────────────────────────────────────
                $filter = $this->programBahasaFilter
                    ? '  |  Program: ' . ucfirst($this->programBahasaFilter)
                    : '  |  Semua Program';

                $ws->setCellValue('A1', 'LAPORAN DATA PENDAFTAR PROGRAM ONLINE');
                $ws->mergeCells('A1:' . $lastColLtr . '1');
                $ws->getRowDimension(1)->setRowHeight($this->titleRowHeight);
                $ws->getStyle('A1')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 15, 'color' => ['argb' => self::COLOR_TITLE_FONT]],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => self::COLOR_TITLE_BG]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);

                // ── Baris 2: Sub-info ──────────────────────────────────────────
                $subInfo = 'Periode: ' . \Carbon\Carbon::parse($this->startDate)->translatedFormat('d M Y')
                    . ' s/d ' . \Carbon\Carbon::parse($this->endDate)->translatedFormat('d M Y')
                    . $filter . '  |  Dicetak: ' . now()->translatedFormat('d M Y, H:i');

                $ws->setCellValue('A2', $subInfo);
                $ws->mergeCells('A2:' . $lastColLtr . '2');
                $ws->getRowDimension(2)->setRowHeight(20);
                $ws->getStyle('A2')->applyFromArray([
                    'font'      => ['italic' => true, 'size' => 9, 'color' => ['argb' => 'FF374151']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE0F2FE']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);

                // ── Baris 3: Header Kolom ──────────────────────────────────────
                $ws->getRowDimension(3)->setRowHeight($this->headerRowHeight);
                $ws->getStyle('A3:' . $lastColLtr . '3')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 10, 'color' => ['argb' => self::COLOR_HEADER_FONT]],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => self::COLOR_HEADER_BG]],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                        'wrapText'   => true,
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['argb' => 'FFFFFFFF']],
                    ],
                ]);

                // ── Baris Data ─────────────────────────────────────────────────
                for ($row = 4; $row <= $lastRow; $row++) {
                    $key         = $row - 4;
                    $pendaftaran = $this->pendaftarans[$key] ?? null;

                    $hasImage = $pendaftaran
                        && $pendaftaran->bukti_pembayaran
                        && file_exists(public_path('storage/' . $pendaftaran->bukti_pembayaran));

                    $ws->getRowDimension($row)->setRowHeight(
                        $hasImage ? $this->rowHeight : $this->rowHeightNoImg
                    );

                    $bgArgb   = ($row % 2 === 0) ? self::COLOR_ROW_EVEN : self::COLOR_ROW_ODD;
                    $rowRange = 'A' . $row . ':' . $lastColLtr . $row;
                    $ws->getStyle($rowRange)->applyFromArray([
                        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bgArgb]],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                    ]);

                    if ($pendaftaran) {
                        $statusBg = match ($pendaftaran->status) {
                            'diterima' => self::COLOR_DITERIMA_BG,
                            'ditolak'  => self::COLOR_DITOLAK_BG,
                            'pending'  => self::COLOR_PENDING_BG,
                            default    => $bgArgb,
                        };
                        $ws->getStyle('L' . $row)->applyFromArray([
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $statusBg]],
                            'font' => ['bold' => true],
                        ]);

                        $bayarBg = ($pendaftaran->payment_type === 'tunai')
                            ? self::COLOR_TUNAI_BG : self::COLOR_TRANSFER_BG;
                        $ws->getStyle('I' . $row)->applyFromArray([
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bayarBg]],
                        ]);

                        $ws->getStyle('K' . $row)->getAlignment()
                            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                            ->setVertical(Alignment::VERTICAL_CENTER);
                    }
                }

                // ── Border tabel ───────────────────────────────────────────────
                if ($lastRow >= 3) {
                    $ws->getStyle('A3:' . $lastColLtr . $lastRow)->applyFromArray([
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN,  'color' => ['argb' => self::COLOR_BORDER]],
                            'outline'    => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['argb' => self::COLOR_HEADER_BG]],
                        ],
                    ]);
                }

                // ── Format Currency ────────────────────────────────────────────
                if ($lastRow >= 4) {
                    $ws->getStyle('M4:M' . $lastRow)->getNumberFormat()->setFormatCode('"Rp "#,##0');
                }

                // ── Rata tengah ────────────────────────────────────────────────
                if ($lastRow >= 4) {
                    foreach (['A', 'I', 'L'] as $col) {
                        $ws->getStyle($col . '4:' . $col . $lastRow)
                            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }
                }

                // ── Lebar kolom ────────────────────────────────────────────────
                $ws->getColumnDimension($imgColLtr)->setWidth($this->imgColWidth);
                $ws->getColumnDimension('A')->setAutoSize(false)->setWidth(5);

                for ($i = 2; $i <= $this->totalCols; $i++) {
                    $col = Coordinate::stringFromColumnIndex($i);
                    if ($col !== $imgColLtr) {
                        $ws->getColumnDimension($col)->setAutoSize(true);
                    }
                }

                // ── Freeze panes ───────────────────────────────────────────────
                $ws->freezePane('A4');

                // ── Warna tab sheet ────────────────────────────────────────────
                $ws->getParent()->getActiveSheet()->getTabColor()->setARGB(self::COLOR_TITLE_BG);
            },
        ];
    }
}