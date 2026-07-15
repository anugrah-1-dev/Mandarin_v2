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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\PendaftaranProgramCampController;
use App\Http\Controllers\PendaftranCampController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\Admin\ThumbnailController;
use App\Http\Controllers\Admin\LogoController;

use App\Http\Controllers\ProgramInggrisController;
use App\Http\Controllers\ProgramJermanController;
use App\Http\Controllers\ProgramArabController;
use App\Http\Controllers\ProgramMandarinController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProgramNHCController; // <-- PERUBAIKAN 1: Controller NHC ditambahkan
use App\Http\Controllers\Admin\PeriodNHCController;

//admin new
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Admin\ServicePackageController;
use App\Http\Controllers\Admin\HolidayPackageController;
use App\Http\Controllers\Admin\CateringPackageController;
use App\Http\Controllers\Admin\LaundryPackageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/



//camp
Route::get('/camps', [CampController::class, 'publicIndex'])->name('camps.index');
Route::get('/camps/{camp:slug}', [CampController::class, 'publicShow'])->name('camps.show');
Route::get('/camp/{slug}/room', [CampController::class, 'room'])->name('camp.slug.room');
Route::get('/camp/{slug}', [CampController::class, 'show'])->name('camp.show');


// Form pendaftaran awal
Route::get('/camp/{program}/daftar', [PendaftranCampController::class, 'showForm'])->name('camp.pendaftaran.form');
Route::post('/camp/{program}/daftar', [PendaftranCampController::class, 'store'])->name('camp.pendaftaran.store');

// Halaman pilih kamar berdasarkan trx_id
Route::get('/camp/room/{trx_id}', [PendaftranCampController::class, 'halamanKamar'])->name('camp.room');

Route::post('/camp/proses-kamar', [PendaftranCampController::class, 'proseskamaruser'])->name('camp.proseskamaruser');
Route::get('/camp/pembayaran/{trx_id}', [PendaftranCampController::class, 'halamanPembayaran'])->name('camp.pembayaran');
Route::post('/pembayaran/upload', [PendaftranCampController::class, 'uploadBukti'])->name('pembayaran.upload');



Route::bind('pendaftaran', function ($value) {
    return \App\Models\PendaftaranProgramCamp::where('trx_id', $value)->firstOrFail();
});

// Jika mau tetap pakai LandingPageController untuk tampilan awal bisa begini:
Route::get('/landing/program-offline/{program:slug}', [LandingPageController::class, 'showOfflinePublic'])->name('landing.program.offline.show');
Route::get('/landing/program-online/{program:slug}', [LandingPageController::class, 'showOnlinePublic'])->name('landing.program.online.show');

// === PROGRAM OFFLINE ===
Route::get('/program/offline/{program:slug}', [ProgramOfflinePublicController::class, 'showOfflinePublic'])->name('public.program.offline.show');
Route::post('/program/offline/{program:slug}/daftar', [ProgramOfflinePublicController::class, 'daftar'])->name('public.program.offline.daftar');
// Route Halaman Pembayaran Offline
Route::get('/pendaftaran/offline/pembayaran/{trx_id}', [ProgramOfflinePublicController::class, 'halamanPembayaran'])->name('public.pendaftaran.offline.pembayaran');
// ROUTE BARU: Halaman sukses untuk pembayaran tunai
Route::get('/pendaftaran/offline/sukses-tunai/{trx_id}', [ProgramOfflinePublicController::class, 'halamanSuksesTunai'])->name('public.pendaftaran.offline.sukses.tunai');

Route::get('/pendaftaran/offline/qris/{trx_id}', [ProgramOfflinePublicController::class, 'halamanqris'])->name('public.pendaftaran.offline.sukses.qris');


// === PROGRAM ONLINE ===
Route::get('/program/online/{program:slug}', [ProgramOnlinePublicController::class, 'show'])
    ->name('public.program.online.show');
Route::post('/program/online/{program:slug}/daftar', [ProgramOnlinePublicController::class, 'daftar'])
    ->name('public.program.online.daftar');
