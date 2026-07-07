@extends('layouts.app')
@section('title', 'SIEKA - Detail Event')

@section('content')
    <div class="container py-2">
        <div class="card border-0 shadow-sm bg-white p-3 mb-3 rounded-3">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary fw-bold px-3">
                    KEMBALI
                </a>
                <h3 class="fw-bold mb-0 text-dark fs-4">PEMESANAN TIKET</h3>
            </div>
            @error('error')
                <div class="alert alert-danger border-0 shadow-sm mt-3 mb-0">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm border-0 overflow-hidden rounded-3">
                    @if($events->poster)
                        <img src="{{ asset('storage/poster/' . $events->poster) }}" class="img-fluid w-100 object-fit-cover"
                            alt="Poster Event" style="max-height: 500px;">
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                            style="height: 350px;">
                            <span class="fs-5">🖼️ No Poster Available</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-7 mb-4">
                <div class="card shadow-sm border-0 h-100 p-4 bg-white rounded-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h2 class="fw-bold text-dark mb-0">{{ $events->nama ?? $events->namaEvent }}</h2>
                        <span class="badge bg-success px-3 py-2">Aktif</span>
                    </div>

                    <hr class="text-muted mt-0">

                    <h5 class="fw-bold mb-3">Waktu & Lokasi</h5>
                    <div class="row mb-4">
                        <div class="col-sm-6 mb-3">
                            <div class="p-3 bg-light rounded border-start border-primary border-3">
                                <small class="text-muted d-block">TANGGAL PELAKSANAAN</small>
                                <span
                                    class="fw-bold text-dark">{{ \Carbon\Carbon::parse($events->tanggalEvent)->translatedFormat('l, d F Y') ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="p-3 bg-light rounded border-start border-primary border-3">
                                <small class="text-muted d-block">WAKTU UTAMA</small>
                                <span class="fw-bold text-dark">{{ $events->waktuEvent }} WIB</span>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="p-3 bg-light rounded border-start border-primary border-3">
                                <small class="text-muted d-block">TEMPAT / LOKASI</small>
                                <span class="fw-bold text-dark">{{ $events->tempatEvent }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="p-3 bg-light rounded border-start border-primary border-3">
                                <small class="text-muted d-block">KUOTA TERSEDIA</small>
                                <span class="fw-bold text-dark">{{ $events->kuotaPeserta }} Kursi</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5 class="fw-bold mb-2">Deskripsi Event</h5>
                            <p class="text-muted mb-4" style="text-align: justify;">{{ $events->deskripsi }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="fw-bold mb-2">Harga Tiket</h5>
                            <p class="text-success fw-bold mb-4">
                                @if($events->hargaTiket == 0)
                                    Gratis
                                @else
                                    Rp{{ number_format($events->hargaTiket, 0, ',', '.') }}
                                @endif
                            </p>
                        </div>
                        @if($events->hargaTiket > 0)
                            <div class="col-sm-6">
                                <h5 class="fw-bold mb-2">No Rekening</h5>
                                <p class="text-muted mb-4">{{ $events->rekening }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mt-auto bg-light p-3 rounded-3 border">
                        <form action="{{ route('user.transaksi.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="idEvent" value="{{ $events->idEvent }}">

                            @if($events->kuotaPeserta > 0)
                                @if ($events->hargaTiket === 0)
                                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin memesan tiket event gratis ini?')">
                                        Daftar Event Gratis
                                    </button>
                                @else
                                    <div class="mb-3">
                                        <label for="buktiTransfer" class="form-label small fw-bold text-muted">
                                            UPLOAD BUKTI TRANSFER (Maks 2MB)
                                        </label>
                                        <input type="file" class="form-control @error('buktiTransfer') is-invalid @enderror"
                                            id="buktiTransfer" name="buktiTransfer" required>
                                        @error('buktiTransfer')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm"
                                        onclick="return confirm('Apakah Anda yakin bukti transfer sudah benar?')">
                                        Konfirmasi & Beli Tiket Masuk
                                    </button>
                                @endif
                            @else
                                <button type="button" class="btn btn-danger btn-lg w-100 fw-bold" disabled>
                                    Kuota Tiket Habis
                                </button>
                            @endif
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection