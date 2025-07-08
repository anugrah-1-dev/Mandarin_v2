<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Gallery;
use App\Models\GalleryImage;

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

        return view('landingpage', [
            'programs' => $programs,
            'galleries' => $galleries, // <- variabel yang konsisten dengan view
        ]);
    }
}
