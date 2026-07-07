@extends('layouts.app')
@section('title', 'SIEKA - Ajukan Event Baru')

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('panitia.event.index') }}" class="btn btn-sm btn-primary"> KEMBALI</a>
    </div>

    <div class="card border-0 shadow-sm max-width-md p-4 bg-white">
        <h4 class="fw-bold text-dark mb-4">FORM PENGAJUAN EVENT</h4>

        <form action="{{ route('panitia.event.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="namaEvent" class="form-label fw-bold small text-muted">NAMA EVENT</label>
                <input type="text" class="form-control @error('namaEvent') is-invalid @enderror" id="namaEvent" name="namaEvent" value="{{ old('namaEvent') }}" >
                @error('namaEvent') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label fw-bold small text-muted">DESKRIPSI ACARA</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4" >{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggalEvent" class="form-label fw-bold small text-muted">TANGGAL PELAKSANAAN</label>
                    <input type="date" class="form-control @error('tanggalEvent') is-invalid @enderror" id="tanggalEvent" name="tanggalEvent" value="{{ old('tanggalEvent') }}" >
                    @error('tanggalEvent') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="waktuEvent" class="form-label fw-bold small text-muted">WAKTU MULAI (WIB)</label>
                    <input type="text" class="form-control @error('waktuEvent') is-invalid @enderror" id="waktuEvent" name="waktuEvent" value="{{ old('waktuEvent') }}" placeholder="hh:mm - hh:mm" >
                    @error('waktuEvent') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="tempatEvent" class="form-label fw-bold small text-muted">TEMPAT / LOKASI ACARA</label>
                <input type="text" class="form-control @error('tempatEvent') is-invalid @enderror" id="tempatEvent" name="tempatEvent" value="{{ old('tempatEvent') }}" >
                @error('tempatEvent') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-2 mb-3">
                    <label for="kuotaPeserta" class="form-label fw-bold small text-muted">KUOTA PESERTA</label>
                    <input type="number" class="form-control @error('kuotaPeserta') is-invalid @enderror" id="kuotaPeserta" name="kuotaPeserta" value="{{ old('kuotaPeserta') }}" min="1" >
                    @error('kuotaPeserta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-5 mb-3">
                    <label for="hargaTiket" class="form-label fw-bold small text-muted">HARGA TIKET (Isi 0 jika Gratis)</label>
                    <input type="integer" class="form-control @error('hargaTiket') is-invalid @enderror" id="hargaTiket" name="hargaTiket" value="{{ old('hargaTiket') }}" >
                    @error('hargaTiket') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-5 mb-3">
                    <label for="rekening" class="form-label fw-bold small text-muted">REKENING PEMBAYARAN</label>
                    <input type="text" class="form-control @error('rekening') is-invalid @enderror" id="rekening" name="rekening" value="{{ old('rekening') }}" >
                    @error('rekening') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="poster" class="form-label fw-bold small text-muted">UPLOAD POSTER EVENT (Maks 2MB)</label>
                    <input type="file" class="form-control @error('poster') is-invalid @enderror" id="poster" name="poster" >
                    @error('poster') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="fileProposal" class="form-label fw-bold small text-muted">UPLOAD FILE PROPOSAL (Maks 2MB)</label>
                    <input type="file" class="form-control @error('fileProposal') is-invalid @enderror" id="fileProposal" name="fileProposal" >
                    @error('fileProposal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">Kirim Pengajuan Event</button>
        </form>
    </div>
</div>
@endsection