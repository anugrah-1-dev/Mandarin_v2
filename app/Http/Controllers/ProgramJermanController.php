<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramOnline;
use App\Models\ProgramOffline;

class ProgramJermanController extends Controller
{
    public function showJerman($kursus = 'brilliant')
    {
        $onlinePrograms = ProgramOnline::where('program_bahasa', 'Jerman')
            ->where('kursus', $kursus)
            ->where('is_active', 1)
            ->get();

        $offlinePrograms = ProgramOffline::where('program_bahasa', 'Jerman')
            ->where('kursus', $kursus)
            ->where('is_active', 1)
            ->get();

        if ($kursus === 'bieplus') {
            return view('Bieplus.Jerman', compact('onlinePrograms', 'offlinePrograms'));
        }

        return view('Landingpage.Jerman', compact('onlinePrograms', 'offlinePrograms'));
    }
}
