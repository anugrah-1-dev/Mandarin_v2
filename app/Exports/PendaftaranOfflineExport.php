<?php

namespace App\Exports;

use App\Models\PendaftaranProgramOffline;
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

class PendaftaranOfflineExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithDrawings, WithTitle
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
    protected $imgColIndex     = 16; // kolom P — Bukti Pembayaran (1-based)
    protected $totalCols       = 21; // A-U

    const COLOR_HEADER_BG   = 'FF1B3A5C';
    const COLOR_HEADER_FONT = 'FFFFFFFF';
    const COLOR_TITLE_BG    = 'FF2563EB';
    const COLOR_TITLE_FONT  = 'FFFFFFFF';
    const COLOR_ROW_EVEN    = 'FFF0F7FF';
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
        $this->programBahasaFilter = $programBahasa ? trim($programBahasa) : null;

        // Gunakan range datetime penuh (00:00:00 - 23:59:59) agar tidak miss data di hari yang sama
        $query = PendaftaranProgramOffline::with(['program', 'period', 'transport', 'bank'])
            ->where('created_at', '>=', $startDate . ' 00:00:00')
            ->where('created_at', '<=', $endDate . ' 23:59:59')
            ->latest();

        // Filter program_bahasa secara case-insensitive untuk menghindari mismatch
        if (!empty($this->programBahasaFilter)) {
            $lower = strtolower($this->programBahasaFilter);
            $query->whereHas('program', function ($q) use ($lower) {
                $q->whereRaw('LOWER(program_bahasa) = ?', [$lower]);
            });
        }

        $this->pendaftarans = $query->get();
    }

    public function title(): string
    {
        return 'Data Pendaftar Offline';
    }

    public function collection()
    {
        return $this->pendaftarans;
    }

    /**
     * headings() hanya mengembalikan 1 baris header kolom (flat array).
     * Baris judul & sub-info disisipkan via AfterSheet (insert rows di awal).
     */
    public function headings(): array
    {
        return [
            'No', 'ID Transaksi', 'Nama Lengkap', 'Email', 'No HP', 'Asal Kota',
            'Tempat Lahir', 'Tanggal Lahir', 'Gender', 'No Wali', 'Nama Program',
            'Tanggal Periode', 'Transportasi', 'Ukuran Seragam', 'Tipe Pembayaran',
            'Bukti Pembayaran', 'Bank Tujuan', 'Status', 'Subtotal',
            'Akomodasi Tipe', 'Akomodasi Harga',
        ];
    }

    public function map($pendaftaran): array
    {
        // Cari posisi index dari koleksi (1-based)
        $index = $this->pendaftarans->search(fn($p) => $p->id === $pendaftaran->id);
        $no    = ($index !== false) ? $index + 1 : 0;

        $periodText = '-';
        if ($pendaftaran->period) {
            $mulai    = $pendaftaran->period->tanggal_mulai ?? $pendaftaran->period->date;
            $selesai  = $pendaftaran->period->tanggal_selesai ?? $pendaftaran->period->date;
            $tMulai   = \Carbon\Carbon::parse($mulai);
            $tSelesai = \Carbon\Carbon::parse($selesai);
            $periodText = $tMulai->isSameDay($tSelesai)
                ? $tMulai->translatedFormat('d F Y')
                : $tMulai->translatedFormat('d M Y') . ' - ' . $tSelesai->translatedFormat('d M Y');
        }

        return [
            $no,
            $pendaftaran->trx_id,
            $pendaftaran->nama_lengkap,
            $pendaftaran->email,
            $pendaftaran->no_hp,
            $pendaftaran->asal_kota,
            $pendaftaran->tempat_lahir ?? '-',
            $pendaftaran->tanggal_lahir
                ? \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->translatedFormat('d M Y')
                : '-',
            ucfirst($pendaftaran->gender ?? '-'),
            $pendaftaran->no_wali,
            $pendaftaran->program->nama ?? '-',
            $periodText,
            $pendaftaran->transport->name ?? '-',
            strtoupper($pendaftaran->ukuran_seragam ?? '-'),
            ucfirst($pendaftaran->payment_type),
            $pendaftaran->payment_type === 'tunai' ? 'Tunai / Cash' : '',
            $pendaftaran->payment_type === 'transfer' ? ($pendaftaran->bank->name ?? '-') : '-',
            ucfirst($pendaftaran->status),
            (float) ($pendaftaran->subtotal ?? 0),
            $pendaftaran->akomodasi_tipe ?? '-',
            (float) ($pendaftaran->akomodasi_harga ?? 0),
        ];
    }

    /**
     * Gambar disisipkan di baris data + 3 (karena AfterSheet akan insert 2 baris di atas header).
     * Setelah insert:  baris 1 = judul, baris 2 = sub-info, baris 3 = header kolom, baris 4+ = data
     */
    public function drawings()
    {
        $drawings     = [];
        $imgColLetter = Coordinate::stringFromColumnIndex($this->imgColIndex);
        $colWidthPx   = $this->imgColWidth * 7.5;

        foreach ($this->pendaftarans as $key => $pendaftaran) {
            if ($pendaftaran->payment_type !== 'transfer' || !$pendaftaran->bukti_pembayaran) {
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

            // Baris 1 = header (dari headings()), data mulai baris 2.
            // Setelah AfterSheet insert 2 baris di awal: data geser ke baris 4.
            // Jadi $key=0 -> baris 4, $key=1 -> baris 5, dst.
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

                // ── Insert 2 baris di paling atas (sebelum header kolom) ─────────
                // Sesudah insert: baris1=judul, baris2=sub-info, baris3=header kolom
                $ws->insertNewRowBefore(1, 2);

                $lastRow = $totalRows + 3; // baris 4 s/d lastRow adalah data

                // ── Baris 1: Judul ───────────────────────────────────────────────
                $filter = $this->programBahasaFilter
                    ? '  |  Program: ' . ucfirst($this->programBahasaFilter)
                    : '  |  Semua Program';

                $ws->setCellValue('A1', 'LAPORAN DATA PENDAFTAR PROGRAM OFFLINE');
                $ws->mergeCells('A1:' . $lastColLtr . '1');
                $ws->getRowDimension(1)->setRowHeight($this->titleRowHeight);
                $ws->getStyle('A1')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 15, 'color' => ['argb' => self::COLOR_TITLE_FONT]],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => self::COLOR_TITLE_BG]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);

                // ── Baris 2: Sub-info ─────────────────────────────────────────────
                $subInfo = 'Periode: ' . \Carbon\Carbon::parse($this->startDate)->translatedFormat('d M Y')
                    . ' s/d ' . \Carbon\Carbon::parse($this->endDate)->translatedFormat('d M Y')
                    . $filter . '  |  Dicetak: ' . now()->translatedFormat('d M Y, H:i');

                $ws->setCellValue('A2', $subInfo);
                $ws->mergeCells('A2:' . $lastColLtr . '2');
                $ws->getRowDimension(2)->setRowHeight(20);
                $ws->getStyle('A2')->applyFromArray([
                    'font'      => ['italic' => true, 'size' => 9, 'color' => ['argb' => 'FF374151']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE8F0FE']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);

                // ── Baris 3: Header Kolom ─────────────────────────────────────────
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

                // ── Baris Data: Zebra + tinggi + warna kolom ─────────────────────
                for ($row = 4; $row <= $lastRow; $row++) {
                    $key         = $row - 4;
                    $pendaftaran = $this->pendaftarans[$key] ?? null;

                    $hasImage = $pendaftaran
                        && $pendaftaran->payment_type === 'transfer'
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
                        $ws->getStyle('R' . $row)->applyFromArray([
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $statusBg]],
                            'font' => ['bold' => true],
                        ]);

                        $bayarBg = $pendaftaran->payment_type === 'tunai'
                            ? self::COLOR_TUNAI_BG : self::COLOR_TRANSFER_BG;
                        $ws->getStyle('O' . $row)->applyFromArray([
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bayarBg]],
                        ]);

                        $ws->getStyle('P' . $row)->getAlignment()
                            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                            ->setVertical(Alignment::VERTICAL_CENTER);
                    }
                }

                // ── Border tabel ─────────────────────────────────────────────────
                if ($lastRow >= 3) {
                    $ws->getStyle('A3:' . $lastColLtr . $lastRow)->applyFromArray([
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN,  'color' => ['argb' => self::COLOR_BORDER]],
                            'outline'    => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['argb' => self::COLOR_HEADER_BG]],
                        ],
                    ]);
                }

                // ── Format Currency ───────────────────────────────────────────────
                if ($lastRow >= 4) {
                    $ws->getStyle('S4:S' . $lastRow)->getNumberFormat()->setFormatCode('"Rp "#,##0');
                    $ws->getStyle('U4:U' . $lastRow)->getNumberFormat()->setFormatCode('"Rp "#,##0');
                }

                // ── Rata tengah kolom tertentu ────────────────────────────────────
                if ($lastRow >= 4) {
                    foreach (['A', 'I', 'N', 'O', 'R'] as $col) {
                        $ws->getStyle($col . '4:' . $col . $lastRow)
                            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }
                }

                // ── Lebar kolom ───────────────────────────────────────────────────
                $ws->getColumnDimension($imgColLtr)->setWidth($this->imgColWidth);
                $ws->getColumnDimension('A')->setAutoSize(false)->setWidth(5);

                for ($i = 2; $i <= $this->totalCols; $i++) {
                    $col = Coordinate::stringFromColumnIndex($i);
                    if ($col !== $imgColLtr) {
                        $ws->getColumnDimension($col)->setAutoSize(true);
                    }
                }

                // ── Freeze panes ──────────────────────────────────────────────────
                $ws->freezePane('A4');

                // ── Warna tab sheet ───────────────────────────────────────────────
                $ws->getParent()->getActiveSheet()->getTabColor()->setARGB(self::COLOR_TITLE_BG);
            },
        ];
    }
}