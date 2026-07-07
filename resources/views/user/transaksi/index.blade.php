@extends('layouts.app')
@section('title', 'SIEKA - Tiket Saya')

@section('content')
    <div class="container">
        <div class="mb-4">
            <div class="card p-3 bg-white border-0 shadow-sm">
                <h3 class="fw-bold">Tiket Saya</h3>
                <p class="fw-bold mb-0">Riwayat pemesanan tiket dan status pembayaran Anda.</p>
            </div>
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm mb-4">{{ session('error') }}</div>
        @endif
        </div>

        <div class="row">
            @forelse($transaksis as $item)
                <div class="col-md-4 mb-4">
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
                                    @if($item->kehadiran == 1)
                                        <span class="badge bg-secondary text-white">SUDAH HADIR</span>
                                    @elseif($item->status === 'pending')
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
                                    @if ($item->hargaTiket == 0)
                                        <span class="fw-bold text-success">Gratis</span>
                                    @else
                                    <span class="fw-bold text-success">Rp{{ number_format($item->event->hargaTiket, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>

                            @if($item->kehadiran == 1)
                                <div class="mt-3 pt-3 border-top text-center">
                                    <span class="text-success small d-block bg-success bg-opacity-10 p-2 rounded border border-success fw-bold">
                                        Tiket sudah berhasil di-scan.
                                    </span>
                                </div>

                            @elseif($item->status === 'paid')
                                <div class="mt-3 pt-3 border-top">
                                    <button class="btn btn-sm btn-primary w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#qrModal{{ $item->idTransaksi }}">
                                        Tampilkan QR Code Masuk
                                    </button>
                                </div>
                                
                                <div class="modal fade" id="qrModal{{ $item->idTransaksi }}" tabindex="-1" aria-labelledby="qrModalLabel{{ $item->idTransaksi }}" aria-hidden="true">
                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                        <div class="modal-content text-center p-3">
                                            <h6 class="fw-bold mb-3" id="qrModalLabel{{ $item->idTransaksi }}">QR Code Tiket Masuk</h6>
                                            
                                            <div class="bg-white p-2 rounded mb-2 border shadow-sm d-flex justify-content-center align-items-center">
                                                <img src="{{ asset('storage/qrcode/' . $item->qr_code) }}" class="img-fluid" alt="QR Code Tiket" style="width: 220px; height: 220px;">
                                            </div>
                                            
                                            <small class="text-muted d-block mt-2">Tunjukkan QR ini ke meja panitia untuk masuk ke acara</small>
                                            <button type="button" class="btn btn-sm btn-secondary mt-3 w-100" data-bs-dismiss="modal">Tutup Halaman</button>
                                        </div>
                                    </div>
                                </div>

                            @elseif($item->status === 'pending')
                                <div class="mt-3 pt-3 border-top text-center">
                                    <span class="text-muted small d-block bg-light p-2 rounded border">
                                        Transaksi Anda Masih Menunggu Verifikasi.
                                    </span>
                                </div>

                            @elseif($item->status === 'rejected')
                                <div class="mt-3 pt-3 border-top text-center">
                                    <span class="text-danger small d-block bg-danger bg-opacity-10 p-2 rounded border border-danger fw-bold">
                                        Pembayaran Anda ditolak oleh panitia. Silakan hubungi admin.
                                    </span>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-1">
                    <div class="card p-3 bg-white border-0 shadow-sm">
                        <p class="text-muted fs-5 mb-2">Anda belum memesan tiket apapun.</p>
                        <div>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Cari Event Menarik</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection