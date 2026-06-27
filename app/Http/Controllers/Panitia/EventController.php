<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('idUser', Auth::id())->latest()->get();
        return view('panitia.event.index', compact('events'));
    }

    public function create()
    {
        return view('panitia.event.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaEvent' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tempatEvent' => 'required|string',
            'tanggalEvent' => 'required|date',
            'waktuEvent' => 'required',
            'kuotaPeserta' => 'required|integer|min:1',
            'hargaTiket' => 'required|integer|min:0',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'fileProposal' => 'required|mimes:pdf|max:2048',
        ], [
            'namaEvent.required' => 'Nama Event harus diisi',
            'deskripsi.required' => 'Deskripsi harus diisi',
            'tempatEvent.required' => 'Tempat Event harus diisi',
            'tanggalEvent.required' => 'Tanggal Event harus diisi',
            'waktuEvent.required' => 'Waktu Event harus diisi',
            'kuotaPeserta.required' => 'Kuota Peserta harus diisi',
            'hargaTiket.required' => 'Harga Tiket harus diisi',
            'poster.required' => 'Poster harus diisi',
            'poster.image' => 'Berkas harus berupa gambar',
            'poster.mimes' => 'Format gambar harus JPEG, PNG, atau JPG',
            'poster.max' => 'Ukuran gambar tidak boleh lebih dari 2MB',
            'fileProposal.required' => 'File Proposal harus diisi',
            'fileProposal.mimes' => 'Format file harus PDF',
            'fileProposal.max' => 'Ukuran file tidak boleh lebih dari 2MB',
        ]);

        $data = $request->all();
        $data['idUser'] = Auth::id(); 
        $data['status'] = 'pending';  

        if ($request->hasFile('fileProposal')) {
            $file = $request->file('fileProposal');
            $fileName = $file->getClientOriginalName();
            Storage::disk('public')->putFileAs('proposal', $file, $fileName);
            $data['fileProposal'] = $fileName;
        }
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $fileName = $file->getClientOriginalName();
            Storage::disk('public')->putFileAs('poster', $file, $fileName);
            $data['poster'] = $fileName;
        }

        Event::create($data);

        return redirect()->route('panitia.event.index')->with('success', 'Event berhasil diajukan! Menunggu persetujuan admin.');
    }

    public function edit(string $id)
    {
        $event = Event::where('idUser', Auth::id())->findOrFail($id);
        return view('panitia.event.edit', compact('event'));
    }

    public function update(Request $request, string $id)
    {
        $event = Event::where('idUser', Auth::id())->findOrFail($id);

        $request->validate([
            'namaEvent' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tempatEvent' => 'required|string',
            'tanggalEvent' => 'required|date',
            'waktuEvent' => 'required',
            'kuotaPeserta' => 'required|integer|min:1',
            'hargaTiket' => 'required|integer|min:0',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'fileProposal' => 'nullable|mimes:pdf|max:2048',
        ], [
            'namaEvent.required' => 'Nama Event harus diisi',
            'deskripsi.required' => 'Deskripsi harus diisi',
            'tempatEvent.required' => 'Tempat Event harus diisi',
            'tanggalEvent.required' => 'Tanggal Event harus diisi',
            'waktuEvent.required' => 'Waktu Event harus diisi',
            'kuotaPeserta.required' => 'Kuota Peserta harus diisi',
            'hargaTiket.required' => 'Harga Tiket harus diisi',
            'poster.image' => 'Berkas harus berupa gambar',
            'poster.mimes' => 'Format gambar harus JPEG, PNG, atau JPG',
            'poster.max' => 'Ukuran gambar tidak boleh lebih dari 2MB',
            'fileProposal.mimes' => 'Format file harus PDF',
            'fileProposal.max' => 'Ukuran file tidak boleh lebih dari 2MB',
        ]);

        $data = $request->all();
        if ($request->hasFile('fileProposal')) {
            if ($event->fileProposal) {
                Storage::disk('public')->delete('proposal/' . $event->fileProposal);
            }

            $file = $request->file('fileProposal');
            $fileName = $file->getClientOriginalName();
            Storage::disk('public')->putFileAs('proposal', $file, $fileName);
            $data['fileProposal'] = $fileName;
        }
        if ($request->hasFile('poster')) {
            
            if ($event->poster) {
                Storage::disk('public')->delete('poster/' . $event->poster);
            }

            $file = $request->file('poster');
            $fileName = $file->getClientOriginalName();
            Storage::disk('public')->putFileAs('poster', $file, $fileName);
            $data['poster'] = $fileName;
        }

        $event->update($data);

        return redirect()->route('panitia.event.index')->with('success', 'Data event berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $event = Event::where('idUser', Auth::id())->findOrFail($id);
        if($event->fileProposal) {
            Storage::disk('public')->delete('proposal/' . $event->fileProposal);
        }
        if ($event->poster) {
            Storage::disk('public')->delete('poster/' . $event->poster);
        }

        $event->delete();

        return redirect()->route('panitia.event.index')->with('success', 'Event berhasil dihapus.');
    }
}
