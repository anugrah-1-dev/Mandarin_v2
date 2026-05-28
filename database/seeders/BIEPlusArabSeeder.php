<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramOffline;
use App\Models\ProgramOnline;
use Illuminate\Support\Str;

class BIEPlusArabSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama Arab di bieplus
        ProgramOffline::where('kursus', 'bieplus')->where('program_bahasa', 'Arab')->delete();
        ProgramOnline::where('kursus', 'bieplus')->where('program_bahasa', 'Arab')->delete();

        $benefitCamp = [
            '6 kali pertemuan sehari (4 sesi kelas & 2 kegiatan asrama)',
            'Pengajar berpengalaman',
            'Metode bervariasi',
            'Program tambahan: Khithobah, Diroasah Jama\'iyyah, Musyahadah, Fashl Khoriji',
        ];

        $benefitOnline = [
            '2x pertemuan 90 menit/hari',
            'Pengajar berpengalaman',
            'Metode bervariasi',
            'Program tambahan: Khithobah, Diroasah, Musyahadah, Munaqosyah',
        ];

        $programsOffline = [
            [
                'nama'             => "Muhadatsah I'dad",
                'lama_program'     => '1 Bulan',
                'kategori'         => "Muhadatsah - 1 Bulan (Program + Camp)",
                'harga'            => 775000,
                'features_program' => json_encode(array_merge(["Muhadatsah I'dad"], $benefitCamp)),
            ],
            [
                'nama'             => 'Muhadatsah Mustawa Awwal',
                'lama_program'     => '1 Bulan',
                'kategori'         => 'Muhadatsah - 1 Bulan (Program + Camp)',
                'harga'            => 775000,
                'features_program' => json_encode(array_merge(['Muhadatsah Mustawa Awwal'], $benefitCamp)),
            ],
            [
                'nama'             => 'Muhadatsah Mustawa Tsani',
                'lama_program'     => '1 Bulan',
                'kategori'         => 'Muhadatsah - 1 Bulan (Program + Camp)',
                'harga'            => 775000,
                'features_program' => json_encode(array_merge(['Muhadatsah Mustawa Tsani'], $benefitCamp)),
            ],
            [
                'nama'             => 'Muhadatsah Mustawa Tsalits',
                'lama_program'     => '1 Bulan',
                'kategori'         => 'Muhadatsah - 1 Bulan (Program + Camp)',
                'harga'            => 775000,
                'features_program' => json_encode(array_merge(['Muhadatsah Mustawa Tsalits'], $benefitCamp)),
            ],
            [
                'nama'             => 'Baca Kitab Tamhid',
                'lama_program'     => '2 Pekan',
                'kategori'         => 'Baca Kitab - 2 Pekan (Program + Camp)',
                'harga'            => 475000,
                'features_program' => json_encode(array_merge(['Baca Kitab Tamhid'], $benefitCamp)),
            ],
            [
                'nama'             => 'Baca Kitab Muthawassith',
                'lama_program'     => '2 Pekan',
                'kategori'         => 'Baca Kitab - 2 Pekan (Program + Camp)',
                'harga'            => 475000,
                'features_program' => json_encode(array_merge(['Baca Kitab Muthawassith'], $benefitCamp)),
            ],
            [
                'nama'             => 'Baca Kitab Mutaqaddim',
                'lama_program'     => '2 Pekan',
                'kategori'         => 'Baca Kitab - 2 Pekan (Program + Camp)',
                'harga'            => 475000,
                'features_program' => json_encode(array_merge(['Baca Kitab Mutaqaddim'], $benefitCamp)),
            ],
            [
                'nama'             => 'Baca Kitab Tarjamah',
                'lama_program'     => '2 Pekan',
                'kategori'         => 'Baca Kitab - 2 Pekan (Program + Camp)',
                'harga'            => 475000,
                'features_program' => json_encode(array_merge(['Baca Kitab Tarjamah'], $benefitCamp)),
            ],
        ];

        foreach ($programsOffline as $data) {
            ProgramOffline::create([
                'nama'             => $data['nama'],
                'slug'             => Str::slug($data['nama']) . '-arab-bieplus',
                'program_bahasa'   => 'Arab',
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

        $programsOnline = [
            [
                'nama'             => "Muhadatsah I'dad",
                'lama_program'     => '1 Bulan',
                'kategori'         => "Muhadatsah - 1 Bulan (Online non Camp)",
                'harga'            => 396000,
                'features_program' => json_encode(array_merge(["Muhadatsah I'dad"], $benefitOnline)),
            ],
            [
                'nama'             => 'Muhadatsah Mustawa Awwal',
                'lama_program'     => '1 Bulan',
                'kategori'         => 'Muhadatsah - 1 Bulan (Online non Camp)',
                'harga'            => 396000,
                'features_program' => json_encode(array_merge(['Muhadatsah Mustawa Awwal'], $benefitOnline)),
            ],
            [
                'nama'             => 'Muhadatsah Mustawa Tsani',
                'lama_program'     => '1 Bulan',
                'kategori'         => 'Muhadatsah - 1 Bulan (Online non Camp)',
                'harga'            => 396000,
                'features_program' => json_encode(array_merge(['Muhadatsah Mustawa Tsani'], $benefitOnline)),
            ],
            [
                'nama'             => 'Muhadatsah Mustawa Tsalits',
                'lama_program'     => '1 Bulan',
                'kategori'         => 'Muhadatsah - 1 Bulan (Online non Camp)',
                'harga'            => 396000,
                'features_program' => json_encode(array_merge(['Muhadatsah Mustawa Tsalits'], $benefitOnline)),
            ],
            [
                'nama'             => 'Baca Kitab Tamhid',
                'lama_program'     => '2 Pekan',
                'kategori'         => 'Baca Kitab - 2 Pekan (Online non Camp)',
                'harga'            => 189000,
                'features_program' => json_encode(array_merge(['Baca Kitab Tamhid'], $benefitOnline)),
            ],
            [
                'nama'             => 'Baca Kitab Muthawassith',
                'lama_program'     => '2 Pekan',
                'kategori'         => 'Baca Kitab - 2 Pekan (Online non Camp)',
                'harga'            => 189000,
                'features_program' => json_encode(array_merge(['Baca Kitab Muthawassith'], $benefitOnline)),
            ],
            [
                'nama'             => 'Baca Kitab Mutaqaddim',
                'lama_program'     => '2 Pekan',
                'kategori'         => 'Baca Kitab - 2 Pekan (Online non Camp)',
                'harga'            => 189000,
                'features_program' => json_encode(array_merge(['Baca Kitab Mutaqaddim'], $benefitOnline)),
            ],
            [
                'nama'             => 'Baca Kitab Tarjamah',
                'lama_program'     => '2 Pekan',
                'kategori'         => 'Baca Kitab - 2 Pekan (Online non Camp)',
                'harga'            => 189000,
                'features_program' => json_encode(array_merge(['Baca Kitab Tarjamah'], $benefitOnline)),
            ],
        ];

        foreach ($programsOnline as $program) {
            ProgramOnline::create([
                'nama'             => $program['nama'],
                'slug'             => Str::slug($program['nama']) . '-arab-bieplus',
                'program_bahasa'   => 'Arab',
                'lama_program'     => $program['lama_program'],
                'kategori'         => $program['kategori'],
                'harga'            => $program['harga'],
                'features_program' => $program['features_program'],
                'is_active'        => 1,
                'kursus'           => 'bieplus',
                'thumbnail'        => null,
            ]);
        }
    }
}
