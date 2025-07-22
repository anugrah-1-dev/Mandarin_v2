<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramCamp;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File; // Gunakan File facade untuk operasi file
use Illuminate\Support\Facades\Storage;

class ProgramCampController extends Controller
{
    public function index(Request $request)
    {
        $query = ProgramCamp::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', '%' . $search . '%');
        }

        // Menggunakan appends() agar parameter pencarian tetap ada saat paginasi
        $programs = $query->latest()->paginate(10);
        $programs->appends($request->all());

        return view('admin.programs.camp.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.camp.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|max:2048',
            // Tambahkan validasi lain jika perlu
        ]);

        $data = $request->except(['_token']);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nama']);
        }

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = Str::slug($data['nama']) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/camp'), $filename);
            $data['thumbnail'] = $filename;
        }

        ProgramCamp::create($data);

        // Setelah berhasil, redirect ke halaman index
        return redirect()->route('admin.programs.camp.index')->with('alert', [
            'title' => 'Berhasil!', 'text' => 'Program berhasil ditambahkan.', 'icon' => 'success',
        ]);
    }

    public function edit($id)
    {
        $program = ProgramCamp::findOrFail($id);
        return view('admin.programs.camp.edit', compact('program'));
    }


    public function update(Request $request, $id)
    {
        $program = ProgramCamp::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|max:2048',
            // Tambahkan validasi lain jika perlu
        ]);

        $data = $request->except(['_token', '_method']);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nama']);
        }

        if ($request->hasFile('thumbnail')) {
            // Hapus file lama jika ada
            if ($program->thumbnail && File::exists(public_path('upload/camp/' . $program->thumbnail))) {
                File::delete(public_path('upload/camp/' . $program->thumbnail));
            }

            $file = $request->file('thumbnail');
            $filename = Str::slug($request->nama) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/camp'), $filename);
            $data['thumbnail'] = $filename;
        }

        $program->update($data);

        return redirect()->route('admin.programs.camp.index')->with('alert', [
            'title' => 'Berhasil!', 'text' => 'Program berhasil diperbarui.', 'icon' => 'success',
        ]);
    }

    public function destroy($id)
    {
        $program = ProgramCamp::findOrFail($id);

        // Hapus thumbnail dari folder jika ada
        if ($program->thumbnail && File::exists(public_path('upload/camp/' . $program->thumbnail))) {
            File::delete(public_path('upload/camp/' . $program->thumbnail));
        }

        $program->delete();

        return redirect()->back()->with('alert', [
            'title' => 'Berhasil!', 'text' => 'Program berhasil dihapus.', 'icon' => 'success',
        ]);
    }

 
    /**
     * Menampilkan halaman daftar semua camp untuk publik.
     */


}