// Route Halaman Pembayaran Online
Route::get('/pendaftaran/online/pembayaran/{trx_id}', [ProgramOnlinePublicController::class, 'halamanPembayaran'])->name('public.pendaftaran.online.pembayaran');
// ROUTE BARU: Halaman sukses untuk pembayaran tunai
Route::get('/pendaftaran/online/sukses-tunai/{trx_id}', [ProgramOnlinePublicController::class, 'halamanSuksesTunai'])->name('public.pendaftaran.online.sukses.tunai');
Route::get('/pendaftaran/online/qris/{trx_id}', [ProgramOnlinePublicController::class, 'halamanqris'])->name('public.pendaftaran.online.sukses.qris');



//brilliant
Route::get('/program/bahasa/inggris', [ProgramInggrisController::class, 'showInggris'])
    ->name('program.inggris');
Route::get('/program/bahasa/jerman', [ProgramJermanController::class, 'showJerman'])->name('program.jerman');
// Route baru
Route::get('/brilliantalsaeidarabic', [ProgramArabController::class, 'showArab'])->name('program.arab');
// Redirect dari URL lama ke URL baru
Route::redirect('/program/bahasa/arab', '/brilliantalsaeidarabic');
// Definisikan route untuk URL BARU yang Anda inginkan
Route::get('/MandarinCenterPare', [ProgramMandarinController::class, 'showMandarin'])->name('program.mandarin');
// Alihkan (redirect) URL LAMA ke URL BARU dengan status 301 (Moved Permanently)
Route::redirect('/program/bahasa/mandarin', '/MandarinCenterPare', 301);


// Bieplus
Route::get('/bieplus/program/bahasa/inggris', function () {
    return app(ProgramInggrisController::class)->showInggris('bieplus');
})->name('bieplus.program.inggris');

Route::get('/bieplus/program/bahasa/jerman', function () {
    return app(ProgramJermanController::class)->showJerman('bieplus');
})->name('bieplus.program.jerman');

Route::get('/bieplus/program/bahasa/mandarin', function () {
    return app(ProgramMandarinController::class)->showMandarin('bieplus');
})->name('bieplus.program.mandarin');

Route::get('/bieplus/program/bahasa/arab', function () {
    return app(ProgramArabController::class)->showArab('bieplus');
})->name('bieplus.program.arab');



// PERUBAIKAN 2: Rute NHC diubah ke controller yang benar
// ===============================================
Route::get('/nhc', [ProgramNHCController::class, 'index'])->name('landing.nhc');

// ===== ROUTE UNTUK UPLOAD BUKTI PEMBAYARAN =====
Route::post('/payment/upload', [PaymentController::class, 'uploadProof'])->name('payment.upload');
Route::post('/payment/upload-transport', [PaymentController::class, 'uploadTransportProof'])->name('payment.upload.transport');

Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
Route::post('/tracking', [TrackingController::class, 'search'])->name('tracking.search');

// ===== ROUTE INVOICE =====
Route::get('/invoice/cetak/{trx_id}', [App\Http\Controllers\InvoiceController::class, 'cetak'])->name('invoice.cetak');

Route::get('/', [ProgramMandarinController::class, 'showMandarin'])->name('landing');


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


//Landing page
Auth::routes();

Route::middleware(['auth', 'role:admin|officer'])->prefix('admin')->name('admin.')->group(function () {


    // Holiday
    Route::get('/holiday', [HolidayPackageController::class, 'index'])->name('holiday.index');
    Route::get('/holiday/create', [HolidayPackageController::class, 'create'])->name('holiday.create');
    Route::post('/holiday', [HolidayPackageController::class, 'store'])->name('holiday.store');
    Route::get('/holiday/{holidayPackage}/edit', [HolidayPackageController::class, 'edit'])->name('holiday.edit');
    Route::put('/holiday/{holidayPackage}', [HolidayPackageController::class, 'update'])->name('holiday.update');
    Route::delete('/holiday/{holidayPackage}', [HolidayPackageController::class, 'destroy'])->name('holiday.destroy');
    // Catering
    Route::get('/catering', [CateringPackageController::class, 'index'])->name('catering.index');
    Route::get('/catering/create', [CateringPackageController::class, 'create'])->name('catering.create');
    Route::post('/catering', [CateringPackageController::class, 'store'])->name('catering.store');
    Route::get('/catering/{cateringPackage}/edit', [CateringPackageController::class, 'edit'])->name('catering.edit');
    Route::put('/catering/{cateringPackage}', [CateringPackageController::class, 'update'])->name('catering.update');
    Route::delete('/catering/{cateringPackage}', [CateringPackageController::class, 'destroy'])->name('catering.destroy');

    // Laundry
    Route::get('/laundry', [LaundryPackageController::class, 'index'])->name('laundry.index');
    Route::get('/laundry/create', [LaundryPackageController::class, 'create'])->name('laundry.create');
    Route::post('/laundry', [LaundryPackageController::class, 'store'])->name('laundry.store');
    Route::get('/laundry/{laundryPackage}/edit', [LaundryPackageController::class, 'edit'])->name('laundry.edit');
    Route::put('/laundry/{laundryPackage}', [LaundryPackageController::class, 'update'])->name('laundry.update');
    Route::delete('/laundry/{laundryPackage}', [LaundryPackageController::class, 'destroy'])
        ->name('laundry.destroy');



    //dashboard admin
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/stok', [DashboardController::class, 'dashboardStok'])->name('admin.dashboard.stok');

    //roles
    Route::resource('roles', RoleController::class);
    //permissions
    Route::resource('permissions', PermissionController::class);
    //users
    Route::resource('users', UserController::class);
    //banks
    Route::resource('banks', BankController::class);
    // logos
    Route::get('logos', [LogoController::class, 'index'])->name('logos.index');
    Route::post('logos/{key}', [LogoController::class, 'update'])->name('logos.update');
    Route::delete('logos/{key}', [LogoController::class, 'destroy'])->name('logos.destroy');
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

    // gallery umum
    Route::resource('galleries', GalleryController::class);
    Route::delete('galleries/images/{id}', [GalleryController::class, 'destroyImage'])->name('galleries.images.destroy');
    Route::post('galleries/images/{id}/update', [GalleryController::class, 'updateImage'])->name('galleries.images.update');

    //program camp
    Route::resource('programs/camp', ProgramCampController::class)->names('programs.camp');
    Route::post('/programs/camp/sync-all-stok-from-rooms', [ProgramCampController::class, 'syncAllStokFromRoomsAjax'])->name('programs.camp.syncAllStokFromRoomsAjax');

    Route::post('/programs/camp/sync-stok', [ProgramCampController::class, 'syncStokWithPenghuni'])->name('programs.camp.syncStokWithPenghuni');
    Route::delete('/thumbnails/{thumbnail}', [ThumbnailController::class, 'destroy'])
        ->name('thumbnails.destroy');


    Route::resource('rooms', RoomController::class);
    Route::get('/rooms/{id}/penghuni', [RoomController::class, 'getPenghuni']);
    Route::delete('/rooms/penghuni/{trx_id}', [RoomController::class, 'kickPenghuni']);
    Route::post('/rooms/pindah-peserta', [RoomController::class, 'pindahPeserta']);
    Route::get('/rooms/list-aktif', [RoomController::class, 'listAktif']);
    Route::get('/rooms/{id}/peserta-detail', [RoomController::class, 'getPesertaDetail']);
    Route::post('/peserta/{id}/pindah-kamar', [PendaftaranProgramCampController::class, 'pindahKamar']);
    Route::post('/rooms/update-by-kategori', [RoomController::class, 'updateByKategori'])
        ->name('rooms.update-by-kategori');
    Route::post('/rooms/sync-penghuni', [PendaftaranProgramCampController::class, 'syncPenghuniFromRoomsAjax'])->name('rooms.sync-penghuni');


    // Pendaftaran Program Online
    Route::get('pendaftaran/online', [PendaftaranOnlineController::class, 'index'])->name('pendaftaran.online.index');
    Route::get('pendaftaran/online/{id}/edit', [PendaftaranOnlineController::class, 'edit'])->name('pendaftaran.online.edit');
    Route::put('pendaftaran/online/{id}', [PendaftaranOnlineController::class, 'update'])->name('pendaftaran.online.update');
    Route::delete('pendaftaran/online/{id}', [PendaftaranOnlineController::class, 'destroy'])->name('pendaftaran.online.destroy');
    Route::get('pendaftaran/online/{id}/bukti', [PendaftaranOnlineController::class, 'showBukti'])->name('pendaftaran.online.bukti');
    Route::get('/pendaftaran/program-online', [PendaftaranOnlineController::class, 'create'])->name('pendaftaran.program_online.create');
    Route::post('/pendaftaran/program-online', [PendaftaranOnlineController::class, 'store'])->name('pendaftaran.program_online.store');

    // Pendaftaran Program Offline
    Route::get('pendaftaran/offline', [PendaftaranOfflineController::class, 'index'])->name('pendaftaran.offline.index');
    Route::get('pendaftaran/offline/{id}/edit', [PendaftaranOfflineController::class, 'edit'])->name('pendaftaran.offline.edit');
    Route::put('pendaftaran/offline/{id}', [PendaftaranOfflineController::class, 'update'])->name('pendaftaran.offline.update');
    Route::delete('pendaftaran/offline/{id}', [PendaftaranOfflineController::class, 'destroy'])->name('pendaftaran.offline.destroy');
    Route::get('pendaftaran/offline/{id}/bukti', [PendaftaranOfflineController::class, 'showBukti'])->name('pendaftaran.offline.bukti');
    Route::get('/pendaftaran/program-offline', [PendaftaranOfflineController::class, 'create'])->name('pendaftaran.program_offline.create');
    Route::post('/pendaftaran/program-offline', [PendaftaranOfflineController::class, 'store'])->name('pendaftaran.program_offline.store');
    Route::get('pendaftaran/offline/{id}', [PendaftaranOfflineController::class, 'show'])
        ->name('pendaftaran.offline.show');

    // Pendaftaran Program Camp

    Route::get('/pendaftaran/camp', [PendaftaranProgramCampController::class, 'index'])->name('pendaftaran.camp.index');
    Route::get('/pendaftaran/camp/{id}/edit', [PendaftaranProgramCampController::class, 'edit'])->name('pendaftaran.camp.edit');
    Route::put('/pendaftaran/camp/{id}', [PendaftaranProgramCampController::class, 'update'])->name('pendaftaran.camp.update');
    Route::delete('/pendaftaran/camp/{id}', [PendaftaranProgramCampController::class, 'destroy'])->name('pendaftaran.camp.destroy');
    Route::get('/pendaftaran/camp/{id}/bukti', [PendaftaranProgramCampController::class, 'showBukti'])->name('pendaftaran.camp.bukti');


    //periods
    Route::resource('periods', PeriodsController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::resource('periods_nhc', PeriodNHCController::class);

    //sosmed
    Route::resource('sosmed', SosmedController::class);

    Route::put('/pendaftaran/camp/update-status/{id}', [PendaftaranProgramCampController::class, 'updateStatus'])->name('pendaftaran.camp.update-status');

    //CSV Export
    Route::get('/pendaftaran/online/export', [PendaftaranOnlineController::class, 'exportOnline'])->name('pendaftaran.online.export');

    //CSV Export
    Route::get('/pendaftaran/offline/export', [PendaftaranOfflineController::class, 'export'])->name('pendaftaran.offline.export');

    Route::get('/pendaftaran/camp/export', [PendaftaranProgramCampController::class, 'exportCamp'])->name('pendaftaran.camp.export');

    // Pembayaran
    // Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
    // Route::post('/upload-bukti', [PembayaranController::class, 'uploadBukti'])->name('bukti.upload');

});


