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
        $logo1 = Logo::where('key', 'logo1')->first();
        $logo2 = Logo::where('key', 'logo2')->first();
        return view('admin.logos.index', compact('logo1', 'logo2'));
    }

    public function update(Request $request, string $key)
    {
        $request->validate([
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        $logo = Logo::where('key', $key)->first();

        if ($logo && $logo->image_path) {
            Storage::disk('public')->delete($logo->image_path);
        }

        $path = $request->file('image_path')->store('logos', 'public');

        if ($logo) {
            $logo->update(['image_path' => $path]);
        } else {
            Logo::create(['key' => $key, 'image_path' => $path]);
        }

        $label = $key === 'logo1' ? 'Logo 1' : 'Logo 2';

        return redirect()->route('admin.logos.index')->with('alert', [
            'icon'  => 'success',
            'title' => 'Berhasil!',
            'text'  => $label . ' berhasil diperbarui.',
        ]);
    }

    public function destroy(string $key)
    {
        $logo = Logo::where('key', $key)->first();

        if ($logo && $logo->image_path) {
            Storage::disk('public')->delete($logo->image_path);
            $logo->update(['image_path' => null]);
        }

        $label = $key === 'logo1' ? 'Logo 1' : 'Logo 2';

        return redirect()->route('admin.logos.index')->with('alert', [
            'icon'  => 'success',
            'title' => 'Berhasil!',
            'text'  => $label . ' berhasil dihapus.',
        ]);
    }
}
