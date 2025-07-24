<?php

namespace App\Helpers;

class RoomDummy
{
    public static function getRooms()
    {
        $rooms = [];

        // VVIP
        foreach (range(19, 28) as $i) {
            $rooms[] = (object)['nomor_kamar' => "A-{$i}", 'status' => 'vvip', 'penghuni' => 0];
        }

        // VIP - A
        foreach (range(1, 18) as $i) {
            $rooms[] = (object)['nomor_kamar' => sprintf("A-%02d", $i), 'status' => 'vip', 'penghuni' => 0];
        }
        foreach (range(29, 46) as $i) {
            $rooms[] = (object)['nomor_kamar' => "A-{$i}", 'status' => 'vip', 'penghuni' => 0];
        }

        // VIP - B
        foreach (range(1, 50) as $i) {
            $rooms[] = (object)['nomor_kamar' => "B-{$i}", 'status' => 'vip', 'penghuni' => 0];
        }
        $rooms[] = (object)['nomor_kamar' => 'B-12B', 'status' => 'vip', 'penghuni' => 0];

        // VIP - C
        foreach (range(1, 50) as $i) {
            $rooms[] = (object)['nomor_kamar' => "C-{$i}", 'status' => 'vip', 'penghuni' => 0];
        }
        $rooms[] = (object)['nomor_kamar' => 'C-12C', 'status' => 'vip', 'penghuni' => 0];

        // BARACK
        $rooms[] = (object)['nomor_kamar' => 'A-12A', 'status' => 'barack', 'penghuni' => 0];
        $rooms[] = (object)['nomor_kamar' => 'A-35',  'status' => 'barack', 'penghuni' => 0];

        return collect($rooms);
    }

    public static function filter($rooms, $prefix, $start, $end, $gender = null)
    {
        return collect($rooms)->filter(function ($room) use ($prefix, $start, $end, $gender) {
            // Ambil nomor kamar tanpa prefix
            $roomNumber = intval(str_replace($prefix . '-', '', $room->nomor_kamar));
            $matchesPrefix = str_starts_with($room->nomor_kamar, $prefix . '-');
            $matchesRange = $roomNumber >= $start && $roomNumber <= $end;
            $matchesGender = $gender ? $room->gender === $gender : true;

            return $matchesPrefix && $matchesRange && $matchesGender;
        });
    }

    public static function getStatusClass($room)
    {
        $penghuni = $room->penghuni ?? 0;
        $kapasitas = $room->kapasitas ?? 1; // fallback biar aman

        return match (true) {
            $penghuni >= $kapasitas => 'room-full',
            $penghuni > 0 => 'room-partial',
            default => 'room-empty'
        };
    }

    public static function getStatusText($room)
    {
        $penghuni = $room->penghuni ?? 0;
        $kapasitas = $room->kapasitas ?? 1;

        return match (true) {
            $penghuni >= $kapasitas => 'Penuh',
            $penghuni > 0 => 'Hampir Penuh',
            default => 'Kosong'
        };
    }



    public static function warna($room)
    {
        $penghuni = $room->penghuni ?? 0;
        $nomor = $room->nomor_kamar;

        // BARACK
        if (in_array($nomor, ['A-12A', 'A-35'])) {
            return match (true) {
                $penghuni === 0 => '#22c55e',
                $penghuni === 1 => '#a0522d',
                $penghuni === 2 => '#800080',
                $penghuni === 3 => '#ffa500',
                $penghuni === 4 => '#3b82f6',
                $penghuni >= 5 => '#ef4444',
                default => '#d1d5db'
            };
        }

        // VVIP / VIP
        return match ($penghuni) {
            0 => '#22c55e',
            1 => '#facc15',
            default => '#ef4444'
        };
    }
}
