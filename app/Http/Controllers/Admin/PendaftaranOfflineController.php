<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranProgramOffline;
use Illuminate\Http\Request;
use App\Exports\PendaftaranOfflineExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\ProgramOffline;


class PendaftaranOfflineController extends Controller
{
    public function index(Request $request)
    {
        $query = PendaftaranProgramOffline::with(['program', 'period']);

        // Filter by status pembayaran (lunas / dp)
        if ($request->filled('status_bayar')) {
            if ($request->status_bayar === 'lunas') {
                $query->where(function ($q) {
                    $q->whereNull('tipe_bayar_dp')
                      ->orWhere('tipe_bayar_dp', '')
                      ->orWhere('tipe_bayar_dp', 'lunas');
                });
            } elseif ($request->status_bayar === 'dp') {
                $query->where('tipe_bayar_dp', 'dp');
            }
        }

        // Filter by status pendaftaran (pending / diterima / ditolak)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pendaftar = $query->latest()->paginate(10)->withQueryString();

        $programBahasa = ProgramOffline::select('program_bahasa')
            ->distinct()
            ->pluck('program_bahasa');

        // Statistik pembayaran
        $totalPendaftar = PendaftaranProgramOffline::count();
        $totalLunas     = PendaftaranProgramOffline::where(function ($q) {
            $q->whereNull('tipe_bayar_dp')
              ->orWhere('tipe_bayar_dp', '')
              ->orWhere('tipe_bayar_dp', 'lunas');
        })->count();
        $totalDP        = PendaftaranProgramOffline::where('tipe_bayar_dp', 'dp')->count();

        // Statistik status pendaftaran
        $totalPending   = PendaftaranProgramOffline::where('status', 'pending')->count();
        $totalDiterima  = PendaftaranProgramOffline::where('status', 'diterima')->count();
        $totalDitolak   = PendaftaranProgramOffline::where('status', 'ditolak')->count();

        return view('admin.pendaftaran_offline.index', compact(
            'pendaftar', 'programBahasa',
            'totalPendaftar', 'totalLunas', 'totalDP',
            'totalPending', 'totalDiterima', 'totalDitolak'
        ));
    }
    public function show($id)
    {
        $pendaftaran = PendaftaranProgramOffline::with([
            'caterings.cateringPackage',
            'laundries.laundryPackage',
            'holidays.holidayPackage'
        ])->findOrFail($id);

        // Hitung total catering
        $totalCatering = $pendaftaran->caterings->sum(function ($item) {
            return $item->jumlah_porsi * $item->harga;
        });

        // Hitung total laundry
        $totalLaundry = $pendaftaran->laundries->sum(function ($item) {
            return $item->jumlah * $item->harga;
        });

        // Hitung total holiday
        $totalHoliday = $pendaftaran->holidays->sum(function ($item) {
            return $item->jumlah_peserta * $item->harga;
        });

        // Gabungan semua total
        $total = $totalCatering + $totalLaundry + $totalHoliday;

        // Kalau mau ada PPN 10%
        $totalWithTax = $total + ($total * 0.1);

        return view('admin.pendaftaran_offline.show', compact(
            'pendaftaran',
            'total',
            'totalCatering',
            'totalLaundry',
            'totalHoliday',
            'totalWithTax'
        ));
    }
 


    /**
     * Menampilkan halaman untuk mengedit status pendaftaran.
     */


    /**
     * Menampilkan halaman untuk mengedit status pendaftaran.
     */
    public function edit($id)
    {
        $pendaftaran = PendaftaranProgramOffline::findOrFail($id);
        return view('admin.pendaftaran_offline.edit', compact('pendaftaran'));
    }

    /**
     * Memperbarui status pendaftaran di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        $pendaftaran = PendaftaranProgramOffline::findOrFail($id);

        $statusMapping = [
            'approved' => 'diterima',
            'rejected' => 'ditolak',
            'pending' => 'pending',
        ];

        $pendaftaran->status = $statusMapping[$request->status] ?? 'pending';
        $pendaftaran->save();

        return redirect()->route('admin.pendaftaran.offline.index')
            ->with('success', 'Status pendaftaran ' . $pendaftaran->trx_id . ' berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = PendaftaranProgramOffline::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.pendaftaran.offline.index')->with('success', 'Data pendaftaran berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $start = $request->input('start_date');
        $end   = $request->input('end_date');
        $programBahasa = $request->input('program_bahasa'); // ambil dari form

        if (!$start || !$end) {
            return redirect()->back()->with('error', 'Tanggal harus diisi!');
        }

        $filename = "pendaftaran_offline_{$start}_to_{$end}.xlsx";

        return Excel::download(new PendaftaranOfflineExport($start, $end, $programBahasa), $filename);
    }


    /**
     * Menampilkan bukti pembayaran dari database.
     */




    public function showBukti($id)
    {
        $pendaftaran = PendaftaranProgramOffline::findOrFail($id);

        if (empty($pendaftaran->bukti_pembayaran_path) || !Storage::disk('public')->exists($pendaftaran->bukti_pembayaran_path)) {
            abort(404, 'Bukti pembayaran tidak ditemukan.');
        }

        // Ambil file dari storage
        $path = storage_path('app/public/' . $pendaftaran->bukti_pembayaran_path);
        $mimeType = mime_content_type($path);

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="bukti-' . $pendaftaran->trx_id . '"'
        ]);
    }
}

