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

                            @if($item->status === 'paid')
                            <div class="mt-3 pt-3 border-top">
                                <button class="btn btn-sm btn-primary w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#qrModal{{ $item->idTransaksi }}">
                                    📱 Tampilkan QR Code Masuk
                                </button>
                            </div>
                            <div class="modal fade" id="qrModal{{ $item->idTransaksi }}" tabindex="-1" aria-labelledby="qrModalLabel{{ $item->idTransaksi }}" aria-hidden="true">
                                <div class="modal-dialog modal-sm modal-dialog-centered">
                                    <div class="modal-content text-center p-3">
                                        <h6 class="fw-bold mb-3" id="qrModalLabel{{ $item->idTransaksi }}">QR Code Tiket Masuk</h6>
                                        
                                        <div class="bg-white p-2 rounded mb-2 border shadow-sm d-flex justify-content-center align-items-center">
                                            <img src="{{ asset('storage/qrcode/' . $item->qr_code) }}" class="img-fluid" alt="QR Code Tiket" style="width: 220px; height: 220px;">
                                        </div>
                                        
                                        <small class="text-muted d-block mt-2">Tunjukkan QR ini ke meja panitia saat registrasi ulang di lokasi event</small>
                                        <button type="button" class="btn btn-sm btn-secondary mt-3 w-100" data-bs-dismiss="modal">Tutup Halaman</button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mt-3 pt-3 border-top text-center">
                                <span class="text-muted small d-block bg-light p-2 rounded border">
                                    🔒 QR Code Tiket akan otomatis aktif setelah kiriman bukti transfer Anda selesai diverifikasi panitia.
                                </span>
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