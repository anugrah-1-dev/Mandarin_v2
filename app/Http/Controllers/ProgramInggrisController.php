<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramOnline;
use App\Models\ProgramOffline;

class ProgramInggrisController extends Controller
{
    public function showInggris($kursus = 'brilliant')
    {
        $onlinePrograms = ProgramOnline::where('program_bahasa', 'Inggris')
            ->where('kursus', $kursus)
            ->where('is_active', 1)
            ->get();

        $offlinePrograms = ProgramOffline::where('program_bahasa', 'Inggris')
            ->where('kursus', $kursus)
            ->where('is_active', 1)
            ->get();

        // Convert features_program JSON ke array
        foreach ($onlinePrograms as $program) {
            $program->features_program = !empty($program->features_program)
                ? json_decode($program->features_program, true) ?? []
                : [];
        }
        foreach ($offlinePrograms as $program) {
            $program->features_program = !empty($program->features_program)
                ? json_decode($program->features_program, true) ?? []
                : [];
        }

        // Pilih view sesuai kursus
        return $kursus === 'bieplus'
            ? view('Bieplus.inggris', compact('onlinePrograms', 'offlinePrograms'))
            : view('Landingpage.inggris', compact('onlinePrograms', 'offlinePrograms'));
    }
}
