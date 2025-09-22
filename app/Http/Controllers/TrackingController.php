<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranProgramCamp;
use App\Models\PendaftaranProgramOffline;
use App\Models\PendaftaranProgramOnline;
use App\Models\Customer_Service;
use App\Models\PendaftaranCatering;
use App\Models\PendaftaranLaundry;
use App\Models\PendaftaranHoliday;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'trx_id' => 'required|string',
        ]);

        $trx_id = $request->trx_id;

        $camp = PendaftaranProgramCamp::where('trx_id', $trx_id)->first();
        $offline = PendaftaranProgramOffline::where('trx_id', $trx_id)->first();
        $online = PendaftaranProgramOnline::where('trx_id', $trx_id)->first();
        $cs = Customer_Service::first();

        $caterings = PendaftaranCatering::with('cateringPackage')
            ->where('pendaftaran_id', $offline->id)
            ->get();

        $laundries = PendaftaranLaundry::with('laundryPackage')
            ->where('pendaftaran_id', $offline->id)
            ->get();

        $holidays = PendaftaranHoliday::with('holidayPackage')
            ->where('pendaftaran_id', $offline->id)
            ->get();
        if (!$camp && !$offline && !$online) {
            return back()->with('error', 'Transaksi tidak ditemukan.');
        }

        return view('tracking.index', compact('camp', 'offline', 'online', 'trx_id','cs', 'caterings', 'laundries', 'holidays'));
    }
}
