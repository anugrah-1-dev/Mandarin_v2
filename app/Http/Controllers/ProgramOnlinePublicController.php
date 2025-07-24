<?php

namespace App\Http\Controllers;

use App\Models\ProgramOnline;
use App\Models\Period;
use App\Models\PendaftaranProgramOnline;
use App\Models\Banks; // <-- Pastikan model Banks di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProgramOnlinePublicController extends Controller
{
    /**
     * Menampilkan detail program online.
     */
    public function show(ProgramOnline $program)
    {
        if (!$program->is_active) {
            abort(404);
        }
        $periods = Period::all();
        return view('programs.online.show', compact('program', 'periods'));
    }

    /**
     * Memproses pendaftaran untuk program online.
     */
    public function daftar(Request $request, ProgramOnline $program)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'required|string|max:20',
            'asal_kota' => 'nullable|string|max:100',
            'period_id' => 'required|exists:periods,id',
        ]);

        $today = Carbon::now()->format('Ymd');
        $prefix = 'TRX-ONL-' . $today . '-';

        $lastRegistration = PendaftaranProgramOnline::where('trx_id', 'like', $prefix . '%')
                                       ->orderBy('id', 'desc')
                                       ->first();
        $nextSequence = 1;
        if ($lastRegistration) {
            $lastSequence = (int) str_replace($prefix, '', $lastRegistration->trx_id);
            $nextSequence = $lastSequence + 1;
        }
        $newTrxId = $prefix . $nextSequence;

        PendaftaranProgramOnline::create([
            'trx_id' => $newTrxId,
            'program_id' => $program->id,
            'period_id' => $validated['period_id'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'asal_kota' => $validated['asal_kota'],
            'status' => 'pending',
        ]);

        // Arahkan ke halaman pembayaran online yang baru
        return redirect()->route('public.pendaftaran.online.pembayaran', ['trx_id' => $newTrxId])
                         ->with('success', 'Pendaftaran awal berhasil!');
    }

    /**
     * Menampilkan halaman pembayaran berdasarkan trx_id untuk program online.
     */
    public function halamanPembayaran($trx_id)
    {
        // Cari data pendaftaran berdasarkan trx_id
        $pendaftaran = PendaftaranProgramOnline::with('program')->where('trx_id', $trx_id)->firstOrFail();

        // Ambil data bank yang aktif dari database
        $banks = Banks::where('status', 'active')->get();

        // Tampilkan view pembayaran dan kirim data pendaftaran beserta data bank
        return view('pembayaran.index', compact('pendaftaran', 'banks'));
    }
}
