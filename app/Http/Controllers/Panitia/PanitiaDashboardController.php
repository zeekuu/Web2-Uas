<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanitiaDashboardController extends Controller
{
    public function index()
    {
        $eventPending = Event::where('idUser', Auth::id())->where('status', 'pending')->latest()->get();
        $eventApproved = Event::where('idUser', Auth::id())->where('status', 'approved')->latest()->get();
        $eventRejected = Event::where('idUser', Auth::id())->where('status', 'rejected')->latest()->get();
        $totalEvent = Event::where('idUser', Auth::id())->count();
        $eventAktif = Event::where('status', 'approved')->where('idUser', Auth::id())->count();
        $transaksiPending = Transaksi::where('status', 'pending')->count();
        $transaksiSelesai = Transaksi::where('status', 'paid')->count();
        $totalPesertaHadir = Transaksi::where('kehadiran', 1)->count();

        return view('panitia.dashboard', compact('eventPending','eventApproved', 'eventRejected', 'totalEvent', 'eventAktif', 'transaksiPending', 'transaksiSelesai', 'totalPesertaHadir'));
    }
}
