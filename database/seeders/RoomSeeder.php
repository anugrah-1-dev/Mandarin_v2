<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoomSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $rooms = [
            // KAMAR VVIP (program_camp_id = 1)
            // VVIP Putri
            ['program_camp_id' => 1, 'nomor_kamar' => 'A-19', 'gender' => 'putri', 'kategori' => 'VVIP', 'kapasitas' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['program_camp_id' => 1, 'nomor_kamar' => 'A-20', 'gender' => 'putri', 'kategori' => 'VVIP', 'kapasitas' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['program_camp_id' => 1, 'nomor_kamar' => 'A-21', 'gender' => 'putri', 'kategori' => 'VVIP', 'kapasitas' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['program_camp_id' => 1, 'nomor_kamar' => 'A-22', 'gender' => 'putri', 'kategori' => 'VVIP', 'kapasitas' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['program_camp_id' => 1, 'nomor_kamar' => 'A-23', 'gender' => 'putri', 'kategori' => 'VVIP', 'kapasitas' => 3, 'created_at' => $now, 'updated_at' => $now],
            // VVIP Putra
            ['program_camp_id' => 1, 'nomor_kamar' => 'A-24', 'gender' => 'putra', 'kategori' => 'VVIP', 'kapasitas' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['program_camp_id' => 1, 'nomor_kamar' => 'A-25', 'gender' => 'putra', 'kategori' => 'VVIP', 'kapasitas' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['program_camp_id' => 1, 'nomor_kamar' => 'A-26', 'gender' => 'putra', 'kategori' => 'VVIP', 'kapasitas' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['program_camp_id' => 1, 'nomor_kamar' => 'A-27', 'gender' => 'putra', 'kategori' => 'VVIP', 'kapasitas' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['program_camp_id' => 1, 'nomor_kamar' => 'A-28', 'gender' => 'putra', 'kategori' => 'VVIP', 'kapasitas' => 3, 'created_at' => $now, 'updated_at' => $now],
        ];


        foreach (range(1, 18) as $num) {
            $rooms[] = $this->makeRoom(2, 'A', $num, 'putri', 'VIP', $now);
        }

        // A-29 s/d A-46 (Putra) KECUALI A-35
        foreach (range(29, 46) as $num)     {
            if ($num == 35) continue;
            if ($num <= 28 && $num >= 24) continue;
            $rooms[] = $this->makeRoom(2, 'A', $num, 'putra', 'VIP', $now);
        }

        // B-01 s/d B-25 (Putri)
        foreach (range(1, 25) as $num) {
            $rooms[] = $this->makeRoom(2, 'B', $num, 'putri', 'VIP', $now);
        }

        // B-26 s/d B-50 (Putra)
        foreach (range(26, 50) as $num) {
            $rooms[] = $this->makeRoom(2, 'B', $num, 'putra', 'VIP', $now);
        }

        // C-01 s/d C-25 (Putri)
        foreach (range(1, 25) as $num) {
            $rooms[] = $this->makeRoom(2, 'C', $num, 'putri', 'VIP', $now);
        }

        // C-26 s/d C-50 (Putra)
        foreach (range(26, 50) as $num) {
            $rooms[] = $this->makeRoom(2, 'C', $num, 'putra', 'VIP', $now);
        }

        // KAMAR BARACK (program_camp_id = 3)
        $rooms[] = ['program_camp_id' => 3, 'nomor_kamar' => 'A-12A', 'gender' => 'putri', 'kategori' => 'Barack', 'kapasitas' => 3, 'created_at' => $now, 'updated_at' => $now];
        $rooms[] = ['program_camp_id' => 3, 'nomor_kamar' => 'A-35', 'gender' => 'putra', 'kategori' => 'Barack', 'kapasitas' => 4, 'created_at' => $now, 'updated_at' => $now];

        DB::table('rooms')->insert($rooms);
    }

    private function makeRoom($program_camp_id, $block, $num, $gender, $kategori, $now)
    {
        $nomor_kamar = $block . '-' . str_pad($num, 2, '0', STR_PAD_LEFT);
        return [
            'program_camp_id' => $program_camp_id,
            'nomor_kamar' => $nomor_kamar,
            'gender' => $gender,
            'kategori' => $kategori,
            'kapasitas' => 4, // default kapasitas, sesuaikan jika perlu
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }
}
