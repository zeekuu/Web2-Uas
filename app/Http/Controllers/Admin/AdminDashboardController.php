<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {

        $user = User::where('role', 'user')->get();
        $events = Event::where('status', 'approved')->get();
        
        $totalEvent = Event::count();
        $eventAktif = Event::where('status', 'approved')->count();
        $tiket = Event::sum('kuotaPeserta');
        $transaksiPending = Transaksi::where('status', 'pending')->count();
        $transaksiSelesai = Transaksi::where('status', 'paid')->count();
        $totalPesertaHadir = Transaksi::where('kehadiran', 1)->count();
        $totalPendapatan = Transaksi::where('status', 'paid')->whereHas('Event')->get()->sum(function ($transaksi) {
            return $transaksi->Event->hargaTiket;
        });
        $totalUser = User::where('role', 'user')->count();
        return view('admin.dashboard', compact('user', 'events', 'totalEvent', 'eventAktif', 'tiket', 'transaksiPending', 'transaksiSelesai', 'totalPesertaHadir', 'totalPendapatan', 'totalUser'));
    }
}
