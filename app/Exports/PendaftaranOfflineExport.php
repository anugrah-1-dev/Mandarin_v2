<?php

namespace App\Exports;

use App\Models\PendaftaranProgramOffline;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PendaftaranOfflineExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithDrawings
{
    protected $pendaftarans;
    protected $row_height = 80;
    protected $column_J_width = 20;

    public function __construct()
    {
        // 1. Tambahkan 'transport' ke dalam with() untuk eager loading
        $this->pendaftarans = PendaftaranProgramOffline::with(['program', 'period', 'transport'])->get();
    }

    public function collection()
    {
        return $this->pendaftarans;
    }

    public function headings(): array
    {
        // 2. Ubah heading kolom
        return [
            'ID Transaksi', 'Nama Lengkap', 'Email', 'No HP', 'Asal Kota', 'No Wali',
            'Nama Program', 'Tanggal Periode', 'Transportasi', 'Bukti Pembayaran', 'Status',
        ];
    }

    public function map($pendaftaran): array
    {
        return [
            $pendaftaran->trx_id,
            $pendaftaran->nama_lengkap,
            $pendaftaran->email,
            $pendaftaran->no_hp,
            $pendaftaran->asal_kota,
            $pendaftaran->no_wali,
            $pendaftaran->program ? $pendaftaran->program->nama : 'N/A',
            $pendaftaran->period ? $pendaftaran->period->date->format('d F Y') : 'N/A',
            // 3. Ubah bagian ini untuk menampilkan nama transportasi
            $pendaftaran->transport ? $pendaftaran->transport->name : 'N/A',
            '', // Kolom Bukti Pembayaran dikosongkan
            $pendaftaran->status,
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $columnWidthInPixels = $this->column_J_width * 7.5;

        foreach ($this->pendaftarans as $key => $pendaftaran) {
            if ($pendaftaran->bukti_pembayaran) {
                $pathToFile = public_path('storage/' . $pendaftaran->bukti_pembayaran);
                if (!file_exists($pathToFile)) {
                    continue;
                }

                $drawing = new Drawing();
                $drawing->setName('Bukti Pembayaran');
                $drawing->setDescription($pendaftaran->nama_lengkap);
                $drawing->setPath($pathToFile);
                $drawing->setCoordinates('J' . ($key + 2));

                list($originalWidth, $originalHeight) = getimagesize($pathToFile);
                $newHeight = $this->row_height - 10;
                $drawing->setHeight($newHeight);
                $newWidth = ($originalWidth / $originalHeight) * $newHeight;
                $drawing->setOffsetX(($columnWidthInPixels - $newWidth) / 2);
                $drawing->setOffsetY(($this->row_height - $newHeight) / 2);

                $drawings[] = $drawing;
            }
        }
        return $drawings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $highestRow = $sheet->getDelegate()->getHighestRow();
                $highestColumn = $sheet->getDelegate()->getHighestColumn();
                $cellRange = 'A1:' . $highestColumn . $highestRow;
                
                // PERUBAHAN: Mengatur alignment horizontal dan vertikal ke tengah untuk SEMUA sel
                $sheet->getStyle($cellRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($cellRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                
                // Mengatur font bold hanya untuk header
                $sheet->getStyle('A1:' . $highestColumn.'1')->getFont()->setBold(true);

                foreach ($this->pendaftarans as $key => $pendaftaran) {
                    $rowNumber = $key + 2;
                    if ($pendaftaran->bukti_pembayaran && file_exists(public_path('storage/' . $pendaftaran->bukti_pembayaran))) {
                        $sheet->getDelegate()->getRowDimension($rowNumber)->setRowHeight($this->row_height);
                    } else {
                        $sheet->getDelegate()->getRowDimension($rowNumber)->setRowHeight(25);
                    }
                }

                foreach (range('A', 'I') as $col) { $sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true); }
                foreach (range('K', $highestColumn) as $col) { $sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true); }
                $sheet->getDelegate()->getColumnDimension('J')->setWidth($this->column_J_width);

                 $sheet->getStyle($cellRange)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]]);
            },
        ];
    }
}
