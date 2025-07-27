<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranProgramOnline; // Import model Online
use App\Models\PendaftaranProgramOffline; // Import model Offline
use App\Models\PendaftaranProgramCamp; // Import model Camp

class PaymentController extends Controller
{
    /**
     * Mengunggah bukti pembayaran dan menyimpannya ke database.
     */

    public function uploadProof(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|in:online,offline,camp',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // 2. Ambil model berdasarkan tipe
        $pendaftaran = match ($request->type) {
            'online' => PendaftaranProgramOnline::find($request->id),
            'offline' => PendaftaranProgramOffline::find($request->id),
            'camp' => PendaftaranProgramCamp::find($request->id),
            default => null,
        };

        if (!$pendaftaran) {
            return back()->withErrors(['msg' => 'Data pendaftaran tidak ditemukan.']);
        }

        // 3. Simpan file ke storage dan catat path-nya
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');

            // Buat nama unik berdasarkan timestamp dan ID
            $filename = 'bukti_' . $pendaftaran->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Simpan ke folder public/bukti_pembayaran
            $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

            // Simpan path file ke database (misalnya kolom: bukti_pembayaran_path)
            $pendaftaran->bukti_pembayaran = $path;
            $pendaftaran->status = 'pending';
            $pendaftaran->save();

            return back()->with('success', 'Bukti pembayaran berhasil diunggah!');
        }

        return back()->withErrors(['msg' => 'Gagal mengunggah file.']);
    }
}
