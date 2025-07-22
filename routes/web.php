<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\TransportsController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Admin\Customer_Service_Controller;
use App\Http\Controllers\Admin\ProgramCampController;
use App\Http\Controllers\Admin\ProgramOfflineController;
use App\Http\Controllers\Admin\ProgramOnlineController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PendaftaranOnlineController;
use App\Http\Controllers\Admin\PendaftaranOfflineController;
use App\Http\Controllers\ProgramOfflinePublicController;
use App\Http\Controllers\ProgramOnlinePublicController;
use App\Http\Controllers\Admin\PeriodsController;
use App\Http\Controllers\Admin\SosmedController;
use App\Http\Controllers\CampController;
use App\Http\Controllers\Admin\RoomController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
//camp
Route::get('/camps', [CampController::class, 'publicIndex'])->name('camps.index');
Route::get('/camps/{camp:slug}', [CampController::class, 'publicShow'])->name('camps.show');
Route::get('/camp/{slug}', [CampController::class, 'show'])->name('camps.show');

Route::post('/pendaftaran_program_camp/{programCampId}', [CampController::class, 'storePendaftaran'])->name('camp.pendaftaran.store');
Route::get('/camp/{slug}/room', [CampController::class, 'room'])->name('camp.room');
Route::post('/camp/room/{pendaftaranId}', [CampController::class, 'pilihKamar'])->name('camp.pilihKamar');
Route::get('/camp/pembayaran/{id}', [CampController::class, 'pembayaran'])->name('camp.pembayaran');
Route::post('/camp/pembayaran/{id}', [CampController::class, 'submitBuktiPembayaran'])->name('camp.submitPembayaran');


// Jika mau tetap pakai LandingPageController untuk tampilan awal bisa begini:
Route::get('/landing/program-offline/{program:slug}', [LandingPageController::class, 'showOfflinePublic'])->name('landing.program.offline.show');
Route::get('/landing/program-online/{program:slug}', [LandingPageController::class, 'showOnlinePublic'])->name('landing.program.online.show');

// === PROGRAM OFFLINE ===
Route::get('/program/offline/{program:slug}', [ProgramOfflinePublicController::class, 'showOfflinePublic'])->name('public.program.offline.show');
Route::post('/program/offline/{program:slug}/daftar', [ProgramOfflinePublicController::class, 'daftar'])->name('public.program.offline.daftar');

// === PROGRAM ONLINE ===
Route::get('/program/online/{program:slug}', [ProgramOnlinePublicController::class, 'show'])
    ->name('public.program.online.show');

Route::post('/program/online/{program:slug}/daftar', [ProgramOnlinePublicController::class, 'daftar'])
    ->name('public.program.online.daftar');


Route::get('/', [LandingPageController::class, 'index'])->name('landing');

//Landing page
Auth::routes();
// Route::get('/Dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')  ->name('admin.') ->group(function () {

    //dashboard admin
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //roles
    Route::resource('roles', RoleController::class);
    //permissions
    Route::resource('permissions', PermissionController::class);
    //users
    Route::resource('users', UserController::class);
    //banks
    Route::resource('banks', BankController::class);
    //transports
    Route::resource('transports', TransportsController::class);
    //cs
    Route::resource('customer_services', Customer_Service_Controller::class);

    // Pamflet
    Route::get('pamflet_programs', [ProgramController::class, 'index'])->name('pamflet_programs.index');
    Route::get('pamflet_programs/create', [ProgramController::class, 'create'])->name('pamflet_programs.create');
    Route::post('pamflet_programs', [ProgramController::class, 'store'])->name('pamflet_programs.store');
    Route::get('pamflet_programs/{program}', [ProgramController::class, 'show'])->name('pamflet_programs.show');
    Route::get('pamflet_programs/{program}/edit', [ProgramController::class, 'edit'])->name('pamflet_programs.edit');
    Route::put('pamflet_programs/{program}', [ProgramController::class, 'update'])->name('pamflet_programs.update');
    Route::delete('pamflet_programs/{program}', [ProgramController::class, 'destroy'])->name('pamflet_programs.destroy');

    //program offline
    Route::resource('programs/offline', ProgramOfflineController::class);
    Route::delete('admin/programs/offline/{id}', [ProgramOfflineController::class, 'destroy'])->name('admin.offline.destroy');

    //program online
    Route::resource('programs/online', ProgramOnlineController::class);

    // gallery
    Route::resource('galleries', GalleryController::class);
    Route::delete('galleries/images/{id}', [GalleryController::class, 'destroyImage'])->name('galleries.images.destroy');

    //program camp
    Route::resource('programs/camp', ProgramCampController::class)->names('programs.camp');
    Route::resource('rooms',RoomController::class);

    // Pendaftaran Program Online
    Route::get('pendaftaran/online', [PendaftaranOnlineController::class, 'index'])->name('pendaftaran.online.index');
    Route::get('/pendaftaran/program-online', [PendaftaranOnlineController::class, 'create'])->name('pendaftaran.program_online.create');
    Route::post('/pendaftaran/program-online', [PendaftaranOnlineController::class, 'store'])->name('pendaftaran.program_online.store');

    // Pendaftaran Program Offline
    Route::get('pendaftaran/offline', [PendaftaranOfflineController::class, 'index'])->name('pendaftaran.offline.index');
    Route::get('/pendaftaran/program-offline', [PendaftaranOfflineController::class, 'create'])->name('pendaftaran.program_offline.create');
    Route::post('/pendaftaran/program-offline', [PendaftaranOfflineController::class, 'store'])->name('pendaftaran.program_offline.store');

    //periods
    Route::resource('periods', PeriodsController::class)->only(['index','store', 'update', 'destroy']);

    //sosmed
    Route::resource('sosmed', SosmedController::class);

    //CSV Export
    Route::get('/pendaftaran-online/export', [PendaftaranOnlineController::class, 'exportCsv'])
        ->name('pendaftaran.online.export');

    //CSV Export
    Route::get('/pendaftaran-offline/export', [PendaftaranOfflineController::class, 'exportCsvOffline'])
        ->name('pendaftaran.offline.export');
});
