<?php

namespace App\Http\Controllers;

// Import kelas yang dibutuhkan
use App\Models\ProgramOffline;
use App\Models\Transports;
use App\Models\Period;
use App\Models\PendaftaranProgramOffline;
use App\Models\Banks;
use App\Models\Customer_Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\ProgramCamp;

class ProgramOfflinePublicController extends Controller
{
    /**
     * Menampilkan detail program offline beserta form pendaftaran.
     */
    public function showOfflinePublic(ProgramOffline $program)
    {
        $transports = Transports::all();
        $periods = Period::where('is_active', 1)->get();
        $banks = Banks::where('status', 'active')->get();
        $contactServices = Customer_Service::all();
        $camps = ProgramCamp::all(); // atau filter khusus VIP/VVIP


        return view('programs.offline.show', compact('program', 'transports', 'periods', 'banks', 'contactServices', 'camps'));
    }

    /**
     * Memproses pendaftaran untuk program offline.
     */
    public function daftar(Request $request, ProgramOffline $program)
    {
        // Validasi
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'required|string|max:20',
            'asal_kota' => 'nullable|string|max:100',
            'no_wali' => 'nullable|string|max:20',
            'period_id' => 'required|exists:periods,id',
            'transport_id' => 'nullable|exists:transports,id',
            'payment_type' => 'required|in:tunai,transfer',
            'bank_id' => 'required_if:payment_type,transfer|nullable|exists:banks,id',
            'akomodasi' => 'nullable|string', // <-- validasi akomodasi
        ]);

        // Cek kuota
        if ($program->kuota <= 0) {
            return redirect()->back()->with('error', 'Kuota untuk program ini sudah habis!');
        }

        // Logika TRX-ID
        $today = Carbon::now()->format('Ymd');
        $prefix = 'TRX-OFF-' . $today . '-';
        $lastRegistration = PendaftaranProgramOffline::where('trx_id', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
        $nextSequence = $lastRegistration ? (int) str_replace($prefix, '', $lastRegistration->trx_id) + 1 : 1;
        $newTrxId = $prefix . $nextSequence;

        $programPrice = $program->harga;
        $transportPrice = 0;

        if (!empty($validated['transport_id'])) {
            $transport = Transports::find($validated['transport_id']);
            $transportPrice = $transport ? $transport->price : 0;
        }

        // === Logika akomodasi (VIP / Reguler) ===
        $akomodasiTipe = null;
        $akomodasiHarga = 0;

        if (!empty($validated['akomodasi'])) {
            if (str_starts_with($validated['akomodasi'], 'camp-')) {
                // Ambil camp dari DB
                $campId = str_replace('camp-', '', $validated['akomodasi']);
                //sementeara di comment dulu
                // // $camp = Camps::find($campId);
                // if ($camp) {
                //     $akomodasiTipe = $camp->kategori; // VIP
                //     $akomodasiHarga = $camp->harga;   // ambil harga camp dari DB
                // }
            } elseif ($validated['akomodasi'] === 'reguler') {
                $akomodasiTipe = 'Reguler';
                $akomodasiHarga = 180000; // static
            }
        }

        $subtotal = $programPrice + $transportPrice + $akomodasiHarga;

        $pendaftaran = PendaftaranProgramOffline::create([
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
            'payment_type' => $validated['payment_type'],
            'bank_id' => $validated['bank_id'] ?? null,
            'akomodasi_tipe' => $akomodasiTipe,    // disimpan
            'akomodasi_harga' => $akomodasiHarga,  // disimpan
            'subtotal' => $subtotal,
        ]);
        // Kurangi kuota
        $program->decrement('kuota');

        // Cek lagi jumlah kuota setelah dikurangi
        $program->refresh();
        if ($program->kuota <= 0 && $program->is_active == 1) {
            $program->update(['is_active' => 0]);
        }


        // Redirect
        if ($pendaftaran->payment_type === 'tunai') {
            return redirect()->route('public.pendaftaran.offline.sukses.tunai', ['trx_id' => $pendaftaran->trx_id]);
        } else {
            return redirect()->route('public.pendaftaran.offline.pembayaran', ['trx_id' => $newTrxId])
                ->with('success_message', 'Pendaftaran awal berhasil! Silakan lanjutkan ke tahap pembayaran.');
        }
    }


    /**
     * Menampilkan halaman pembayaran berdasarkan trx_id.
     */
    public function halamanPembayaran($trx_id)
    {
        // PERBAIKAN TYPO: $trxa_id diubah menjadi $trx_id
        $pendaftaran = PendaftaranProgramOffline::with(['program', 'bank'])
            ->where('trx_id', $trx_id)
            ->firstOrFail();

        if ($pendaftaran->payment_type === 'tunai') {
            return redirect()->route('public.pendaftaran.sukses.tunai', ['trx_id' => $pendaftaran->trx_id]);
        }

        $contactServices = Customer_Service::all();
        return view('pembayaran.index', compact('pendaftaran', 'contactServices'));
    }

    /**
     * METHOD BARU: Menampilkan halaman sukses untuk pembayaran tunai.
     */
    public function halamanSuksesTunai($trx_id)
    {
        $pendaftaran = PendaftaranProgramOffline::with('program')
            ->where('trx_id', $trx_id)
            ->where('payment_type', 'tunai') // Pastikan ini adalah pendaftaran tunai
            ->firstOrFail();

        // Tampilkan view baru untuk sukses tunai
        return view('pembayaran.sukses_tunai', compact('pendaftaran'));
    }
}
