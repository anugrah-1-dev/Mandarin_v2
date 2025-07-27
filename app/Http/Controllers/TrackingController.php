<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranProgramCamp;
use App\Models\PendaftaranProgramOffline;
use App\Models\PendaftaranProgramOnline;

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

        if (!$camp && !$offline && !$online) {
            return back()->with('error', 'Transaksi tidak ditemukan.');
        }

        return view('tracking.index', compact('camp', 'offline', 'online', 'trx_id'));
    }
}
