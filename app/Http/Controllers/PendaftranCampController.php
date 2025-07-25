<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\ProgramCamp;
use App\Models\Period;
use App\Models\PendaftaranProgramCamp;
use App\Models\Banks;
use App\Models\Rooms;
use Illuminate\Support\Str;


class PendaftranCampController extends Controller
{
    /**
     * Menampilkan halaman detail program camp dan form pendaftaran awal.
     */
    public function showCampPublic(ProgramCamp $program)
    {
        $periods = Period::all(); // bisa filter jika perlu hanya yang aktif
        return view('camp.show', compact('program', 'periods'));
    }

    /**
     * Menangani pendaftaran awal program camp (tanpa upload bukti).
     */
    public function showForm(ProgramCamp $program)
    {
        $periods = Period::where('is_active', true)->get();
        return view('camp.register', compact('program', 'periods'));
    }

    /**
     * Menyimpan data pendaftaran awal dan redirect ke halaman pemilihan kamar.
     */
    public function store(Request $request, ProgramCamp $program)
    {
        $validated = $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'no_hp'          => 'required|string|max:20',
            'asal_kota'      => 'required|string|max:100',
            'period_id'      => 'required|exists:periods,id',
            'durasi_paket'   => 'required|in:perhari,satu_minggu,dua_minggu,satu_bulan,dua_bulan,tiga_bulan',
        ]);

        // Generate trx_id unik
        $prefix = 'TRXC-' . now()->format('Ymd') . '-';
        $last = PendaftaranProgramCamp::where('trx_id', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
        $nextNumber = $last ? ((int) str_replace($prefix, '', $last->trx_id) + 1) : 1;
        $trx_id = $prefix . $nextNumber;

        // Simpan data pendaftaran
        $pendaftaran = PendaftaranProgramCamp::create([
            'trx_id'          => $trx_id,
            'program_camp_id' => $program->id,
            'period_id'       => $validated['period_id'],
            'nama_lengkap'    => $validated['nama_lengkap'],
            'email'           => $validated['email'],
            'no_hp'           => $validated['no_hp'],
            'asal_kota'       => $validated['asal_kota'],
            'durasi_paket'    => $validated['durasi_paket'],
            'status'          => 'pending',
        ]);

        // Arahkan ke halaman pemilihan kamar
        return redirect()->route('public.pendaftaran.camp.kamar', ['trx_id' => $trx_id])
            ->with('success', 'Pendaftaran berhasil, silakan pilih kamar.');
    }
    /**
     * Menampilkan halaman pemilihan kamar setelah pendaftaran awal.
     */
    public function halamanKamar($trx_id)
    {
        $pendaftaran = PendaftaranProgramCamp::where('trx_id', $trx_id)->firstOrFail();

        $rooms = Rooms::where('program_camp_id', $pendaftaran->program_camp_id)->get();

        return view('camp.room', compact('pendaftaran', 'rooms'));
    }


    public static function filter($rooms, $prefix, $start, $end, $gender = null)
    {
        return $rooms->filter(function ($room) use ($prefix, $start, $end, $gender) {
            $number = (int) filter_var($room->nomor_kamar, FILTER_SANITIZE_NUMBER_INT);
            return Str::startsWith($room->nomor_kamar, $prefix)
                && $number >= $start && $number <= $end
                && ($gender ? $room->gender === $gender : true);
        });
    }

    /**
     * Menampilkan halaman pembayaran akhir.
     */
    public function halamanPembayaran($trx_id)
    {
        $pendaftaran = PendaftaranProgramCamp::with('program')->where('trx_id', $trx_id)->firstOrFail();
        $banks = Banks::where('status', 'active')->get();

        return view('camp.payment', compact('pendaftaran', 'banks'));
    }
}
