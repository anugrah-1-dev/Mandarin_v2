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
use App\Http\Controllers\Admin\ProgramOfflineController;
use App\Http\Controllers\Admin\ProgramOnlineController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingPageController::class, 'index'])->name('landing');

Auth::routes();
Route::get('/Dashboard', [DashboardController::class, 'index'])->name('dashboard');



Route::middleware(['auth', 'role:admin'])->prefix('admin')  ->name('admin.') ->group(function () {

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);
    Route::resource('banks', BankController::class);
    Route::resource('transports', TransportsController::class);
    Route::resource('customer_services', Customer_Service_Controller::class);
    Route::resource('pamflet_programs', ProgramController::class);
    Route::resource('programs/offline', ProgramOfflineController::class);
    Route::resource('programs/online', ProgramOnlineController::class);


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
