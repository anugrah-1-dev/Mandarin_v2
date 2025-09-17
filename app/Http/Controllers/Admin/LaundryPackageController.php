<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaundryPackage;
use Illuminate\Http\Request;

class LaundryPackageController extends Controller
{
    public function index()
    {
        $laundries = LaundryPackage::latest()->paginate(10);
        return view('admin.laundry.index', compact('laundries'));
    }

    public function create()
    {
        return view('admin.laundry.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket'         => 'required|string|max:255',
            'harga'              => 'required|numeric',
            'jenis'              => 'nullable|string|max:255',
            'periode'            => 'nullable|integer',
            // 'tanggal_penjemputan' => 'nullable|date',
            'status'             => 'required|in:aktif,nonaktif',
            'deskripsi'          => 'nullable|string',
        ]);

        LaundryPackage::create($request->all());

        return redirect()->route('admin.laundry.index')->with('success', 'Laundry package berhasil ditambahkan!');
    }

    public function edit(LaundryPackage $laundryPackage)
    {
        return view('admin.laundry.edit', compact('laundryPackage'));
    }

    public function update(Request $request, LaundryPackage $laundryPackage)
    {
        $request->validate([
            'nama_paket'         => 'required|string|max:255',
            'harga'              => 'required|numeric',
            'jenis'              => 'nullable|string|max:255',
            'periode'            => 'nullable|integer',
            // 'tanggal_penjemputan' => 'nullable|date',
            'status'             => 'required|in:aktif,nonaktif',
            'deskripsi'          => 'nullable|string',
        ]);

        $laundryPackage->update($request->all());

        return redirect()->route('admin.laundry.index')->with('success', 'Laundry package berhasil diperbarui!');
    }

    public function destroy(LaundryPackage $laundryPackage)
    {
        $laundryPackage->delete();
        return redirect()->route('admin.laundry.index')->with('success', 'Laundry package berhasil dihapus!');
    }
}
