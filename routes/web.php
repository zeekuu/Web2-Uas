<?php

use App\Http\Controllers\Admin\AdminDashboardController as AdminAdminDashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panitia\PanitiaDashboardController as PanitiaPanitiaDashboardController;
use App\Http\Controllers\User\UserDashboardController as UserUserDashboardController;

Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    });
});


Auth::routes();
Route::get('/error', [App\Http\Controllers\HomeController::class, 'index'])->name('403');

Route::middleware(['auth'])->group(function () {
    // Middleware Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminAdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('/admin/user', App\Http\Controllers\Admin\UserController::class)->names('admin.user');
        Route::put('/admin/event/{id}/update-status', [App\Http\Controllers\Admin\EventController::class, 'updateStatus'])->name('admin.event.updateStatus');
        Route::resource('/admin/event', App\Http\Controllers\Admin\EventController::class)->names('admin.event');
        Route::get('/admin/logs', [App\Http\Controllers\Admin\LogController::class, 'index'])->name('admin.logs');
        Route::resource('/admin/transaksi', App\Http\Controllers\Admin\TransaksiController::class, ['except' => ['create', 'store', 'edit', 'destroy', 'update', 'show']])->names('admin.transaksi');
        Route::put('/admin/transaksi/{transaksi}/approve', [App\Http\Controllers\Admin\TransaksiController::class, 'approve'])->name('admin.transaksi.approve');
        Route::put('/admin/transaksi/{transaksi}/reject', [App\Http\Controllers\Admin\TransaksiController::class, 'reject'])->name('admin.transaksi.reject');
        Route::get('/storage/{filename}', function ($filename) {
            $path = storage_path('app/public/poster/' . $filename);
            return response()->file($path);
        });
        Route::get('/storage/{filename}', function ($filename) {
            $path = storage_path('app/public/proposal/' . $filename);
            return response()->file($path);
        });
    });

    // Middleware Panitia
    Route::middleware(['role:panitia'])->group(function () {
        Route::get('/panitia/dashboard', [PanitiaPanitiaDashboardController::class, 'index'])->name('panitia.dashboard');
        Route::resource('/panitia/event', App\Http\Controllers\Panitia\EventController::class)->names('panitia.event');
        Route::resource('/panitia/transaksi', App\Http\Controllers\Panitia\TransaksiController::class, ['except' => ['create', 'store']])->names('panitia.transaksi');
        Route::put('/panitia/transaksi/{transaksi}/approve', [App\Http\Controllers\Panitia\TransaksiController::class, 'approve'])->name('panitia.transaksi.approve');
        Route::put('/panitia/transaksi/{transaksi}/reject', [App\Http\Controllers\Panitia\TransaksiController::class, 'reject'])->name('panitia.transaksi.reject');
        Route::get('/panitia/scan', [App\Http\Controllers\Panitia\TransaksiController::class, 'scanPage'])->name('panitia.scan');
        Route::post('/panitia/scan/proses', [App\Http\Controllers\Panitia\TransaksiController::class, 'scanProses'])->name('panitia.scan.proses');
        Route::get('/storage/{filename}', function ($filename) {
            $path = storage_path('app/public/poster/' . $filename);
            return response()->file($path);
        });
        Route::get('/storage/{filename}', function ($filename) {
            $path = storage_path('app/public/proposal/' . $filename);
            return response()->file($path);
        });
        });
        
        // Middleware User
        Route::middleware(['role:user'])->group(function () {
            Route::get('/user/dashboard', [UserUserDashboardController::class, 'index'])->name('user.dashboard');
            Route::resource('/user/event', App\Http\Controllers\User\EventController::class, ['except' => ['create', 'store', 'edit', 'destroy']])->names('user.event');
            Route::resource('/user/transaksi', App\Http\Controllers\User\TransaksiController::class)->names('user.transaksi');
            });
            
});