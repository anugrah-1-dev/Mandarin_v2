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
            'gender'         => 'required|in:putra,putri',
            'bank_id'        => 'required|exists:banks,id',
        ]);

        // Cek stok terlebih dahulu
        if ($program->stok <= 0) {
            return redirect()->back()->with('error', 'Stok program camp sudah habis!');
        }

        // Buat trx_id
        $prefix = 'TRXC-' . now()->format('Ymd') . '-';
        $last = PendaftaranProgramCamp::where('trx_id', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();
        $nextNumber = $last ? ((int) str_replace($prefix, '', $last->trx_id) + 1) : 1;
        $trx_id = $prefix . $nextNumber;

        // Simpan pendaftaran
        $pendaftaran = PendaftaranProgramCamp::create([
            'nama_lengkap'     => $validated['nama_lengkap'],
            'email'            => $validated['email'],
            'no_hp'            => $validated['no_hp'],
            'asal_kota'        => $validated['asal_kota'],
            'gender'           => $validated['gender'],
            'program_camp_id'  => $program->id,
            'period_id'        => $validated['period_id'],
            'durasi_paket'     => $validated['durasi_paket'],
            'bank_id'          => $validated['bank_id'],
            'status'           => 'pending',
            'nama_kamar'       => null,
            'trx_id'           => $trx_id,
        ]);

        // Kurangi stok
        $program->decrement('stok');

        return redirect()->route('camp.room', ['trx_id' => $pendaftaran->trx_id]);
    }

    public function halamanKamar($trx_id)
    {
        $pendaftar = PendaftaranProgramCamp::where('trx_id', $trx_id)->firstOrFail();
        $rooms = Rooms::where('program_camp_id', $pendaftar->program_camp_id)->get();

        return view('camp.room', [
            'rooms' => $rooms,
            'pendaftar' => $pendaftar,
            'trx_id' => $trx_id,
        ]);
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

    public function proseskamaruser(Request $request)
    {

        $request->validate([
            'kamar_id' => 'required|exists:rooms,id',
        ]);

        $pendaftar = PendaftaranProgramCamp::where('trx_id', $request->trx_id)->firstOrFail();

        $pendaftar->update([
            'room_id' => $request->kamar_id,
            'nama_kamar' => $request->nama_kamar, // <- jangan lupa kalau mau simpan juga

        ]);

        return redirect()->route('camp.pembayaran', ['trx_id' => $request->trx_id]);
    }


    public function halamanPembayaran($trx_id)
    {
        $pendaftaran = PendaftaranProgramCamp::where('trx_id', $trx_id)->firstOrFail();
        $pendaftaran = PendaftaranProgramCamp::with('bank')->where('trx_id', $trx_id)->firstOrFail();
        return view('camp.pembayaran', compact('pendaftaran'));
    }



    public function showPembayaran($id)
    {
        $pendaftaran = PendaftaranProgramCamp::with('programCamp')->findOrFail($id);
        return view('camp.pembayaran', compact('pendaftaran'));
      
    }
    public function uploadBukti(Request $request)
{
    $request->validate([
        'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'trx_id' => 'required|exists:pendaftaran_program_camps,trx_id',
    ]);

    $pendaftaran = PendaftaranProgramCamp::where('trx_id', $request->trx_id)->firstOrFail();

    // Simpan file
    $file = $request->file('bukti_pembayaran');
    $path = $file->store('bukti_pembayaran', 'public');

    // Update pendaftaran
    $pendaftaran->update([
        'bukti_pembayaran' => $path,
        'status' => 'menunggu_verifikasi'
    ]);

    // Kembalikan ke halaman yang sama dengan pesan dan trx_id
    return back()
        ->with('success_message', "Bukti pembayaran Anda telah berhasil diunggah.")
        ->with('trx_id', $pendaftaran->trx_id);
}

    


}
