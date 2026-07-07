@extends('layouts.app')

@section('title','SIEKA - Data Transaksi')

@section('content')
    <div class="container">
        <div class="card border-0 shadow-sm mb-4 p-3">
            <div class="row">
                <div class="col-md-10">
                    <h3 class="fw-bold mb-1">Manajemen Transaksi</h3>
                    <p class="text-muted mb-0">Daftar Semua Informasi Transaksi yang Diajukan oleh Peserta dari Semua Event</p>
                </div>
            </div>
        </div>
            <div class="card border-0 shadow-sm p-3 mt-4">
                <table class="table table-bordered" id="table">
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
                            <th>Waktu Kehadiran</th>
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
                                    <span class="fw-bold text-success">Gratis</span>
                                    @else
                                    <span class="fw-bold text-success">Rp. {{ number_format($item->Event->hargaTiket, 0, ',', '.') }}</span>
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
                                    <span class="badge bg-secondary">{{ \Carbon\Carbon::parse($item->waktuHadir)->format('d M Y') }}</span><br>
                                    <small class="badge bg-secondary">{{ \Carbon\Carbon::parse($item->waktuHadir)->format('H:i') }} WIB</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection