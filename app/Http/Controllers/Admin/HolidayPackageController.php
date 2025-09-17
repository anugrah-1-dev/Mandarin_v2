<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HolidayPackage;
use App\Models\HolidayImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HolidayPackageController extends Controller
{
    public function index()
    {
        $holidays = HolidayPackage::with('images')->latest()->paginate(10);
        return view('admin.holiday.index', compact('holidays'));
    }

    public function create()
    {
        return view('admin.holiday.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket'     => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'fasilitas'      => 'nullable|array',
            'harga'          => 'required|numeric|min:0',
            'harga_promo'    => 'nullable|numeric|lte:harga|min:0',
            'minimal_orang'  => 'nullable|integer|min:1',
            'durasi_hari'    => 'nullable|integer|min:1',
            'status'         => 'required|in:aktif,nonaktif',
            'gambar_cover'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'images.*'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        // dd($request->all());
        // Ambil data yang diperlukan
        $data = $request->only([
            'nama_paket',
            'deskripsi',
            'harga',
            'harga_promo',
            'minimal_orang',
            'durasi_hari',
            'status'
        ]);

        // simpan fasilitas sebagai JSON jika ada
        if ($request->filled('fasilitas')) {
            $data['fasilitas'] = json_encode($request->fasilitas);
        }


        // upload gambar cover
        if ($request->hasFile('gambar_cover')) {
            $data['gambar_cover'] = $request->file('gambar_cover')
                ->store('holiday/cover', 'public');
        }

        // simpan data holiday package
        $package = HolidayPackage::create($data);

        // upload multiple images jika ada
        if ($request->hasFile('images')) {
            $urutan = 1;
            foreach ($request->file('images') as $file) {
                $path = $file->store('holiday/images', 'public');
                HolidayImage::create([
                    'holiday_package_id' => $package->id,
                    'image_path' => $path,
                    'urutan' => $urutan++, // supaya bisa diurutkan nanti
                ]);
            }
        }

        return redirect()
            ->route('admin.holiday.index')
            ->with('success', 'Holiday package berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $holidayPackage = HolidayPackage::with('images')->findOrFail($id);
        return view('admin.holiday.edit', compact('holidayPackage'));
    }

    public function update(Request $request, HolidayPackage $holidayPackage)
    {
        $request->validate([
            'nama_paket'     => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'fasilitas'      => 'nullable|array',
            'harga'          => 'required|numeric',
            'harga_promo'    => 'nullable|numeric',
            'minimal_orang'  => 'nullable|integer',
            'durasi_hari'    => 'nullable|integer',
            'status'         => 'required|in:aktif,nonaktif',
            'gambar_cover'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'images.*'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'nama_paket',
            'deskripsi',
            'harga',
            'harga_promo',
            'minimal_orang',
            'durasi_hari',
            'status'
        ]);

        if ($request->has('fasilitas')) {
            $data['fasilitas'] = json_encode($request->fasilitas);
        }

        if ($request->hasFile('gambar_cover')) {
            if ($holidayPackage->gambar_cover) {
                Storage::disk('public')->delete($holidayPackage->gambar_cover);
            }
            $data['gambar_cover'] = $request->file('gambar_cover')->store('holiday/cover', 'public');
        }

        $holidayPackage->update($data);

        if ($request->hasFile('images')) {
            foreach ($holidayPackage->images as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
            foreach ($request->file('images') as $file) {
                $path = $file->store('holiday/images', 'public');
                HolidayImage::create([
                    'holiday_package_id' => $holidayPackage->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.holiday.index')->with('success', 'Holiday package berhasil diperbarui!');
    }

    public function destroy(HolidayPackage $holidayPackage)
    {
        if ($holidayPackage->gambar_cover) {
            Storage::disk('public')->delete($holidayPackage->gambar_cover);
        }

        foreach ($holidayPackage->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $holidayPackage->delete();

        return redirect()->route('admin.holiday.index')->with('success', 'Holiday package berhasil dihapus!');
    }
}
