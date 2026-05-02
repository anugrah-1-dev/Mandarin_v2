<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramOffline;
use Illuminate\Support\Str;

class BrilliantIEProgramSeeder extends Seeder
{
    public function run(): void
    {
        ProgramOffline::where('kursus', 'brilliant')->delete();

        $fasilitasUmum = [
            'Free Voucher Brilliant Health Care',
            'Tempat Tinggal / Camp',
            'Modul, Competence & Gelang',
            'Sertifikat',
            'Bonus Materi Psychotraining & Enterpreneurship',
            'Pendidikan Budi Pekerti Luhur Etika Sopan Santun Budaya Jawa',
            'Program 6 Kelas/Hari X 75 Menit',
            'T-Shirt',
        ];

        $programs = [
            [
                'nama'             => 'SHORT LEARNING 1',
                'lama_program'     => '7 Hari',
                'kategori'         => 'Short Learning',
                'harga'            => 495000,
                'features_program' => json_encode(array_merge(['Biaya Admin : Rp. 125.000'], $fasilitasUmum)),
            ],
            [
                'nama'             => 'SHORT LEARNING 2',
                'lama_program'     => '14 Hari',
                'kategori'         => 'Short Learning',
                'harga'            => 850000,
                'features_program' => json_encode(array_merge(['Biaya Admin : Rp. 125.000'], $fasilitasUmum)),
            ],
            [
                'nama'             => 'REGULER 1',
                'lama_program'     => '30 Hari',
                'kategori'         => 'Reguler',
                'harga'            => 1399000,
                'features_program' => json_encode(array_merge(['Biaya Admin : Gratis'], $fasilitasUmum)),
            ],
            [
                'nama'             => 'REGULER 2',
                'lama_program'     => '60 Hari',
                'kategori'         => 'Reguler',
                'harga'            => 2599000,
                'features_program' => json_encode(array_merge(['Biaya Admin : Gratis'], $fasilitasUmum)),
            ],
            [
                'nama'             => 'MASTER',
                'lama_program'     => '90 Hari',
                'kategori'         => 'Master',
                'harga'            => 3867000,
                'features_program' => json_encode(array_merge(['Biaya Admin : Gratis'], ['BONUS TOEFL Preparation'], $fasilitasUmum)),
            ],
        ];

        foreach ($programs as $data) {
            ProgramOffline::create([
                'nama'             => $data['nama'],
                'slug'             => Str::slug($data['nama']),
                'program_bahasa'   => 'Inggris',
                'lama_program'     => $data['lama_program'],
                'kategori'         => $data['kategori'],
                'harga'            => $data['harga'],
                'features_program' => $data['features_program'],
                'lokasi'           => 'Pare, Kediri',
                'kuota'            => 50,
                'is_active'        => 1,
                'kursus'           => 'brilliant',
                'thumbnail'        => null,
            ]);
        }
    }
}
