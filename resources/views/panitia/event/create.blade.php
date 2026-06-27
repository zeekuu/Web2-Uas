@extends('layouts.app')
@section('title', 'SIEKA - Ajukan Event Baru')

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('panitia.event.index') }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-arrow-left"></i> KEMBALI</a>
    </div>

    <div class="card border-0 shadow-sm max-width-md p-4 bg-white">
        <h4 class="fw-bold text-dark mb-4">Form Pengajuan Acara Baru</h4>

        <form action="{{ route('panitia.event.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="namaEvent" class="form-label fw-bold small text-muted">NAMA ACARA / EVENT</label>
                <input type="text" class="form-control @error('namaEvent') is-invalid @enderror" id="namaEvent" name="namaEvent" value="{{ old('namaEvent') }}" required>
                @error('namaEvent') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label fw-bold small text-muted">DESKRIPSI LENGKAP</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggalEvent" class="form-label fw-bold small text-muted">TANGGAL PELAKSANAAN</label>
                    <input type="date" class="form-control @error('tanggalEvent') is-invalid @enderror" id="tanggalEvent" name="tanggalEvent" value="{{ old('tanggalEvent') }}" required>
                    @error('tanggalEvent') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="waktuEvent" class="form-label fw-bold small text-muted">WAKTU MULAI (WIB)</label>
                    <input type="text" class="form-control @error('waktuEvent') is-invalid @enderror" id="waktuEvent" name="waktuEvent" value="{{ old('waktuEvent') }}" placeholder="hh:mm - hh:mm" required>
                    @error('waktuEvent') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="tempatEvent" class="form-label fw-bold small text-muted">TEMPAT / LOKASI ACARA</label>
                <input type="text" class="form-control @error('tempatEvent') is-invalid @enderror" id="tempatEvent" name="tempatEvent" value="{{ old('tempatEvent') }}" required>
                @error('tempatEvent') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kuotaPeserta" class="form-label fw-bold small text-muted">BATAS KUOTA (KURSI)</label>
                    <input type="number" class="form-control @error('kuotaPeserta') is-invalid @enderror" id="kuotaPeserta" name="kuotaPeserta" value="{{ old('kuotaPeserta') }}" min="1" required>
                    @error('kuotaPeserta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="hargaTiket" class="form-label fw-bold small text-muted">HARGA TIKET (Isi 0 jika Gratis)</label>
                    <input type="number" class="form-control @error('hargaTiket') is-invalid @enderror" id="hargaTiket" name="hargaTiket" value="{{ old('hargaTiket', 0) }}" min="0" required>
                    @error('hargaTiket') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="poster" class="form-label fw-bold small text-muted">UPLOAD POSTER EVENT (Maks 2MB)</label>
                    <input type="file" class="form-control @error('poster') is-invalid @enderror" id="poster" name="poster" required>
                    @error('poster') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="fileProposal" class="form-label fw-bold small text-muted">UPLOAD FILE PROPOSAL (Maks 2MB)</label>
                    <input type="file" class="form-control @error('brosur') is-invalid @enderror" id="brosur" name="brosur" required>
                    @error('brosur') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">Kirim Pengajuan Event</button>
        </form>
    </div>
</div>
@endsection