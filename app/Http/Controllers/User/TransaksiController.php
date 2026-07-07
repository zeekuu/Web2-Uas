<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\TiketMail;
use App\Models\Event;
use App\Models\Transaksi;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::with('Event')
            ->where('idUser', Auth::id())
            ->latest()
            ->get();

        return view('user.transaksi.index', compact('transaksis'));
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
    $event = Event::findOrFail($request->idEvent);

    $rules = [
        'idEvent' => 'required|exists:events,idEvent',
    ];
    $messages = [];

    if ($event->hargaTiket > 0) {
        $rules['buktiTransfer'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
        $messages = [
            'buktiTransfer.required' => 'Wajib mengunggah bukti transfer untuk memesan tiket.',
            'buktiTransfer.image' => 'Berkas harus berupa gambar.',
            'buktiTransfer.mimes' => 'Format gambar harus JPEG, PNG, atau JPG.',
            'buktiTransfer.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ];
    }

    $request->validate($rules, $messages);

    $cekTiket = Transaksi::where('idUser', Auth::id())->where('idEvent', $request->idEvent)->exists();
    if ($cekTiket) {
    throw ValidationException::withMessages([
        'error' => 'Anda sudah memesan tiket untuk event ini.',
    ]);
}

    if ($event->kuotaPeserta <= 0) {
        return redirect()->back()->with('error', 'Maaf, kuota tiket untuk event ini sudah habis.');
    }
    
    // Tentukan status awal berdasarkan jenis event
    $statusAwal = ($event->hargaTiket == 0) ? 'paid' : 'pending';

    // 1. Simpan transaksi terlebih dahulu agar kita mendapatkan ID Transaksi
    $transaksi = Transaksi::create([
        'idUser' => Auth::id(),
        'idEvent' => $request->idEvent,
        'status' => $statusAwal,
        'kehadiran' => 0,
        'qr_code' => '-', // Default strip dulu
        'buktiTransfer' => null
    ]);

    // 2. Jika event gratis, generate QR code menggunakan ID transaksi yang baru saja dibuat
    if ($event->hargaTiket == 0) {
        // Ambil ID primer dari transaksi yang baru disimpan (sesuaikan jika nama primary key Anda bukan 'id')
        $primaryKey = $transaksi->idTransaksi ?? $transaksi->id; 
        
        $qrFileName = 'QR-TRX-' . $primaryKey . '-' . time() . '.png';
        $uniqueCode = 'SIEKA-TRX-' . $primaryKey;
        
        // Generate QR Code berformat PNG
        $qrImage = QrCode::format('png')
                 ->size(400)
                 ->margin(2)
                 ->generate($uniqueCode);
        
        // Simpan file gambar QR ke storage/app/public/qrcode/
        Storage::disk('public')->put('qrcode/' . $qrFileName, $qrImage); 

        // Update kolom qr_code di database dengan nama file atau kode uniknya
        $transaksi->update([
            'qr_code' => $qrFileName // Simpan nama file gambar ke database
        ]);
        try {
                Mail::to($transaksi->User->email)->send(new TiketMail($transaksi));
                return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil & tiket dikirim ke email!');
            } catch (\Exception $e) {
                return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil, namun pengiriman tiket ke email gagal: ' . $e->getMessage());
            }
        
    }

    // 3. Proses upload bukti transfer jika ada file (untuk event berbayar)
    if ($request->hasFile('buktiTransfer')) {
        $file = $request->file('buktiTransfer');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();          
        Storage::disk('public')->putFileAs('buktiTransfer', $file, $fileName);
        $transaksi->update(['buktiTransfer' => $fileName]);
    }

    $event->decrement('kuotaPeserta');

    if ($event->hargaTiket == 0) {
        return redirect()->route('user.transaksi.index')->with('success', 'Pendaftaran berhasil! Tiket event gratis Anda sudah aktif.');
    }

    return redirect()->route('user.transaksi.index')->with('success', 'Pemesanan berhasil! Tunggu verifikasi pembayaran dari panitia.');
}



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $events = Event::findOrFail($id);
        $transaksis = Transaksi::with(['users', 'events'])->where('idEvent', $id)->get();
        return view('user.transaksi.show', compact('transaksis', 'events'));
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
}
