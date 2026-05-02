<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramOffline;
use Illuminate\Support\Str;

class BIEPlusProgramSeeder extends Seeder
{
    public function run(): void
    {
        ProgramOffline::where('kursus', 'bieplus')->delete();

        $fasilitasMinggu = [
            '✅ 6 Sesi/Hari × 60 menit',
            '📘 Modul & Buku Kompetensi',
            '❄️ Ruang Kelas ber-AC & Nyaman',
            '🎁 Merchandise (Kaos dan Goodie Bag)',
            '🎓 Sertifikat',
            '💼 Enterpreneur Class',
            '🧠 Psychotraining Revolution',
            '📶 Wifi & Multimedia Class',
            '🍹 Welcome Drink',
            '🎉 Welcome Party (Opening Ceremony)',
            '🎉 Farewell Party (Art Exhibition)',
            '🚌 Gratis Penjemputan (Stasiun/Terminal)',
            '✅ Camp VIP',
        ];

        $fasilitasBulan1 = [
            '✅ 6 Kelas/Hari × 60 menit',
            '📘 Modul & Buku Kompetensi',
            '❄️ Ruang Kelas ber-AC & Nyaman',
            '🎁 Merchandise (Kaos dan Goodie Bag)',
            '🎓 Sertifikat',
            '🚌 Gratis Penjemputan (Stasiun/Terminal)',
            '💼 Enterpreneur Class',
            '🧠 Psychotraining Revolution',
            '📶 Wifi & Multimedia Class',
            '🍹 Welcome Drink',
            '🎉 Welcome Party (Opening Ceremony)',
            '🎉 Farewell Party (Art Exhibition)',
            '✅ Camp VIP',
        ];

        $fasilitasBulan2 = [
            '✅ 6 Kelas/Hari × 60 menit',
            '📘 Modul & Buku Kompetensi',
            '❄️ Ruang kelas ber-AC & nyaman',
            '🎁 Merchandise (Kaos dan Goodie Bag)',
            '🎓 Sertifikat',
            '🚌 Gratis penjemputan (Stasiun/Terminal)',
            '💼 Enterpreneur Class',
            '🧠 Psychotraining Revolution',
            '📶 Wifi & Multimedia Class',
            '🍹 Welcome Drink',
            '🎉 Welcome Party (Opening Ceremony)',
            '🎉 Farewell Party (Art Exhibition)',
            '✅ Camp VIP',
        ];

        $fasilitasBulan3 = [
            '✅ 6 Kelas/Hari × 60 menit',
            '✅ Gratis kelas Prep TOEFL',
            '📘 Modul & Buku Kompetensi',
            '❄️ Ruang kelas ber-AC & nyaman',
            '🎁 Merchandise (Kaos dan Goodie Bag)',
            '🎓 Sertifikat',
            '🚌 Gratis penjemputan (Stasiun/Terminal)',
            '💼 Enterpreneur Class',
            '🧠 Psychotraining Revolution',
            '📶 Wifi & Multimedia Class',
            '🍹 Welcome Drink',
            '🎉 Welcome Party (Opening Ceremony)',
            '🎉 Farewell Party (Art Exhibition)',
            '✅ Camp VIP',
        ];

        $programs = [
            [
                'nama'             => 'Program 1 Minggu',
                'lama_program'     => '1 Minggu',
                'kategori'         => 'Short Learning',
                'harga'            => 900000,
                'features_program' => json_encode($fasilitasMinggu),
            ],
            [
                'nama'             => 'Program 2 Minggu',
                'lama_program'     => '2 Minggu',
                'kategori'         => 'Short Learning',
                'harga'            => 1250000,
                'features_program' => json_encode($fasilitasMinggu),
            ],
            [
                'nama'             => 'Program 1 Bulan',
                'lama_program'     => '1 Bulan',
                'kategori'         => 'Reguler',
                'harga'            => 1700000,
                'features_program' => json_encode($fasilitasBulan1),
            ],
            [
                'nama'             => 'Program 2 Bulan',
                'lama_program'     => '2 Bulan',
                'kategori'         => 'Reguler',
                'harga'            => 2900000,
                'features_program' => json_encode($fasilitasBulan2),
            ],
            [
                'nama'             => 'Program 3 Bulan',
                'lama_program'     => '3 Bulan',
                'kategori'         => 'Master',
                'harga'            => 4099000,
                'features_program' => json_encode($fasilitasBulan3),
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
                'kursus'           => 'bieplus',
                'thumbnail'        => null,
            ]);
        }
    }
}
