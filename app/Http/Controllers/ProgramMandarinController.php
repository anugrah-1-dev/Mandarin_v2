<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramOnline;
use App\Models\ProgramOffline;

class ProgramMandarinController extends Controller
{
    public function showMandarin($kursus = 'brilliant')
    {
        $onlinePrograms = ProgramOnline::where('program_bahasa', 'Mandarin')
            ->where('kursus', $kursus)
            ->where('is_active', 1)
            ->get();

        $offlinePrograms = ProgramOffline::where('program_bahasa', 'Mandarin')
            ->where('kursus', $kursus)
            ->where('is_active', 1)
            ->get();

        if ($kursus === 'bieplus') {
            return view('Bieplus.mandarin', compact('onlinePrograms', 'offlinePrograms'));
        }

        return view('Landingpage.mandarin', compact('onlinePrograms', 'offlinePrograms'));
    }

    public function showOfflinePrograms($kursus = 'brilliant')
    {
        $offlinePrograms = ProgramOffline::where('program_bahasa', 'Mandarin')
            ->where('kursus', $kursus)
            ->where('is_active', 1)
            ->get();

        return view('Landingpage.program_offline', compact('offlinePrograms'));
    }

    public function showOnlinePrograms($kursus = 'brilliant')
    {
        $onlinePrograms = ProgramOnline::where('program_bahasa', 'Mandarin')
            ->where('kursus', $kursus)
            ->where('is_active', 1)
            ->get();

        return view('Landingpage.program_online', compact('onlinePrograms'));
    }
}
