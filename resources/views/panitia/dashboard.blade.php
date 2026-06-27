@extends('layouts.app')
@section('title', 'SIEKA - Dashboard Panitia')

@section('content')
<div class="container">
    <div class="mb-4">
        <div class="card p-4 bg-white border-0 shadow-sm">
            <h3 class="fw-bold mb-1">👋 Selamat Datang, {{ Auth::user()->nama }}!</h3>
            <p class="text-muted mb-0">Pantau perkembangan penjualan tiket dan kelola pendaftaran event hari ini.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase small fw-bold">Event Aktif</h6>
                        <h2 class="fw-bold mb-0">{{ $totalEvent }}</h2>
                    </div>
                    <span class="fs-1">📅</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-dark border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase small fw-bold text-muted">Transaksi Pending</h6>
                        <h2 class="fw-bold mb-0">{{ $transaksiPending }}</h2>
                    </div>
                    <span class="fs-1">⏳</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase small fw-bold">Tiket Terjual</h6>
                        <h2 class="fw-bold mb-0">{{ $transaksiSelesai }}</h2>
                    </div>
                    <span class="fs-1">🎟️</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase small fw-bold">Hadir di Lokasi</h6>
                        <h2 class="fw-bold mb-0">{{ $totalPesertaHadir }}</h2>
                    </div>
                    <span class="fs-1">👥</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-2">
        <div class="card-body text-center py-4">
            <h5 class="fw-bold">Buka Meja Registrasi Lapangan?</h5>
            <p class="text-muted">Gunakan alat pemindai kamera untuk memverifikasi QR Code tiket bawaan peserta secara realtime.</p>
            <a href="{{ route('panitia.scan.index') }}" class="btn btn-primary px-4 fw-bold">
                Buka Scanner QR Code
            </a>
        </div>
    </div>
</div>
@endsection