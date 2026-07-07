@extends('layouts.app')
@section('title', 'SIEKA - Dashboard Panitia')

@section('content')
    <div class="container">
        <div class="mb-4">
            <div class="card p-4 bg-white border-0 shadow-sm">
                <h3 class="fw-bold mb-1">Selamat Datang, {{ Auth::user()->nama }}!</h3>
                <p class="text-muted mb-0">Pantau perkembangan penjualan tiket dan kelola pendaftaran event hari ini.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card bg-primary text-white border-0 shadow-sm h-100">
                    <a href="{{ route('panitia.event.index') }}" class="text-decoration-none text-white">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase small fw-bold">Event Aktif & Total Event</h6>
                                <h2 class="fw-bold mb-0">{{ $eventAktif }} / {{ $totalEvent }}</h2>
                            </div>
                            <span class="fs-1"><i class="fa-solid fa-calendar"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-warning text-dark border-0 shadow-sm h-100">
                    <a href="{{ route('panitia.transaksi.index') }}" class="text-decoration-none text-white">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase small fw-bold text-dark">Transaksi Pending</h6>
                                <h2 class="fw-bold mb-0">{{ $transaksiPending }}</h2>
                            </div>
                            <span class="fs-1"><i class="fa-solid fa-coins"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-success text-white border-0 shadow-sm h-100">
                    <a href="{{ route('panitia.transaksi.index') }}" class="text-decoration-none text-white">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase small fw-bold">Tiket Terjual</h6>
                                <h2 class="fw-bold mb-0">{{ $transaksiSelesai }}</h2>
                            </div>
                            <span class="fs-1"><i class="fa-solid fa-ticket"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-info text-white border-0 shadow-sm h-100">
                    <a href="{{ route('panitia.event.index') }}" class="text-decoration-none text-white">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase small fw-bold">Hadir di Lokasi</h6>
                                <h2 class="fw-bold mb-0">{{ $totalPesertaHadir }}</h2>
                            </div>
                            <span class="fs-1"><i class="fa-solid fa-users"></i></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-2">
            <div class="card-body text-center py-4">
                <h5 class="fw-bold fs-4 mb-0">SCAN TIKET</h5>
                <p class="text-muted">Gunakan scanner QR Code untuk memindai tiket peserta</p>
                <a href="{{ route('panitia.scan') }}" class="btn btn-primary px-4 fw-bold">
                    Buka Scanner QR Code
                </a>
            </div>
        </div>
        <div class="card border-0 shadow-sm p-3 d-flex justify-content-between mt-3 ">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="fw-bold">DAFTAR EVENT</h5>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <a href="{{ route('panitia.event.index') }}" class="btn btn-outline-primary px-3 fw-bold">Lihat Semua</a>
                </div>
            </div>
            <div class="row">
                @if ($eventRejected->isNotEmpty())
                    <div class="col-md-12 mt-3">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Event</th>
                                        <th>Status</th>
                                        <th>Alasan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($eventRejected as $index => $item)
                                        <tr class="table-danger">
                                            <td>{{ $index + 1 }}</td>
                                            <td><strong class="text-dark">{{ $item->namaEvent ?? $item->nama }}</strong></td>
                                            <td><small class="badge bg-danger">{{ $item->status }}</small> </td>
                                            <td>{{ $item->alasan }}</td>
                                            <td>
                                                <a href="{{ route('panitia.event.edit', $item->idEvent) }}" class="btn btn-sm btn-primary">Pengajuan Ulang</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                
                @endif
            </div>
            <div class="row">
                <div class="col-md-6 p-3 mt-4">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Event</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($eventPending->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Tidak ada data event pending.</td>
                                    </tr>
                                @else
                                @foreach($eventPending as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong class="text-dark">{{ $item->namaEvent ?? $item->nama }}</strong></td>
                                        <td>
                                            <small class="badge bg-secondary text-white">{{ $item->status }}</small>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6 p-3 mt-4">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Event</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($eventApproved->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Tidak ada data event approved.</td>
                                    </tr>
                                @else
                                @foreach($eventApproved as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong class="text-dark">{{ $item->namaEvent ?? $item->nama }}</strong></td>
                                        <td><small class="badge bg-success">{{ $item->status }}</small> </td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection