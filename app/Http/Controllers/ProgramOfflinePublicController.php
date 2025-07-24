<?php

namespace App\Http\Controllers;

// Import kelas yang dibutuhkan
use App\Models\ProgramOffline;
use App\Models\Transports;
use App\Models\Period;
use App\Models\PendaftaranProgramOffline;
use App\Models\Banks; // <-- Pastikan model Banks di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProgramOfflinePublicController extends Controller
{
    /**
     * Menampilkan detail program offline beserta form pendaftaran.
     */
    public function showOfflinePublic(ProgramOffline $program)
    {
        $transports = Transports::all();
        $periods = Period::all();
        return view('programs.offline.show', compact('program', 'transports', 'periods'));
    }

    /**
     * Memproses pendaftaran untuk program offline.
     */
    public function daftar(Request $request, ProgramOffline $program)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'required|string|max:20',
            'asal_kota' => 'nullable|string|max:100',
            'no_wali' => 'nullable|string|max:20',
            'period_id' => 'required|exists:periods,id',
            'transport_id' => 'nullable|exists:transports,id',
            // 'bukti_pembayaran' tidak divalidasi di sini lagi jika akan diupload di halaman terpisah
        ]);

        $today = Carbon::now()->format('Ymd');
        $prefix = 'TRX-' . $today . '-';

        $lastRegistration = PendaftaranProgramOffline::where('trx_id', 'like', $prefix . '%')
                                       ->orderBy('id', 'desc')
                                       ->first();
        $nextSequence = 1;
        if ($lastRegistration) {
            $lastSequence = (int) str_replace($prefix, '', $lastRegistration->trx_id);
            $nextSequence = $lastSequence + 1;
        }
        $newTrxId = $prefix . $nextSequence;

        PendaftaranProgramOffline::create([
            'trx_id' => $newTrxId,
            'program_id' => $program->id,
            'period_id' => $validated['period_id'],
            'transport_id' => $validated['transport_id'] ?? null,
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'asal_kota' => $validated['asal_kota'] ?? null,
            'no_wali' => $validated['no_wali'] ?? null,
            'status' => 'pending',
        ]);
        
        return redirect()->route('public.pendaftaran.offline.pembayaran', ['trx_id' => $newTrxId])
                         ->with('success', 'Pendaftaran awal berhasil!');
    }

    /**
     * Menampilkan halaman pembayaran berdasarkan trx_id.
     */
    public function halamanPembayaran($trx_id)
    {
        // Cari data pendaftaran berdasarkan trx_id.
        $pendaftaran = PendaftaranProgramOffline::with('program')->where('trx_id', $trx_id)->firstOrFail();

        // **PERBAIKAN:** Ambil data bank yang aktif dari database.
        $banks = Banks::where('status', 'active')->get();

        // Tampilkan view pembayaran dan kirim data pendaftaran BESERTA data bank.
        return view('pembayaran.index', compact('pendaftaran', 'banks'));
    }
}
