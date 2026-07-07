<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Mail\TiketMail;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TransaksiController extends Controller
{
    public function index() 
{
    $transaksis = Transaksi::with(['User', 'Event'])
        ->whereHas('Event', function($q) {
            $q->where('idUser', Auth::id());
        })
        ->latest()
        ->get();

    return view('panitia.transaksi.index', compact('transaksis'));
}

    public function approve(Request $request, string $id)
    {
        $transaksi = Transaksi::with(['User', 'Event'])->findOrFail($id);

        if ($transaksi->status === 'pending') {
            
            // 1. Buat nama file gambar PNG yang unik dan simpan ke database
            $qrFileName = 'QR-TRX-' . $transaksi->idTransaksi . '-' . time() . '.png';

            // 2. Konten di dalam QR Code murni berupa teks kode unik (agar mudah discan)
            $uniqueCode = 'SIEKA-TRX-' . $transaksi->idTransaksi;
            
            // Generate QR Code berformat PNG
            $qrImage = QrCode::format('png')
                     ->size(400)
                     ->margin(2)
                     ->generate($uniqueCode);
            
            // Simpan ke storage asli (storage/app/public/qrcode/)
            Storage::disk('public')->put('qrcode/' . $qrFileName, $qrImage);

            // 3. UPDATE DATABASE: Simpan nama file utuh ke kolom qr_code
            $transaksi->update([
                'status' => 'paid',
                'qr_code' => $qrFileName 
            ]);

            // 4. Kirim email berisi informasi tiket ke peserta
            try {
                Mail::to($transaksi->User->email)->send(new TiketMail($transaksi));
                return redirect()->back()->with('success', 'Transaksi berhasil disetujui & Tiket dikirim ke email!');
            } catch (\Exception $e) {
                return redirect()->back()->with('success', 'Transaksi disetujui, namun pengiriman email gagal: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'Transaksi ini tidak berstatus pending.');
    }

    public function reject(Request $request, string $id)
    {
        $transaksi = Transaksi::with('Event')->findOrFail($id);

        if ($transaksi->status === 'pending') {
            $transaksi->update(['status' => 'rejected']);

            if ($transaksi->Event) {
                $transaksi->Event->increment('kuotaPeserta');
            }

            return redirect()->back()->with('success', 'Transaksi berhasil ditolak dan kuota dikembalikan.');
        }

        return redirect()->back()->with('error', 'Transaksi gagal diproses.');
    }

    public function scanPage()
    {
        return view('panitia.transaksi.scan');
    }

    public function scanProses(Request $request)
    {

        $request->validate([
            'qr_code' => 'required'
        ]);


        $idTransaksi = str_replace('SIEKA-TRX-', '', $request->qr_code);

        $transaksi = Transaksi::with(['User', 'Event'])
            ->where('idTransaksi', $idTransaksi) 
            ->first();

        if (!$transaksi) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Tiket tidak valid atau tidak terdaftar di sistem SIEKA.'
            ]);
        }

        if ($transaksi->status !== 'paid') {
            return response()->json([
                'status' => 'error', 
                'message' => 'Pembayaran tiket peserta ini belum dikonfirmasi.'
            ]);
        }

        if ($transaksi->kehadiran == 1) {
            return response()->json([
                'status' => 'warning', 
                'message' => 'Tiket sudah pernah di scan! Peserta atas nama ' . ($transaksi->User->nama ?? 'Tanpa Nama') . ' sudah scan tiket pada pukul ' . $transaksi->waktuHadir
            ]);
        }

        $transaksi->update([
            'kehadiran' => 1,
            'waktuHadir' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Scan Tiket Berhasil! Selamat datang, ' . ($transaksi->User->nama ?? 'Peserta')
        ]);
    }
}