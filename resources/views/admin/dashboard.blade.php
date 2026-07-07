@extends('layouts.app')
@section('title', 'SIEKA - Dashboard Admin')

@section('content')
    <div class="container">
        <div class="mb-4">
            <div class="card p-4 bg-white border-0 shadow-sm">
                <h3 class="fw-bold mb-1">Selamat Datang, {{ Auth::user()->nama }}!</h3>
                <p class="text-muted mb-0">Pantau perkembangan sistem dan kelola pendaftaran event hari ini.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card bg-primary text-white border-0 shadow-sm h-100">
                    <a href="{{ route('admin.event.index') }}" class="text-decoration-none text-white">
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
                <div class="card bg-warning text-white border-0 shadow-sm h-100">
                    <a href="{{ route('admin.transaksi.index') }}" class="text-decoration-none text-white">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase small fw-bold">Tiket Terjual</h6>
                                <h2 class="fw-bold mb-0">{{ $transaksiSelesai }} / {{ $tiket }}</h2>
                            </div>
                            <span class="fs-1"><i class="fa-solid fa-ticket"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-success text-white border-0 shadow-sm h-100">
                    <a href="{{ route('admin.transaksi.index') }}" class="text-decoration-none text-white">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase small fw-bold">Total Pendapatan</h6>
                                <h2 class="fw-bold mb-0">Rp. {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                            </div>
                            <span class="fs-1"><i class="fa-solid fa-coins"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-info text-white border-0 shadow-sm h-100">
                    <a href="{{ route('admin.user.index') }}" class="text-decoration-none text-white">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase small fw-bold">Total User</h6>
                                <h2 class="fw-bold mb-0">{{ $totalUser }}</h2>
                            </div>
                            <span class="fs-1"><i class="fa-solid fa-users"></i></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm p-4 bg-white mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-dark mb-0">DAFTAR EVENT</h4>
                <a href="{{ route('admin.event.index') }}" class="btn btn-outline-primary fw-bold px-3">
                    Lihat Semua
                </a>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @forelse($events as $event)
                    <div class="col">
                        <div class="card h-100 shadow-sm border border-light overflow-hidden rounded-4 bg-white">

                            <div style="height: 160px; overflow: hidden;" class="position-relative">
                                @if($event->poster)
                                    <img src="{{ asset('storage/poster/' . $event->poster) }}" class="w-100 h-100 object-fit-cover"
                                        alt="poster">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted">
                                        <span class="small">🖼️ No Poster</span>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                                <h5 class="card-title fw-bold text-dark fs-6 mb-2 text-truncate"
                                    title="{{ $event->namaEvent }}">
                                    {{ $event->namaEvent }}
                                </h5>

                                <div class="d-flex align-items-center text-muted gap-2 small">
                                    <i class="fa-regular fa-clock"></i>
                                    <span class="text-truncate">
                                        {{ \Carbon\Carbon::parse($event->tanggalEvent)->translatedFormat('d M Y') }},
                                        {{ $event->waktuEvent }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted mb-0">Tidak ada event yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-dark mb-0">DAFTAR USER</h4>
                <a href="{{ route('admin.user.index') }}" class="btn btn-outline-primary fw-bold px-3">
                    Lihat Semua
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Nim</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->nim }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    @if ($item->role === 'admin')
                                    <span class="badge bg-warning text-dark">ADMIN</span>
                                @elseif ($item->role === 'panitia')
                                    <span class="badge bg-success text-white">PANITIA</span>
                                @elseif ($item->role === 'user')
                                    <span class="badge bg-primary text-white">USER</span>
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