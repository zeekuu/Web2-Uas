<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(){
        $events = Event::all();
        $users = User::all();
        return view('admin.event.index', compact('events', 'users'));
    }
    
    public function create(){
        $events = Event::all();
        $users = User::all();
        return view('admin.event.create', compact('events', 'users'));
    }

    public function edit($id){
        $events = Event::findOrFail($id);
        $users = User::all();
        return view('admin.event.edit', compact('events', 'users'));
    }

    public function show($id){
        $events = Event::findOrFail($id);
        $users = User::all();
        return view('admin.event.edit', compact('events', 'users'));
    }

    public function store(Request $request){
        $request->validate([
            'namaEvent' => 'required',
            'tempatEvent' => 'required',
            'deskripsi' => 'required',
            'tanggalEvent' => 'required',
            'waktuEvent' => 'required',
            'kuotaPeserta' => 'required',
            'hargaTiket' => 'required', 
            'fileProposal' => 'required|mimes:pdf|max:2048',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'idUser' => 'required|exists:users,idUser',
        ], [
            'namaEvent.required' => 'Nama Event harus diisi',
            'tempatEvent.required' => 'Tempat Event harus diisi',
            'deskripsi.required' => 'Deskripsi harus diisi',
            'tanggalEvent.required' => 'Tanggal Event harus diisi',
            'waktuEvent.required' => 'Waktu Event harus diisi',
            'kuotaPeserta.required' => 'Kuota Peserta harus diisi',
            'hargaTiket.required' => 'Harga Tiket harus diisi',
            'fileProposal.required' => 'File Proposal harus diisi',
            'fileProposal.mimes' => 'Format file harus PDF',
            'fileProposal.max' => 'Ukuran file tidak boleh lebih dari 2MB',
            'poster.required' => 'Poster harus diisi',
            'poster.image' => 'Berkas harus berupa gambar',
            'poster.mimes' => 'Format gambar harus JPEG, PNG, atau JPG',
            'poster.max' => 'Ukuran gambar tidak boleh lebih dari 2MB',
            'idUser.required' => 'Harus dipilih',
            'idUser.exists' => 'User yang dipilih tidak valid',
        ]);
        $data = $request->all();
        $data['idUser'] = $request->input('idUser', Auth::user()->idUser); 
        if($request->hasFile('fileProposal')) {
            $file = $request->file('fileProposal');
            $fileName = $file->getClientOriginalName();
            Storage::disk('public')->putFileAs('proposal', $file, $fileName);
            $data['fileProposal'] = $fileName;
        }
        if($request->hasFile('poster')){
            $poster = $request->file('poster');
            $posterName = $poster->getClientOriginalName();
            Storage::disk('public')->putFileAs('poster', $poster, $posterName);
            $data['poster'] = $posterName;
        }

        Event::create($data);
        return redirect()->route('admin.event.index')->with('success', 'Event Berhasil Ditambahkan');
    }

    public function update(Request $request, $id){
    $events = Event::findOrFail($id);
    
    $request->validate([
        'namaEvent' => 'required',
        'tempatEvent' => 'required',
        'deskripsi' => 'required',
        'tanggalEvent' => 'required',
        'waktuEvent' => 'required',
        'kuotaPeserta' => 'required',
        'hargaTiket' => 'required',
        'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'fileProposal' => 'nullable|mimes:pdf|max:2048',
    ], [
        'namaEvent.required' => 'Nama Event harus diisi',
        'tempatEvent.required' => 'Tempat Event harus diisi',
        'deskripsi.required' => 'Deskripsi harus diisi',
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
    if ($request->status === 'rejected') {
        $request->validate([
            'alasan' => 'required|string|min:5'
        ], [
            'alasan.required' => 'Alasan penolakan wajib diisi jika status ditolak.'
        ]);
    } else {
        $data['alasan'] = null;
    }

    if ($request->hasFile('fileProposal')) {
        if ($events->fileProposal) {
            Storage::disk('public')->delete('proposal/' . $events->fileProposal);
        }
        $file = $request->file('fileProposal');
        $fileName = $file->getClientOriginalName();
        Storage::disk('public')->putFileAs('proposal', $file, $fileName);
        $data['fileProposal'] = $fileName;
    } else {
        unset($data['fileProposal']); 
    }

    if ($request->hasFile('poster')) {
        if ($events->poster) {
            Storage::disk('public')->delete('poster/' . $events->poster);
        }
        $poster = $request->file('poster');
        $posterName = $poster->getClientOriginalName();
        Storage::disk('public')->putFileAs('poster', $poster, $posterName);
        $data['poster'] = $posterName;
    } else {
        unset($data['poster']);
    }

    $events->update($data);    
    return redirect()->route('admin.event.index')->with('success', 'Event Berhasil Diperbarui');
    }
    
    public function destroy($id){
        $events = Event::find($id);
        $events->delete();
        return redirect()->route('admin.event.index');
    }

    // Tambahkan method ini di dalam class EventController

public function updateStatus(Request $request, $id)
{
    $event = Event::findOrFail($id);

    // Validasi dasar
    $request->validate([
        'status' => 'required|in:pending,approved,rejected,cancelled',
    ]);

    // Validasi tambahan: Jika ditolak, kolom alasan wajib diisi
    if ($request->status === 'rejected') {
        $request->validate([
            'alasan' => 'required|string|min:5'
        ], [
            'alasan.required' => 'Alasan penolakan wajib diisi jika event ditolak.',
            'alasan.min' => 'Alasan penolakan minimal berisi 5 karakter.'
        ]);
        
        $event->alasan = $request->alasan;
    } else {
        // Jika status diubah kembali ke approved/pending/cancelled, hapus alasannya
        $event->alasan = null;
    }

    $event->status = $request->status;
    $event->save();

    return redirect()->route('admin.event.index')->with('success', 'Status Event Berhasil Diperbarui');
}


}
