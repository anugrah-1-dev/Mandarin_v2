<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pelatihan;
use App\Models\Jadwal;
use App\Models\Message;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.Dashboard', [
            'totalUsers' => User::count(),
            // 'activeCourses' => Pelatihan::where('status', 'aktif')->count(),
            // 'todaySchedules' => Jadwal::whereDate('tanggal', now())->count(),
            // 'inboxCount' => Message::count(),
        ]);
    }
}
