<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CateringPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CateringPackageController extends Controller
{
    public function index()
    {
        $caterings = CateringPackage::latest()->paginate(10);
        return view('admin.catering.index', compact('caterings'));
    }

    public function create()
    {
        return view('admin.catering.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'thumbnail'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nama_paket'      => 'required|string|max:255',
            'harga'           => 'required|numeric',
            'periode'         => 'required|integer',
            // 'jam_pengantaran' => 'nullable|string|max:255',
            'status'          => 'required|in:aktif,nonaktif',
            'deskripsi'       => 'nullable|string',
        ]);

        $data = $request->only([
            'nama_paket',
            'harga',
            'periode',
            // 'jam_pengantaran',
            'status',
            'deskripsi'
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('catering/thumbnails', 'public');
        }

        CateringPackage::create($data);

        return redirect()->route('admin.catering.index')
            ->with('success', 'Paket Catering berhasil ditambahkan!');
    }

    public function edit(CateringPackage $cateringPackage)
    {
        return view('admin.catering.edit', compact('cateringPackage'));
    }

    public function update(Request $request, CateringPackage $cateringPackage)
    {
        $request->validate([
            'nama_paket'      => 'required|string|max:255',
            'harga'           => 'required|numeric',
            'periode'         => 'required|integer',
            // 'jam_pengantaran' => 'nullable|string|max:255',
            'status'          => 'required|in:aktif,nonaktif',
            'deskripsi'       => 'nullable|string',
            'thumbnail'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'nama_paket',
            'harga',
            'periode',
            // 'jam_pengantaran',
            'status',
            'deskripsi'
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($cateringPackage->thumbnail) {
                Storage::disk('public')->delete($cateringPackage->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('catering/thumbnails', 'public');
        }

        $cateringPackage->update($data);

        return redirect()->route('admin.catering.index')->with('success', 'Catering package berhasil diperbarui!');
    }

    public function destroy(CateringPackage $cateringPackage)
    {
        if ($cateringPackage->thumbnail) {
            Storage::disk('public')->delete($cateringPackage->thumbnail);
        }

        $cateringPackage->delete();
        return redirect()->route('admin.catering.index')->with('success', 'Catering package berhasil dihapus!');
    }
}
