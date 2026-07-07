@extends('layouts.app')

@section('title', 'SIEKA - Data Transaksi')

@section('content')
    <div class="container">
        <div class="card border-0 shadow-sm mb-4 p-3">
            <div class="row">
                <div class="col-md-10">
                    <h3 class="fw-bold mb-1">Data Transaksi</h3>
                    <p class="text-muted mb-0">Daftar Semua Informasi Transaksi yang Diajukan oleh Peserta dari Semua Event
                    </p>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow-sm p-3 mt-4">
            <table class="table table-striped table-hover align-middle" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peserta</th>
                        <th>Nama Event</th>
                        <th>Harga Tiket</th>
                        <th>Bukti Transfer</th>
                        <th>Status Pembayaran</th>
                        <th>QR Code</th>
                        <th>Kehadiran</th>
                        <th>Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksis as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->user->nama }}</td>
                            <td>{{ $item->event->namaEvent }}</td>
                            <td>
                                @if ($item->Event->hargaTiket === 0)
                                <span class="fw-bold text-success fs-6">Gratis</span>
                                @else
                                <span class="fw-bold text-success fs-6">Rp. {{ number_format($item->Event->hargaTiket, 0, ',', '.') }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->buktiTransfer)
                                    <a href="{{ asset('storage/buktiTransfer/' . $item->buktiTransfer) }}"
                                        class="btn btn-sm btn-warning">
                                        LIHAT BUKTI
                                    </a>
                                @else
                                    <span class="text-muted small">Tidak Ada File</span>
                                @endif
                            </td>

                            <td>
                                @if ($item->status === 'paid')
                                    <span class="badge bg-success">PAID</span>
                                @elseif($item->status === 'pending')
                                    <span class="badge bg-warning text-dark">PENDING</span>
                                @elseif($item->status === 'cancelled')
                                    <span class="badge bg-danger">CANCELLED</span>
                                @endif
                            </td>
                            <td>{{ $item->qr_code }}</td>
                            <td>
                                <span class="badge {{ $item->kehadiran == 1 ? 'bg-info' : 'bg-secondary' }}">
                                    {{ $item->kehadiran == 1 ? 'HADIR' : 'BELUM HADIR' }}
                                </span>
                            </td>
                            <td>
                                @if($item->status === 'pending')
                                    <div class="d-flex justify-content-center gap-1">
                                        <form action="{{ route('panitia.transaksi.approve', $item->idTransaksi) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success fw-bold"
                                                onclick="return confirm('Setujui pembayaran & kirim QR code ke email user?')">
                                                Confirm
                                            </button>
                                        </form>

                                        <form action="{{ route('panitia.transaksi.reject', $item->idTransaksi) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-danger fw-bold"
                                                onclick="return confirm('Tolak transaksi pendaftaran ini?')">
                                                Cancel
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small text-uppercase fw-bold">Selesai Diproses</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection