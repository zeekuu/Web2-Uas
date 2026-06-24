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
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/error', [App\Http\Controllers\HomeController::class, 'index'])->name('404');

Route::middleware(['auth'])->group(function () {
    // Middleware Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminAdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('/admin/user', App\Http\Controllers\Admin\UserController::class)->names('admin.user');
        Route::resource('/admin/event', App\Http\Controllers\Admin\EventController::class)->names('admin.event');

        Route::put('/admin/event/{event}/approve', [App\Http\Controllers\Admin\KonfirmasibayarController::class, 'approve'])->name('admin.event.approve');
        Route::resource('/admin/transaksi', App\Http\Controllers\Admin\TransaksiController::class)->names('admin.transaksi');
        Route::put('/admin/transaksi/{transaksi}/approve', [App\Http\Controllers\Admin\KonfirmasibayarController::class, 'approve'])->name('admin.transaksi.konfirmasi');
        Route::get('/storage/{filename}', function ($filename) {
            $path = storage_path('app/public/proposal/' . $filename);
            return response()->file($path);
        });
    });

    // Middleware Panitia
    Route::middleware(['role:panitia'])->group(function () {
        Route::get('/panitia/dashboard', [PanitiaPanitiaDashboardController::class, 'index'])->name('panitia.dashboard');
        Route::resource('/panitia/event', App\Http\Controllers\Panitia\EventController::class)->names('panitia.event');
        Route::resource('/panitia/transaksi', App\Http\Controllers\Panitia\TransaksiController::class)->names('panitia.transaksi');
        });
        
        // Middleware User
        Route::middleware(['role:user'])->group(function () {
            Route::get('/user/dashboard', [UserUserDashboardController::class, 'index'])->name('user.dashboard');
            Route::resource('/user/event', App\Http\Controllers\User\EventController::class)->names('user.event');
            Route::resource('/user/transaksi', App\Http\Controllers\User\TransaksiController::class)->names('user.transaksi');
            });
            
});