<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\ProgramOffline;
use App\Models\ProgramOnline;
use App\Models\ProgramCamp;

class LandingPageController extends Controller
{
    public function index()
    {
    $programs = Program::orderBy('id', 'asc')->get();

        // Ambil galeri aktif beserta gambar-gambarnya
    $galleries = Gallery::where('status', 1)
            ->with('images') // eager loading agar tidak N+1
            ->latest()
            ->get();
    $offlinePrograms = ProgramOffline::where('is_active', 1)->latest()->get();

    // 2. Ambil data program online yang aktif
    $onlinePrograms = ProgramOnline::where('is_active', 1)->latest()->get();

    $camps = ProgramCamp::orderBy('id', 'asc')->get();
        // 2. Kirim data tersebut ke view 'landingpage'
        //    Variabel $programs sekarang akan tersedia di dalam view
        return view('landingpage', [
            'offlinePrograms' => $offlinePrograms,
            'onlinePrograms'  => $onlinePrograms,
            'programs' => $programs,
            'galleries' => $galleries, // <- variabel yang konsisten dengan view
            'camps'    => $camps, 
        ]);
    }
}
