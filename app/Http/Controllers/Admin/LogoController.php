<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    public function index()
    {
        $logo = Logo::first();
        return view('admin.logos.index', compact('logo'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        $logo = Logo::first();

        if ($logo && $logo->image_path) {
            Storage::disk('public')->delete($logo->image_path);
        }

        $path = $request->file('image_path')->store('logos', 'public');

        if ($logo) {
            $logo->update(['image_path' => $path]);
        } else {
            Logo::create(['image_path' => $path]);
        }

        return redirect()->route('admin.logos.index')->with('alert', [
            'icon'  => 'success',
            'title' => 'Berhasil!',
            'text'  => 'Logo landing page berhasil diperbarui.',
        ]);
    }
}
