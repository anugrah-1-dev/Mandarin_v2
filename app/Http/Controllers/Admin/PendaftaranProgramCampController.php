<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranProgramCamp;
use App\Models\ProgramCamp;
use App\Models\Period;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Exports\PendaftaranCampExport;
use Maatwebsite\Excel\Facades\Excel;

class PendaftaranProgramCampController extends Controller
{
    public function index()
    {
        $pendaftar = PendaftaranProgramCamp::with(['programCamp', 'period', 'bank'])->latest()->get();
        return view('admin.camp.index', compact('pendaftar'));
    }

    public function show($id)
    {
        $pendaftar = PendaftaranProgramCamp::with(['programCamp', 'period', 'bank'])->findOrFail($id);
        return view('admin.camp.show', compact('pendaftar'));
    }

    public function edit($id)
    {
        $pendaftar = PendaftaranProgramCamp::findOrFail($id);
        $statusList = ['pending', 'diterima', 'ditolak'];
        return view('admin.camp.edit', compact('pendaftar', 'statusList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,validasi,diterima,ditolak',
        ]);

        $pendaftar = PendaftaranProgramCamp::findOrFail($id);
        $pendaftar->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.camp.index')->with('success', 'Status berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pendaftar = PendaftaranProgramCamp::findOrFail($id);
        $pendaftar->delete();

        return redirect()->back()->with('success', 'Pendaftar berhasil dihapus.');
    }


    public function showBukti($id)
    {
        $pendaftar = PendaftaranProgramCamp::findOrFail($id);
        return view('admin.camp.bukti', compact('pendaftar'));
    }


    public function exportCsv()
    {
        return Excel::download(new PendaftaranCampExport, 'pendaftaran.camp.xlsx');
    }
}
