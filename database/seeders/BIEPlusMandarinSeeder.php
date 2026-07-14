<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramOffline;
use App\Models\ProgramOnline;
use Illuminate\Support\Str;

class BIEPlusMandarinSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama Mandarin di brilliant
        ProgramOffline::where('kursus', 'brilliant')->where('program_bahasa', 'Mandarin')->delete();
        ProgramOnline::where('kursus', 'brilliant')->where('program_bahasa', 'Mandarin')->delete();

        // =====================
        // PROGRAM OFFLINE
        // =====================

        $fasilitasDasar = [
            'Modul',
            'Sertifikat',
            'Kelas Cozy',
            'Tempat Tinggal / Camp Reguler',
            '3 Kelas/hari',
            'Leader Camp',
            'Merchandise',
            'Ujian',
        ];

        $fasilitasBulan1 = [
            'Modul',
            'Sertifikat',
            'Kelas Cozy',
            'Tempat Tinggal / Camp Reguler',
            '3 Kelas/hari',
            'Leader Camp',
            'Merchandise',
            'Ujian',
            'PRE-TEST HSK 1',
            'Konsultasi Beasiswa/Kerja',
        ];

        $fasilitasHsk1 = [
            'Modul',
            'Sertifikat',
            'Kelas Cozy',
            'Tempat Tinggal / Camp Reguler',
            '3 Kelas/Hari',
            'Leader Camp',
            'Merchandise',
            'Ujian',
            'PRE-TEST HSK 2',
            'Konsultasi Beasiswa/Kerja',
            'Kelas Mendengar (Tingli 听力)',
        ];

        $fasilitasHsk2Bulan1 = [
            'Modul',
            'Sertifikat',
            'Kelas Cozy',
            'Tempat Tinggal / Camp',
            '3 Kelas/Hari',
            'Leader Camp',
            'Merchandise',
            'Ujian',
            'PRE-TEST HSK 3',
            'Konsultasi Beasiswa/Kerja',
            'Kelas Mendengar (Tingli 听力)',
            'Kelas Entrepreneur & Psychotraining',
        ];

        $fasilitasHsk2Bulan2 = [
            'E-Modul',
            'E-Sertifikat',
            'Kelas Cozy',
            'Tempat Tinggal / Camp Reguler',
            '3 Kelas/Hari',
            'Leader Camp',
            'Merchandise',
            'Ujian',
            'PRE-TEST HSK 3',
            'Konsultasi Beasiswa/Kerja',
            'Kelas Mendengar (Tingli 听力)',
            'Kelas Entrepreneur & Psychotraining',
        ];

        $fasilitasHsk3 = [
            'Sertifikat',
            'Kelas Cozy',
            'Tempat Tinggal / Camp Reguler',
            '3 Kelas/Hari',
            'Leader Camp',
            'Merchandise',
            'Ujian',
            'PRE-TEST HSK 4',
            'Konsultasi Beasiswa/Kerja',
            'Kelas Mendengar (Tingli 听力)',
            'Kelas Entrepreneur & Psychotraining',
        ];

        $fasilitasPaketLong = [
            'Sertifikat',
            'Modul',
            'Camp Reguler',
            'Kelas (Berbicara, Vocab, Menulis, Listening)',
            'Senin-Jumat',
            '60-75 Menit/Pertemuan',
            'Merchandise',
        ];

        $programsOffline = [
            [
                'nama'             => 'Paket 1 Minggu',
                'lama_program'     => '1 Minggu',
                'kategori'         => 'Short Learning',
                'harga'            => 624000,
                'features_program' => json_encode($fasilitasDasar),
            ],
            [
                'nama'             => 'Paket 2 Minggu',
                'lama_program'     => '2 Minggu',
                'kategori'         => 'Short Learning',
                'harga'            => 849000,
                'features_program' => json_encode($fasilitasDasar),
            ],
            [
                'nama'             => 'Paket 1 Bulan',
                'lama_program'     => '1 Bulan',
                'kategori'         => 'Reguler',
                'harga'            => 1124000,
                'features_program' => json_encode($fasilitasBulan1),
            ],
            [
                'nama'             => 'Paket HSK 1 (1 Bulan)',
                'lama_program'     => '1 Bulan',
                'kategori'         => 'HSK 1',
                'harga'            => 1400000,
                'features_program' => json_encode($fasilitasHsk1),
            ],
            [
                'nama'             => 'Paket HSK 2 (1 Bulan)',
                'lama_program'     => '1 Bulan',
                'kategori'         => 'HSK 2',
                'harga'            => 1800000,
                'features_program' => json_encode($fasilitasHsk2Bulan1),
            ],
            [
                'nama'             => 'Paket HSK 2 (2 Bulan)',
                'lama_program'     => '2 Bulan',
                'kategori'         => 'HSK 2',
                'harga'            => 2880000,
                'features_program' => json_encode($fasilitasHsk2Bulan2),
            ],
            [
                'nama'             => 'Paket HSK 3 (2 Bulan)',
                'lama_program'     => '2 Bulan',
                'kategori'         => 'HSK 3',
                'harga'            => 2500000,
                'features_program' => json_encode($fasilitasHsk3),
            ],
            [
                'nama'             => '3 Bulan (Basic-HSK1-HSK2)',
                'lama_program'     => '3 Bulan',
                'kategori'         => 'Master',
                'harga'            => 4324000,
                'features_program' => json_encode($fasilitasPaketLong),
            ],
            [
                'nama'             => '5 Bulan (Basic-HSK1-HSK2-HSK3)',
                'lama_program'     => '5 Bulan',
                'kategori'         => 'Master',
                'harga'            => 6724000,
                'features_program' => json_encode($fasilitasPaketLong),
            ],
            [
                'nama'             => '7 Bulan (Basic-HSK1-HSK2-HSK3-HSK4)',
                'lama_program'     => '7 Bulan',
                'kategori'         => 'Master',
                'harga'            => 10975000,
                'features_program' => json_encode($fasilitasPaketLong),
            ],
        ];

        foreach ($programsOffline as $data) {
            ProgramOffline::create([
                'nama'             => $data['nama'],
                'slug'             => Str::slug($data['nama']) . '-mandarin-brilliant',
                'program_bahasa'   => 'Mandarin',
                'lama_program'     => $data['lama_program'],
                'kategori'         => $data['kategori'],
                'harga'            => $data['harga'],
                'features_program' => $data['features_program'],
                'jadwal_mulai'     => null,
                'jadwal_selesai'   => null,
                'lokasi'           => 'Pare, Kediri',
                'kuota'            => 50,
                'is_active'        => 1,
                'kursus'           => 'brilliant',
                'thumbnail'        => null,
            ]);
        }

        // =====================
        // PROGRAM ONLINE
        // =====================

        $fasilitasOnline = [
            'E-Modul Lengkap',
            'E-Sertifikat Resmi',
            '20 Sesi Belajar (60 Menit/Sesi)',
            '5-7 Member/Kelas',
            'Tutor Berpengalaman',
            'Latihan Speaking Setiap Hari',
            'Beragam Tema Pembelajaran',
            'Belajar Fleksibel Dari Mana Saja',
        ];

        $programsOnline = [
            [
                'nama'             => 'Program 1 Bulan',
                'lama_program'     => '1 Bulan',
                'kategori'         => 'Reguler',
                'harga'            => 500000,
                'features_program' => json_encode($fasilitasOnline),
            ],
        ];

        foreach ($programsOnline as $data) {
            ProgramOnline::create([
                'nama'             => $data['nama'],
                'slug'             => Str::slug($data['nama']) . '-mandarin-brilliant',
                'program_bahasa'   => 'Mandarin',
                'lama_program'     => $data['lama_program'],
                'kategori'         => $data['kategori'],
                'harga'            => $data['harga'],
                'features_program' => $data['features_program'],
                'is_active'        => 1,
                'kursus'           => 'brilliant',
                'thumbnail'        => null,
            ]);
        }
    }
}
