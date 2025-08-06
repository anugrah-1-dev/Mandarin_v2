<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramOffline;
use App\Models\ProgramOnline;
use Illuminate\Support\Carbon;
use App\Models\Sosmed;
use App\Models\PendaftaranProgramOnline;
use App\Models\PendaftaranProgramOffline;
use App\Models\PendaftaranProgramCamp;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pendaftaranOnline = PendaftaranProgramOnline::with('program')->get();

        $pendaftaranOffline = PendaftaranProgramOffline::with('program')->get();
        $pendaftaranCamp = PendaftaranProgramCamp::with('programCamp')->get();

        $years = range(now()->year - 1, now()->year);
        $monthlyProfit = [];

        foreach ($years as $year) {
            $monthlyProfit[$year] = array_fill(1, 12, 0);
        }

        // Hitung keuntungan online
        foreach ($pendaftaranOnline as $item) {
            if ($item->status !== 'diterima') continue;

            $date = Carbon::parse($item->created_at);
            $monthlyProfit[$date->year][$date->month] += $item->program->harga ?? 0;

        }

        // Hitung keuntungan offline
        foreach ($pendaftaranOffline as $item) {
            if ($item->status !== 'diterima') continue;

            $date = Carbon::parse($item->created_at);
            $monthlyProfit[$date->year][$date->month] += $item->program->harga ?? 0;
        }

        // Hitung keuntungan camp dengan semua opsi durasi
        foreach ($pendaftaranCamp as $item) {
            if ($item->status !== 'diterima') continue;

            $date = Carbon::parse($item->created_at);
            $harga = $this->calculateCampPrice($item);
            $monthlyProfit[$date->year][$date->month] += $harga;
        }

        // Hitung total data dan keuntungan
        $salesData = [
            'Online' => $pendaftaranOnline->where('status', 'diterima')->count(),
            'Offline' => $pendaftaranOffline->where('status', 'diterima')->count(),
            'Camp' => $pendaftaranCamp->where('status', 'diterima')->count(),
        ];

        $totalKursus = array_sum($salesData);

        $totalKeuntungan = array_reduce(
    $pendaftaranOnline->all(),
    fn($sum, $p) => $sum + (($p->status === 'diterima') ? ($p->program->harga ?? 0) : 0),
    0
)
            + array_reduce(
                $pendaftaranOffline->all(),
                fn($sum, $p) => $sum + (($p->status === 'diterima') ? ($p->program->harga ?? 0) : 0),
                0
            )
            + array_reduce($pendaftaranCamp->all(), function ($sum, $p) {
                return $sum + (($p->status === 'diterima') ? $this->calculateCampPrice($p) : 0);
            }, 0);

        $totalMediaSosial = 20;
        $sosmedList = Sosmed::latest()->take(12)->get();

        return view('admin.dashboard', compact(
            'monthlyProfit',
            'salesData',
            'totalKursus',
            'totalKeuntungan',
            'totalMediaSosial',
            'sosmedList'
        ));
    }

    /**
     * Helper method to calculate camp price based on duration
     */
    protected function calculateCampPrice($pendaftaranCamp)
    {
        if (!$pendaftaranCamp->programCamp) return 0;

        $durasi = $pendaftaranCamp->durasi_paket;
        $program = $pendaftaranCamp->programCamp;

        switch ($durasi) {
            case 'satu_minggu':
                return $program->harga_satu_minggu ?? 0;
            case 'dua_minggu':
                return $program->harga_dua_minggu ?? 0;
            case 'tiga_minggu':
                return $program->harga_tiga_minggu ?? 0;
            case 'satu_bulan':
                return $program->harga_satu_bulan ?? 0;
            case 'dua_bulan':
                return $program->harga_dua_bulan ?? 0;
            case 'tiga_bulan':
                return $program->harga_tiga_bulan ?? 0;
            case 'enam_bulan':
                return $program->harga_enam_bulan ?? 0;
            case 'satu_tahun':
                return $program->harga_satu_tahun ?? 0;
            case 'perhari':
                return $program->harga_perhari ?? 0;
            default:
                return $program->harga_perhari ?? 0; // Fallback
        }
    }
}
