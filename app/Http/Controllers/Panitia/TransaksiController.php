<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Mail\TiketMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Str;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::with(['User', 'Event'])
            ->whereHas('Event', function($query) {
                $query->where('idUser', Auth::id());
            })
            ->latest()
            ->get();

        return view('panitia.transaksi.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
    public function scanPage()
    {
        return view('panitia.transaksi.scan');
    }

    public function scanProses(Request $request)
    {
        // 1. Validasi inputan string yang dikirim oleh AJAX Camera Scanner
        $request->validate([
            'qr_code_string' => 'required'
        ]);

        // 2. Cari data transaksi berdasarkan string unik QR Code yang terbaca oleh kamera.
        // Eager loading memuat data relasi 'User' (peserta) dan 'Event' (acara)
        $transaksi = Transaksi::with(['User', 'Event'])
            ->where('qr_code', $request->qr_code_string)
            ->first();

        // 3. JIKA TIKET TIDAK DITEMUKAN DI DATABASE
        if (!$transaksi) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Tiket tidak valid atau tidak terdaftar di sistem SIEKA.'
            ]);
        }

        // 4. JIKA STATUS PEMBAYARAN BELUM PASTI/BELUM DI-APPROVE (Bukan Paid)
        if ($transaksi->status !== 'paid') {
            return response()->json([
                'status' => 'error', 
                'message' => 'Pembayaran tiket peserta ini belum dikonfirmasi (Status: ' . strtoupper($transaksi->status) . ').'
            ]);
        }

        // 5. JIKA PESERTA SUDAH PERNAH SCAN SEBELUMNYA (Mencegah Tiket Duplikat/Dipakai Orang Lain)
        if ($transaksi->kehadiran == 1) {
            return response()->json([
                'status' => 'warning', 
                'message' => 'Tiket sudah pernah digunakan! Peserta atas nama ' . ($transaksi->User->nama ?? 'Tanpa Nama') . ' sudah check-in pada pukul ' . $transaksi->waktuHadir
            ]);
        }

        // 6. JIKA BERHASIL (Tiket Valid, Berstatus Paid, & Belum Pernah Hadir)
        // Update database untuk mengubah status kehadiran menjadi 1 (Hadir) dan catat waktu kehadirannya
        $transaksi->update([
            'kehadiran' => 1,
            'waktuHadir' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Check-in Berhasil! Selamat datang, ' . ($transaksi->User->nama ?? 'Peserta') . ' di event: ' . ($transaksi->Event->namaEvent ?? 'SIEKA Event')
        ]);
    }
}