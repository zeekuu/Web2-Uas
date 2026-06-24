<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $request->validate([
            'idEvent' => 'required|exists:events,idEvent',
            'buktiTransfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'qr_code' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'buktiTransfer.required' => 'Wajib mengunggah bukti transfer untuk memesan tiket.',
            'buktiTransfer.image' => 'Berkas harus berupa gambar.',
            'buktiTransfer.mimes' => 'Format gambar harus JPEG, PNG, atau JPG.',
            'buktiTransfer.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'qr_code.image' => 'Berkas harus berupa gambar.',
            'qr_code.mimes' => 'Format gambar harus JPEG, PNG, atau JPG.',
            'qr_code.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);

        $event = Event::findOrFail($request->idEvent);

        if ($event->kuotaPeserta <= 0) {
            return redirect()->back()->with('error', 'Maaf, kuota tiket untuk event ini sudah habis.');
        }

        $data = [
            'idUser' => Auth::id(),
            'idEvent' => $request->idEvent,
            'status' => 'pending',
            'kehadiran' => 0, 
            'qr_code' => '-',
        ];

        if ($request->hasFile('buktiTransfer')) {
            $file = $request->file('buktiTransfer');
            $fileName = $file->getClientOriginalName();            
            Storage::disk('public')->putFileAs('buktiTransfer', $file, $fileName);
            $data['buktiTransfer'] = $fileName;
        }

        Transaksi::create($data);
        $event->decrement('kuotaPeserta');
        return redirect()->route('user.transaksi.index')->with('success', 'Pemesanan berhasil! Tunggu verifikasi dari panitia.');
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
