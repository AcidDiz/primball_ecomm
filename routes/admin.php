<?php

use App\Http\Controllers\Admin\AttachPermissionToRoleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DetachPermissionFromRoleController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware', ['auth', 'verified']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('roles/attach-permission', [AttachPermissionToRoleController::class, 'index'])->name('roles.attach-permission');
    Route::post('roles/detach-permission', [DetachPermissionFromRoleController::class, 'index'])->name('roles.detach-permission');
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);
});

require __DIR__ . '/auth.php';
