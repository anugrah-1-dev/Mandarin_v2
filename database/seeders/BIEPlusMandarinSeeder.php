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
        // PROGRAM ONLINE
        // =====================

        $programsOnline = [
            [
                'nama'             => 'Reguler Basic',
                'lama_program'     => '20 Pertemuan (Senin–Jumat)',
                'kategori'         => 'Reguler',
                'harga'            => 500000,
                'features_program' => json_encode([
                    'E-Sertifikat',
                    'E-Modul',
                    'Akses Rekam Layar',
                ]),
            ],
            [
                'nama'             => 'Reguler HSK',
                'lama_program'     => '15 Pertemuan (Senin–Jumat)',
                'kategori'         => 'Reguler',
                'harga'            => 650000,
                'features_program' => json_encode([
                    'E-Sertifikat',
                    'E-Modul',
                    'Akses Rekam Layar',
                ]),
            ],
            [
                'nama'             => 'Private Basic',
                'lama_program'     => '10 Pertemuan',
                'kategori'         => 'Private',
                'harga'            => 800000,
                'features_program' => json_encode([
                    'Belajar intensif materi dasar hingga percakapan sehari-hari',
                    'E-Sertifikat',
                    'E-Modul',
                ]),
            ],
            [
                'nama'             => 'Private HSK',
                'lama_program'     => '10 Pertemuan',
                'kategori'         => 'Private',
                'harga'            => 1000000,
                'features_program' => json_encode([
                    'Belajar Mandarin dengan kurikulum HSK secara intensif',
                    'E-Sertifikat',
                    'E-Modul',
                ]),
            ],
            [
                'nama'             => 'Private HSKK',
                'lama_program'     => '10 Pertemuan',
                'kategori'         => 'Private',
                'harga'            => 850000,
                'features_program' => json_encode([
                    'Khusus melatih kemampuan berbicara (speaking) secara intensif',
                    'E-Sertifikat',
                    'E-Modul',
                ]),
            ],
            [
                'nama'             => 'Custom Class',
                'lama_program'     => '10 Pertemuan',
                'kategori'         => 'Custom',
                'harga'            => 900000,
                'features_program' => json_encode([
                    'Menggunakan materi yang disesuaikan dengan kebutuhan siswa',
                    'E-Sertifikat',
                    'E-Modul',
                ]),
            ],
            [
                'nama'             => 'Mandarin Kids',
                'lama_program'     => '10 Pertemuan',
                'kategori'         => 'Kids',
                'harga'            => 800000,
                'features_program' => json_encode([
                    'Belajar dari awal dengan metode menyenangkan & interaktif',
                    'E-Sertifikat',
                    'E-Modul',
                ]),
            ],
            [
                'nama'             => 'Mandarin Bisnis',
                'lama_program'     => '10 Pertemuan',
                'kategori'         => 'Bisnis',
                'harga'            => 900000,
                'features_program' => json_encode([
                    'Menggunakan materi yang berhubungan langsung dengan dunia kerja/perusahaan',
                    'E-Sertifikat',
                    'E-Modul',
                ]),
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

        // =====================
        // PROGRAM OFFLINE - REGULER (Camp / Asrama)
        // =====================

        $fasilitasBasic = [
            'Camp/Asrama',
            'Modul',
            'Merchandise',
            'Sertifikat',
            'Ujian',
            'Pre-Test HSK 1',
            'Konsultasi Beasiswa/Kerja',
        ];

        $fasilitasHsk1 = [
            'Camp/Asrama',
            'Modul',
            'Merchandise',
            'Sertifikat',
            'Ujian',
            'Pre-Test HSK 2',
            'Konsultasi Beasiswa/Kerja',
        ];

        $fasilitasHsk2 = [
            'Camp/Asrama',
            'Modul',
            'Merchandise',
            'Sertifikat',
            'Ujian',
            'Pre-Test HSK 3',
            'Konsultasi Beasiswa/Kerja',
        ];

        $fasilitasHsk3 = [
            'Camp/Asrama',
            'Modul',
            'Merchandise',
            'Sertifikat',
            'Ujian',
            'Pre-Test HSK 4',
            'Konsultasi Beasiswa/Kerja',
        ];

        $fasilitasHsk4 = [
            'Camp/Asrama',
            'Modul',
            'Merchandise',
            'Sertifikat',
            'Ujian',
            'Pre-Test HSK 5',
            'Konsultasi Beasiswa/Kerja',
        ];

        $fasilitasHskk = [
            'Camp/Asrama',
            'Modul',
            'Merchandise',
            'Sertifikat',
            'Ujian',
            'Konsultasi Beasiswa/Kerja',
            'Fokus Speaking / Lisan (口语)',
        ];

        // Paket Intensif Panjang "Beginner to Master"
        $fasilitasBasicBoost = [
            'Camp/Asrama',
            'Sertifikat',
            'Modul',
            'Merchandise',
            'Kelas Pinyin & Nada',
            'Penguasaan Kosakata Dasar',
            'Percakapan Sehari-hari',
            'Perkenalan & Tanya Jawab Sederhana',
        ];

        $fasilitasIntermediateJourney = [
            'Camp/Asrama',
            'Sertifikat',
            'Modul',
            'Merchandise',
            'Materi Lebih Mendalam',
            'Kelas Grammar Tambahan',
            'Latihan Berbicara Intensif',
            'Lancar Berbicara Topik Sehari-hari',
        ];

        $fasilitasMasteryProgram = [
            'Camp/Asrama',
            'Sertifikat',
            'Modul',
            'Merchandise',
            'Latihan Komunikasi Aktif & Natural',
            'Diskusi & Ekspresi Berpendapat',
            'Berbicara Lancar Layaknya Native',
            'Siap Kerja / Bisnis',
        ];

        $programsOffline = [
            // === PROGRAM REGULER (Offline Camp) ===
            [
                'nama'             => 'Basic (初级)',
                'lama_program'     => '1 Bulan',
                'kategori'         => 'Basic',
                'harga'            => 1125000,
                'kuota'            => 10,
                'features_program' => json_encode($fasilitasBasic),
            ],
            [
                'nama'             => 'HSK 1 (汉语初级)',
                'lama_program'     => '1 Bulan',
                'kategori'         => 'HSK 1',
                'harga'            => 1400000,
                'kuota'            => 8,
                'features_program' => json_encode($fasilitasHsk1),
            ],
            [
                'nama'             => 'HSK 2 (汉语中级)',
                'lama_program'     => '1 Bulan',
                'kategori'         => 'HSK 2',
                'harga'            => 1800000,
                'kuota'            => 8,
                'features_program' => json_encode($fasilitasHsk2),
            ],
            [
                'nama'             => 'HSK 3 (汉语中级)',
                'lama_program'     => '2 Bulan',
                'kategori'         => 'HSK 3',
                'harga'            => 2500000,
                'kuota'            => 8,
                'features_program' => json_encode($fasilitasHsk3),
            ],
            [
                'nama'             => 'HSK 4 (汉语高级)',
                'lama_program'     => '2 Bulan',
                'kategori'         => 'HSK 4',
                'harga'            => 4200000,
                'kuota'            => 5,
                'features_program' => json_encode($fasilitasHsk4),
            ],
            [
                'nama'             => 'HSKK (口语)',
                'lama_program'     => '1 Bulan',
                'kategori'         => 'HSKK',
                'harga'            => 1800000,
                'kuota'            => 8,
                'features_program' => json_encode($fasilitasHskk),
            ],

            // === PAKET INTENSIF PANJANG: "Beginner to Master" ===
            [
                'nama'             => 'Mandarin Basic Boost',
                'lama_program'     => '3 Bulan',
                'kategori'         => 'Master',
                'harga'            => 4325000,
                'kuota'            => 10,
                'features_program' => json_encode($fasilitasBasicBoost),
            ],
            [
                'nama'             => 'Mandarin Intermediate Journey',
                'lama_program'     => '5 Bulan',
                'kategori'         => 'Master',
                'harga'            => 6825000,
                'kuota'            => 10,
                'features_program' => json_encode($fasilitasIntermediateJourney),
            ],
            [
                'nama'             => 'Mandarin Mastery Program',
                'lama_program'     => '7 Bulan',
                'kategori'         => 'Master',
                'harga'            => 10975000,
                'kuota'            => 10,
                'features_program' => json_encode($fasilitasMasteryProgram),
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
                'kuota'            => $data['kuota'],
                'is_active'        => 1,
                'kursus'           => 'brilliant',
                'thumbnail'        => null,
            ]);
        }
    }
}
