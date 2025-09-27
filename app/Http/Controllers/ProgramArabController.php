<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramOnline;
use App\Models\ProgramOffline;

class ProgramArabController extends Controller
{
    public function showArab($kursus = 'brilliant')
    {
        $onlinePrograms = ProgramOnline::where('program_bahasa', 'Arab')
            ->where('kursus', $kursus)
            ->where('is_active', 1)
            ->get();

        $offlinePrograms = ProgramOffline::where('program_bahasa', 'Arab')
            ->where('kursus', $kursus)
            ->where('is_active', 1)
            ->get();

        if ($kursus === 'bieplus') {
            return view('Bieplus.arab', compact('onlinePrograms', 'offlinePrograms'));
        }

        return view('Landingpage.arab', compact('onlinePrograms', 'offlinePrograms'));
    }
}
