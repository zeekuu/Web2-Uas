<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TiketMail;
use App\Models\Event;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TransaksiController extends Controller
{
    public function index(){
        $transaksis = Transaksi::all();
        $users = User::all();
        $events = Event::all();
        return view('admin.transaksi.index', compact('transaksis', 'users', 'events'));
    }

    public function approve(Request $request, string $id)
    {
        $transaksi = Transaksi::with(['User', 'Event'])->findOrFail($id);

        if ($transaksi->status === 'pending') {
        $transaksi->update([
            'status' => 'paid'
        ]);

        try {
            Mail::to($transaksi->User->email)->send(new TiketMail($transaksi));
            return redirect()->back()->with('success', 'Transaksi berhasil disetujui & QR Code dikirim ke email peserta!');
        } catch (\Exception $e) {
            return redirect()->back()->with('success', 'Transaksi disetujui, namun email gagal terkirim: ' . $e->getMessage());
        }
    }

    return redirect()->back()->with('error', 'Transaksi ini tidak berstatus pending.');
    }
    public function reject(Request $request, string $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status === 'pending') {
            $transaksi->update([
                'status' => 'rejected'
            ]);

            // Kembalikan kuota karena batal mendaftar
            if ($transaksi->Event) {
                $transaksi->Event->increment('kuotaPeserta');
            }

            return redirect()->back()->with('success', 'Transaksi berhasil ditolak.');
        }

        return redirect()->back()->with('error', 'Transaksi gagal diproses.');
    }
}
