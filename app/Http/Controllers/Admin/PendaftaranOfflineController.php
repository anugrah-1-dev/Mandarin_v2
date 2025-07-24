<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranProgramOffline;
use Illuminate\Http\Request;
use App\Exports\PendaftaranOfflineExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class PendaftaranOfflineController extends Controller
{
    public function index()
    {
        $pendaftar = PendaftaranProgramOffline::with(['program', 'period'])
            ->latest()->paginate(10);

        return view('admin.pendaftaran_offline.index', compact('pendaftar'));
    }

    public function show($id)
    {
        $data = PendaftaranProgramOffline::with(['program', 'period'])->findOrFail($id);
        return view('admin.pendaftaran_offline.show', compact('data'));
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
        $pendaftaran->status = $request->status;
        $pendaftaran->save();

        return redirect()->route('admin.pendaftaran.offline.index')->with('success', 'Status pendaftaran ' . $pendaftaran->trx_id . ' berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = PendaftaranProgramOffline::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.pendaftaran.offline.index')->with('success', 'Data pendaftaran berhasil dihapus.');
   
    }

    public function exportCsvOffline()
    {
        return Excel::download(new PendaftaranOfflineExport, 'pendaftaran_program_offline.xlsx');
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
        'Content-Disposition' => 'inline; filename="bukti-'.$pendaftaran->trx_id.'"'
    ]);
}
}
