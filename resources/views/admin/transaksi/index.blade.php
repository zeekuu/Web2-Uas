@extends('layouts.app')

@section('title')
    SIEKA - Data Transaksi
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    Data Transaksi
                </h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Peserta</th>
                            <th>Nama Event</th>
                            <th>Bukti Transfer</th>
                            <th>Status Pembayaran</th>
                            <th>QR Code</th>
                            <th>Kehadiran</th>
                            <th>Waktu Kehadiran</th>
                            <th>aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksis as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->user->nama }}</td>
                                <td>{{ $item->event->namaEvent }}</td>
                                <td>
                                    @if ($item->buktiTransfer)
                                        <a href="{{ asset('storage/buktiTransfer/' . $item->buktiTransfer) }}"
                                            class="btn btn-sm btn-warning">
                                            Lihat Bukti
                                        </a>
                                    @else
                                        <span class="text-muted small">Tidak Ada File</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status === 'paid')
                                    <span class="badge bg-success">Paid</span>
                                    @elseif($item->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($item->status === 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </td>
                                <td>{{ $item->qr_code }}</td>
                                <td>
                                    <span class="badge {{ $item->kehadiran == 1 ? 'bg-info' : 'bg-secondary' }}">
                                        {{ $item->kehadiran == 1 ? 'HADIR' : 'BELUM HADIR' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $item->waktuHadir }}</span>
                                </td>
                                <td>@if($item->status === 'pending')
                                    <div class="d-flex justify-content-center gap-1">
                                        <form action="{{ route('admin.transaksi.approve', $item->idTransaksi) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success fw-bold" onclick="return confirm('Setujui pembayaran & kirim QR code ke email user?')">
                                                Confirm
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.transaksi.reject', $item->idTransaksi) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-danger fw-bold" onclick="return confirm('Tolak transaksi pendaftaran ini?')">
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