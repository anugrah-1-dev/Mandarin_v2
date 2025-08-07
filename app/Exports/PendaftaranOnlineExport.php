<?php

namespace App\Exports;

use App\Models\PendaftaranProgramOnline; // 1. Ganti Model
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PendaftaranOnlineExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithDrawings
{
    protected $pendaftarans;
    // --- PENGATURAN TAMPILAN ---
    protected $row_height = 80;
    protected $column_H_width = 20; // 2. Kolom gambar sekarang H
    // ----------------------------

    public function __construct()
    {
        $this->pendaftarans = PendaftaranProgramOnline::with(['program', 'period'])->get();
    }

    public function collection()
    {
        return $this->pendaftarans;
    }

    public function headings(): array
    {
        // 3. Headings disesuaikan untuk versi Online
        return [
            'ID Transaksi',
            'Nama Lengkap',
            'Email',
            'No HP',
            'Asal Kota',
            'Nama Program',
            'Tanggal Periode',
            'Bukti Pembayaran',
            'Status',
        ];
    }

    public function map($pendaftaran): array
    {
        // 4. Mapping disesuaikan untuk versi Online
        return [
            $pendaftaran->trx_id,
            $pendaftaran->nama_lengkap,
            $pendaftaran->email,
            $pendaftaran->no_hp,
            $pendaftaran->asal_kota,
            $pendaftaran->program ? $pendaftaran->program->nama : 'N/A',
            $pendaftaran->period ? $pendaftaran->period->date->format('d F Y') : 'N/A',
            '', // Kolom Bukti Pembayaran dikosongkan
            $pendaftaran->status,
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $columnWidthInPixels = $this->column_H_width * 7.5;

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
                // 5. Koordinat diubah ke kolom 'H'
                $drawing->setCoordinates('H' . ($key + 2));

                // Logika untuk posisi tengah
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
                
                $sheet->getStyle($cellRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A1:' . $highestColumn.'1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:' . $highestColumn.'1')->getFont()->setBold(true);

                foreach ($this->pendaftarans as $key => $pendaftaran) {
                    $rowNumber = $key + 2;
                    if ($pendaftaran->bukti_pembayaran && file_exists(public_path('storage/' . $pendaftaran->bukti_pembayaran))) {
                        $sheet->getDelegate()->getRowDimension($rowNumber)->setRowHeight($this->row_height);
                    } else {
                        $sheet->getDelegate()->getRowDimension($rowNumber)->setRowHeight(25);
                    }
                }

                // 6. Pengaturan lebar kolom disesuaikan
                foreach (range('A', 'G') as $col) { $sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true); }
                $sheet->getDelegate()->getColumnDimension('I')->setAutoSize(true);
                $sheet->getDelegate()->getColumnDimension('H')->setWidth($this->column_H_width);

                 $sheet->getStyle($cellRange)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]]);
            },
        ];
    }
}