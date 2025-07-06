<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramOffline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class ProgramOfflineController extends Controller
{
    public function index()
    {
        $programs = ProgramOffline::latest()->paginate(10);
        // Ganti 'admin.program_offline.index' dengan path view Anda
        return view('admin.programs.offline.index', compact('programs'));
    }

    public function create()
    {
        // Ganti 'admin.program_offline.create' dengan path view Anda
        return view('admin.programs.offline.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'             => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:program_offline,slug',
            'lama_program'     => 'required|string|max:255',
            'kategori'         => 'required|string|max:100',
            'harga'            => 'required|numeric|min:0',
            'features_program' => 'required|string',
            'lokasi'           => 'required|string|max:255',
            'jadwal_mulai'     => 'required|date',
            'jadwal_selesai'   => 'required|date|after_or_equal:jadwal_mulai',
            'kuota'            => 'required|integer|min:1',
            'is_active'        => 'required|boolean',
            'thumbnail'        => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Konversi fitur dari teks ke array
        $features = array_filter(array_map('trim', explode("\n", $validated['features_program'])));
        $validated['features_program'] = $features;

        // Upload thumbnail
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails/program_offline', 'public');
        }

        // Simpan ke database
        ProgramOffline::create($validated);

        return redirect()->route('admin.offline.index')->with('success', 'Program offline berhasil ditambahkan.');
    }


    public function edit(ProgramOffline $program_offline)
    {
        // Ganti 'admin.program_offline.edit' dengan path view Anda
        return view('admin.offline.edit', ['program' => $program_offline]);
    }

    // public function update(UpdateRequest $request, ProgramOffline $program_offline)
    // {
    //     $validated = $request->validated();

    //     if ($request->hasFile('thumbnail')) {
    //         // Hapus thumbnail lama jika ada
    //         if ($program_offline->thumbnail) {
    //             Storage::disk('public')->delete($program_offline->thumbnail);
    //         }
    //         $path = $request->file('thumbnail')->store('public/program_offline/thumbnails');
    //         $validated['thumbnail'] = str_replace('public/', '', $path);
    //     }

    //     $validated['is_active'] = $request->has('is_active');
    //     $validated['features_program'] = json_decode($validated['features_program'], true) ?? [];

    //     $program_offline->update($validated);

    //     return redirect()->route('admin.program_offline.index')->with('success', 'Program Offline berhasil diperbarui.');
    // }

    public function destroy($id)
    {
        $program = ProgramOffline::findOrFail($id);

        // Hapus thumbnail jika ada
        if ($program->thumbnail && Storage::disk('public')->exists($program->thumbnail)) {
            Storage::disk('public')->delete($program->thumbnail);
        }

        // Soft delete (jika pakai SoftDeletes)
        $program->delete();

        return redirect()->route('admin.offline.index')->with('success', 'Program offline berhasil dihapus.');
    }
}
