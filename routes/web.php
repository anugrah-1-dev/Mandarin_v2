<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BankController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn() => view('landingpage'))->name('dashboard');

Auth::routes();

Route::get('/Dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('Dashboard');

// Admin Routes
Route::middleware('role:admin')->group(function () {
    Route::resource('/admin/roles', RoleController::class);
    Route::resource('/admin/permissions', PermissionController::class);
    Route::resource('/admin/users', UserController::class);
    Route::resource('/admin/banks', BankController::class);
});
