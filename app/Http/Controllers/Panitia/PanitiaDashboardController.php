<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PanitiaDashboardController extends Controller
{
    public function index()
    {
        $totalEvent = Event::where('status', 'approved')->count();
        $transaksiPending = Transaksi::where('status', 'pending')->count();
        $transaksiSelesai = Transaksi::where('status', 'paid')->count();
        $totalPesertaHadir = Transaksi::where('kehadiran', 1)->count();

        return view('panitia.dashboard', compact('totalEvent', 'transaksiPending', 'transaksiSelesai', 'totalPesertaHadir'));
    }
}
