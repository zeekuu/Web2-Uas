@extends('layouts.app')
@section('title', 'SIEKA - Tiket Saya')

@section('content')
    <div class="container">
        <div class="mb-4">
            <div class="card p-3 bg-white border-0 shadow-sm">
                <h3 class="fw-bold">Tiket Saya</h3>
                <p class="fw-bold mb-0">Riwayat pemesanan tiket dan status pembayaran Anda.</p>
            </div>
        </div>

        <div class="row">
            @forelse($transaksis as $item)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="card-title fw-bold text-primary mb-1">
                                        {{ $item->event->namaEvent ?? 'Event Telah Dihapus' }}
                                    </h5>
                                    <small class="text-muted d-block">
                                        <i class="fa-solid fa-location-pin"></i> {{ $item->event->tempatEvent ?? '-' }}
                                    </small>
                                    <small class="text-muted d-block">
                                        <i class="fa-solid fa-calendar"></i> {{ \Carbon\Carbon::parse($item->event->tanggalEvent)->translatedFormat('l, d F Y') ?? '-' }} | <i class="fa-solid fa-clock"></i> {{ $item->event->waktuEvent ?? '-' }}
                                    </small>
                                </div>

                                <div>
                                    @if($item->status === 'pending')
                                    <span class="badge bg-warning text-dark">MENUNGGU VERIFIKASI</span>
                                    @elseif($item->status === 'paid')
                                    <span class="badge bg-success">PAID</span>
                                    @elseif($item->status === 'rejected')
                                        <span class="badge bg-danger">DITOLAK</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                                    @endif
                                </div>
                            </div>

                            <hr class="text-muted my-2">

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block">Jumlah Tiket</small>
                                    <span class="fw-bold">1 Tiket</span>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">Total Bayar</small>
                                    <span
                                        class="fw-bold text-success">Rp{{ number_format($item->event->hargaTiket, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            @if($item->status === 'approved' || $item->status === 'success')
                                <div class="mt-3">
                                    <button class="btn btn-sm btn-outline-primary w-100"
                                        onclick="alert('Fitur cetak E-Tiket / QR Code belum terpasang.')">
                                        🖨️ Cetak E-Tiket
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="card p-5 bg-white border-0 shadow-sm">
                        <p class="text-muted fs-5 mb-3">Anda belum memesan tiket apapun.</p>
                        <div>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Cari Event Menarik</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection