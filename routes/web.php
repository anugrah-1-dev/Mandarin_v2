<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\TransportsController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Admin\Customer_Service_Controller;
use App\Http\Controllers\Admin\ProgramCampController;
use App\Http\Controllers\Admin\ProgramOfflineController;
use App\Http\Controllers\Admin\ProgramOnlineController;
use App\Http\Controllers\Admin\GaleriController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingPageController::class, 'index'])->name('landing');

//Landing page
Auth::routes();
Route::get('/Dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')  ->name('admin.') ->group(function () {

    //dashboard admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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
    Route::resource('galeri', GaleriController::class);

    //program camp
    Route::resource('programs/camp', ProgramCampController::class)->names('programs.camp');
});
