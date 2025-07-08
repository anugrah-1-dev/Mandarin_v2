<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramCamp;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramCampController extends Controller
{
  public function index(Request $request)
{
    $query = ProgramCamp::query();

    // Cek apakah ada parameter pencarian dari input
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('nama', 'like', '%' . $search . '%');
    }

    // Gunakan withQueryString() agar parameter pencarian tetap terbawa saat pindah halaman
    $programs = $query->latest()->paginate(10);
    $programs->appends(request()->except('page'));


    return view('admin.programs.camp.index', compact('programs'));
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'stok' => 'nullable|integer',
            'harga_perhari' => 'nullable|integer',
            'harga_satu_minggu' => 'nullable|integer',
            'harga_dua_minggu' => 'nullable|integer',
            'harga_tiga_minggu' => 'nullable|integer',
            'harga_satu_bulan' => 'nullable|integer',
            'harga_dua_bulan' => 'nullable|integer',
            'harga_tiga_bulan' => 'nullable|integer',
            'harga_enam_bulan' => 'nullable|integer',
            'harga_satu_tahun' => 'nullable|integer',
            'fasilitas' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        // Slug otomatis jika tidak diisi
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama']);
        }

        // Upload thumbnail jika ada
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/camp'), $filename);
            $validated['thumbnail'] = $filename;
        }

        ProgramCamp::create($validated);

        return redirect()->back()->with('alert', [
            'title' => 'Berhasil!',
            'text' => 'Program berhasil ditambahkan.',
            'icon' => 'success',
        ]);
    }

    public function update(Request $request, $id)
    {
        $program = ProgramCamp::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'stok' => 'nullable|integer',
            'harga_perhari' => 'nullable|integer',
            'harga_satu_minggu' => 'nullable|integer',
            'harga_dua_minggu' => 'nullable|integer',
            'harga_tiga_minggu' => 'nullable|integer',
            'harga_satu_bulan' => 'nullable|integer',
            'harga_dua_bulan' => 'nullable|integer',
            'harga_tiga_bulan' => 'nullable|integer',
            'harga_enam_bulan' => 'nullable|integer',
            'harga_satu_tahun' => 'nullable|integer',
            'fasilitas' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        // Slug otomatis jika tidak diisi
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama']);
        }

        // Hapus thumbnail lama jika ada dan upload yang baru
        if ($request->hasFile('thumbnail')) {
            // Hapus file lama
            if ($program->thumbnail && file_exists(public_path('asset/upload/camp/' . $program->thumbnail))) {
                unlink(public_path('asset/upload/camp/' . $program->thumbnail));
            }

            // Simpan file baru
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/camp'), $filename);
            $validated['thumbnail'] = $filename;
        }

        $program->update($validated);

        return redirect()->back()->with('alert', [
            'title' => 'Berhasil!',
            'text' => 'Program berhasil diperbarui.',
            'icon' => 'success',
        ]);
    }

    public function destroy($id)
    {
        $program = ProgramCamp::findOrFail($id);

        // Hapus thumbnail dari folder jika ada
        if ($program->thumbnail && file_exists(public_path('upload/camp' . $program->thumbnail))) {
            unlink(public_path('upload/camp' . $program->thumbnail));
        }

        $program->forceDelete();

        return redirect()->back()->with('alert', [
            'title' => 'Berhasil!',
            'text' => 'Program berhasil dihapus.',
            'icon' => 'success',
        ]);
    }
}
