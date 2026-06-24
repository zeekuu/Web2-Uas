@extends('layouts.app')
@section('title')
    SIEKA - Edit Event
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    Edit Event
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.event.update', $events->idEvent)  }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="namaEvent">Nama Event</label>
                            <input type="text" class="form-control" id="namaEvent" name="namaEvent"
                                value="{{ $events->namaEvent }}" >
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tempatEvent">Tempat Event</label>
                            <input type="text" class="form-control" id="tempatEvent" name="tempatEvent"
                                value="{{ $events->tempatEvent }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="idUser">Penanggung Jawab</label>
                            <select name="idUser" id="idUser" class="form-select">
                                <option value="">Opsi</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->idUser }}" {{ $user->idUser == $events->idUser ? 'selected' : '' }}>{{ $user->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" >{{ old('deskripsi', $events->deskripsi) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggalEvent">Tanggal Event</label>
                            <input type="date" class="form-control" id="tanggalEvent" name="tanggalEvent"
                                value="{{ $events->tanggalEvent }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="waktuEvent">Waktu Pelaksanaan</label>
                            <input type="text" class="form-control" id="waktuEvent" name="waktuEvent"
                                value="{{ $events->waktuEvent }}" placeholder="hh:mm - hh:mm">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kuotaPeserta">Jumlah Peserta</label>
                            <input type="number" class="form-control" id="kuotaPeserta" name="kuotaPeserta"
                                value="{{ $events->kuotaPeserta }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hargaTiket">Harga Tiket</label>
                            <input type="number" class="form-control" id="hargaTiket" name="hargaTiket"
                                value="{{$events->hargaTiket}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="fileProposal">Proposal</label>
                            <input type="file" class="form-control" id="fileProposal" name="fileProposal"
                                value="{{ $events->fileProposal }}">
                            @if($events->fileProposal)
                                File saat ini: <a href="{{ asset('storage/proposal/' . $events->fileProposal) }}">Lihat Proposal</a>
                            @endif
                        </div>
                        <div class="col-md-5 mb-3">
                            <label for="poster">Poster</label>
                            <input type="file" class="form-control" id="poster" name="poster"
                                value="{{ $events->poster }}">
                            @if($events->poster)
                                File saat ini: <a href="{{ asset('storage/poster/' . $events->poster) }}">Lihat Poster</a>
                            @endif
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">Opsi</option>
                                <option value="pending" {{ $events->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $events->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $events->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="cancelled" {{ $events->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-2 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.event.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection