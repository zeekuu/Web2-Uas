@extends('layouts.app')
@section('title', 'SIEKA - Transaksi Masuk')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <div class="card p-3 bg-white border-0 shadow-sm">
                <h3 class="fw-bold mb-1">📑 Transaksi Masuk</h3>
                <p class="text-muted mb-0">Periksa bukti transfer kiriman pendaftar dan lakukan persetujuan penerbitan tiket.</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm p-3">
        <div class="table-responsive">
            <table class="table table-striped align-middle" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Nama Event</th>
                        <th>Bukti Transfer</th>
                        <th>Status</th>
                        <th>Kehadiran</th>
                        <th class="text-center">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksis as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong class="text-dark d-block">{{ $item->User->nama ?? '-' }}</strong>
                                <small class="text-muted">{{ $item->User->email ?? '-' }}</small>
                            </td>
                            <td>{{ $item->Event->namaEvent ?? $item->Event->nama ?? 'Event Telah Dihapus' }}</td>
                            <td>
                                @if($item->buktiTransfer)
                                    <a href="{{ asset('storage/buktiTransfer/' . $item->buktiTransfer) }}" class="btn btn-sm btn-warning">
                                        Lihat Bukti
                                    </a>
                                @else
                                    <span class="text-muted small">Tidak Ada File</span>
                                @endif
                            </td>
                            <td>
                                @if($item->status === 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @elseif($item->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($item->status === 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $item->kehadiran == 1 ? 'bg-info' : 'bg-secondary' }}">
                                    {{ $item->kehadiran == 1 ? 'HADIR' : 'BELUM HADIR' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($item->status === 'pending')
                                    <div class="d-flex justify-content-center gap-1">
                                        <form action="{{ route('panitia.transaksi.approve', $item->idTransaksi) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success fw-bold" onclick="return confirm('Setujui pembayaran & kirim QR code ke email user?')">
                                                Confirm
                                            </button>
                                        </form>

                                        <form action="{{ route('panitia.transaksi.reject', $item->idTransaksi) }}" method="POST">
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