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
use Illuminate\Support\Facades\Http;
use App\Models\PeriodNHC;
use App\Models\CateringPackage;
use App\Models\HolidayPackage;
use App\Models\LaundryPackage;

class ProgramOfflinePublicController extends Controller
{
    /**
     * Menampilkan detail program offline beserta form pendaftaran.
     */
    public function showOfflinePublic(ProgramOffline $program)
    {
        $transports = Transports::all();
        $periods = Period::where('is_active', 1)->get();
        $activePeriodsNHC = PeriodNHC::where('is_active', 1)->get();
        $banks = Banks::where('status', 'active')
            ->where(function ($query) use ($program) {
                $query->where('institusi', $program->kursus)
                      ->orWhere('institusi', 'semua');
            })
            ->get();
        $contactServices = Customer_Service::all();
        $camps = ProgramCamp::all();

        // tambahan sesuai kebutuhan view
        $catering_packages = CateringPackage::where('status', 'aktif')->get();
        $laundry_packages = LaundryPackage::where('status', 'aktif')->get();
        $holiday_packages = HolidayPackage::where('status', 'aktif')->get();

        return view('programs.offline.show', compact(
            'program',
            'transports',
            'periods',
            'activePeriodsNHC',
            'banks',
            'contactServices',
            'camps',
            'catering_packages',
            'holiday_packages',
            'laundry_packages'
        ));
    }



    /**
     * Memproses pendaftaran untuk program offline.
     */
    public function daftar(Request $request, ProgramOffline $program)
    {
        // Validasi
        $rules = [
            'nama_lengkap'   => 'required|string|max:255',
            'email'          => 'required|email',
            'no_hp'          => 'required|string|max:20',
            'asal_kota'      => 'nullable|string|max:100',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'gender'         => 'required|in:Laki-laki,Perempuan',
            'no_wali'        => 'nullable|string|max:20',
            'transport_id'   => 'nullable|exists:transports,id',
            'payment_type'   => 'required|in:tunai,transfer,qris',
            'bank_id'        => 'required_if:payment_type,transfer|nullable|exists:banks,id',
            'akomodasi'      => 'nullable|string',
            'ukuran_seragam' => 'nullable|in:S,M,L,XL,XXL',
        ];

        // Periode validasi dinamis
        if ($program->program_bahasa === 'nhc') {
            $rules['period_nhc_id'] = 'required|exists:periods_nhc,id';
        } else {
            $rules['period_id'] = 'required|exists:periods,id';
        }

        // dd($request->all());

        $validated = $request->validate($rules);

        // Cek kuota
        if ($program->kuota <= 0) {
            return redirect()->back()->with('error', 'Kuota untuk program ini sudah habis!');
        }

        // Logika TRX-ID
        $today = Carbon::now()->format('Ymd');
        $prefix = '369-' . $today . '-';
        $lastRegistration = PendaftaranProgramOffline::where('trx_id', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
        $nextSequence = $lastRegistration ? (int) str_replace($prefix, '', $lastRegistration->trx_id) + 1 : 1;
        $newTrxId = $prefix . $nextSequence;

        $programPrice = $program->harga;
        $transportPrice = 0;

        if (!empty($validated['transport_id'])) {
            $transport = Transports::find($validated['transport_id']);
            $transportPrice = $transport ? $transport->price : 0;
        }

        // === Logika akomodasi ===
        $akomodasiTipe = null;
        $akomodasiHarga = 0;

        if (!empty($validated['akomodasi'])) {
            if (str_starts_with($validated['akomodasi'], 'camp-')) {
                $campId = str_replace('camp-', '', $validated['akomodasi']);
                // sementara di-comment
                // $camp = Camps::find($campId);
                // if ($camp) {
                //     $akomodasiTipe = $camp->kategori;
                //     $akomodasiHarga = $camp->harga;
                // }
            } elseif ($validated['akomodasi'] === 'reguler') {
                $akomodasiTipe = 'Reguler';
                $akomodasiHarga = 180000; // static
            }
        }

        $subtotal = $programPrice + $transportPrice + $akomodasiHarga;

        $pendaftaran = PendaftaranProgramOffline::create([
            'trx_id'        => $newTrxId,
            'program_id'    => $program->id,
            'period_id'     => $program->program_bahasa !== 'nhc' ? ($validated['period_id'] ?? null) : null,
            'period_nhc_id' => $program->program_bahasa === 'nhc' ? ($validated['period_nhc_id'] ?? null) : null,
            'transport_id'  => $validated['transport_id'] ?? null,
            'nama_lengkap'  => $validated['nama_lengkap'],
            'email'         => $validated['email'],
            'no_hp'         => $validated['no_hp'],
            'asal_kota'     => $validated['asal_kota'] ?? null,
            'tempat_lahir'  => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'gender'        => $validated['gender'],
            'no_wali'       => $validated['no_wali'] ?? null,
            'status'        => 'pending',
            'payment_type'  => $validated['payment_type'],
            'bank_id'       => $validated['bank_id'] ?? null,
            'akomodasi_tipe' => $akomodasiTipe,
            'akomodasi_harga' => $akomodasiHarga,
            'subtotal'      => $subtotal,
            'ukuran_seragam' => $validated['ukuran_seragam'] ?? null,
        ]);

        // === setelah create $pendaftaran ===

        // Helper untuk parsing JSON / array request
        function parseRequestArray($data)
        {
            return is_string($data) ? json_decode($data, true) : ($data ?? []);
        }

        // === Simpan data catering (jika ada) ===
        $caterings = parseRequestArray($request->catering);
        foreach ($caterings as $catering) {
            // ambil harga paket catering
            $package = CateringPackage::find($catering['id']);
            $harga = $package ? $package->harga : 0;
            $jumlah = $catering['quantity'] ?? 1;

            \App\Models\PendaftaranCatering::create([
                'pendaftaran_id'      => $pendaftaran->id,
                'catering_package_id' => $catering['id'],
                'jumlah_porsi'        => $jumlah,
                'harga'               => $harga * $jumlah, // simpan harga total
            ]);
        }

        // === Simpan data laundry (jika ada) ===
        $laundries = parseRequestArray($request->laundry);
        foreach ($laundries as $laundry) {
            $package = LaundryPackage::find($laundry['id']);
            $harga = $package ? $package->harga : 0;
            $jumlah = $laundry['jumlah'] ?? 1;

            \App\Models\PendaftaranLaundry::create([
                'pendaftaran_id'      => $pendaftaran->id,
                'laundry_package_id'  => $laundry['id'],
                'jumlah'              => $jumlah,
                'harga'               => $harga * $jumlah,
            ]);
        }

        // === Simpan data holiday (jika ada) ===
        $holidays = parseRequestArray($request->holiday);
        foreach ($holidays as $holiday) {
            $package = HolidayPackage::find($holiday['id']);
            $harga = $package ? $package->harga : 0;
            $jumlah = $holiday['jumlah'] ?? 1;

            \App\Models\PendaftaranHoliday::create([
                'pendaftaran_id'      => $pendaftaran->id,
                'holiday_package_id'  => $holiday['id'],
                'jumlah_peserta'      => $jumlah,
                'harga'               => $harga * $jumlah,
            ]);
        }



        // Kurangi kuota
        $program->decrement('kuota');

        // ...
        // (lanjutan kode Telegram + redirect tetap sama)

        // Cek lagi jumlah kuota setelah dikurangi
        $program->refresh();
        if ($program->kuota <= 0 && $program->is_active == 1) {
            $program->update(['is_active' => 0]);
        }

        $programName = $pendaftaran->program->nama ?? 'Tidak ada program';
        $period = Period::find($pendaftaran->period_id);
        $periodDate = $period ? $period->date : null;
        $periodDateText = $periodDate ? $periodDate->format('d M Y') : '-';

        // Garis cantik
        $line = str_repeat('─', 32);

        // Pesan Telegram
        $message = "📢 *Pendaftaran Baru* 📢\n";
        $message .= "{$line}\n";
        $message .= "*No Transaksi:* {$pendaftaran->trx_id}\n";
        $message .= "{$line}\n";
        $message .= "*Nama:* {$pendaftaran->nama_lengkap}\n";
        $message .= "*Email:* {$pendaftaran->email}\n";
        $message .= "*No HP:* {$pendaftaran->no_hp}\n";
        $message .= "*Program:* {$programName}\n";
        $message .= "*Tanggal Pendaftaran:* {$periodDateText}\n";
        $message .= "{$line}\n";
        $message .= "_Terima kasih sudah mendaftar!_ ✨";

        $message .= "_!>w<!_";


        $chatIds = explode(',', env('TELEGRAM_CHAT_IDS'));

        foreach ($chatIds as $chatId) {
            Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
                'chat_id' => trim($chatId),
                'text'    => $message,
                'parse_mode' => 'Markdown'
            ]);
        }


        // Redirect
        if ($pendaftaran->payment_type === 'tunai') {
            return redirect()->route('public.pendaftaran.offline.sukses.tunai', ['trx_id' => $pendaftaran->trx_id]);
        } elseif ($pendaftaran->payment_type === 'qris') {
            return redirect()->route('public.pendaftaran.offline.sukses.qris', ['trx_id' => $pendaftaran->trx_id]);
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

    public function halamanqris($trx_id)
    {
        $pendaftaran = PendaftaranProgramOffline::where('trx_id', $trx_id)->firstOrFail();

        // batas waktu = created_at + 10 menit
        $expiresAt = $pendaftaran->created_at->copy()->addMinutes(10);

        // cek expired
        if (now()->greaterThan($expiresAt) || $pendaftaran->status === 'expired') {
            if ($pendaftaran->status !== 'expired') {
                $pendaftaran->update(['status' => 'expired']);
            }

            return redirect()
                ->route('public.program.offline.show', $pendaftaran->program->slug)
                ->with('error', 'Batas waktu pembayaran habis, silakan daftar lagi.');
        }

        $qrisImage   = asset('asset/qris/madarin_qris.jpg');
        $expiresAtTs = $expiresAt->getTimestampMs();
        $nowTs       = now()->getTimestampMs();
        $sudahUpload = !empty($pendaftaran->bukti_pembayaran);

        return view('pembayaran.qris', compact(
            'pendaftaran',
            'qrisImage',
            'expiresAtTs',
            'nowTs',
            'sudahUpload'
        ));
    }
}
