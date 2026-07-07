@extends('layouts.app')
@section('title', 'SIEKA - Manajemen Event')

@section('content')
    <div class="container">
        <div class="card bg-white border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <h3 class="fw-bold mb-1">Manajemen Event</h3>
                        <p class="text-muted mb-0">Kelola informasi jadwal pelaksanaan, kuota, serta brosur poster event
                            Anda.</p>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('panitia.event.create') }}" class="btn btn-primary py-3 px-4 fw-bold">
                            Buat Event Baru
                        </a>
                    </div>
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
                            <th>Poster</th>
                            <th>Nama Event</th>
                            <th>Waktu & Lokasi</th>
                            <th>Kuota</th>
                            <th>Harga Tiket</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $index => $item)
                        @if ($item->status === 'rejected' || $item->status === 'cancelled')
                            <tr class="table-danger">
                        @endif
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($item->poster)
                                        <img src="{{ asset('storage/poster/' . $item->poster) }}" class="rounded"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <span class="badge bg-secondary">No Image</span>
                                    @endif
                                </td>
                                <td><strong class="text-dark">{{ $item->namaEvent ?? $item->nama }}</strong></td>
                                <td>
                                    <small class="d-block text-muted"> Lokasi {{ $item->tempatEvent }}</small>
                                    <small class="d-block text-muted">
                                        {{ Carbon\Carbon::parse($item->tanggalEvent)->translatedFormat('l, d F Y') }} | Waktu
                                        {{ $item->waktuEvent }}</small>
                                </td>
                                <td><span class="badge bg-info text-dark">{{ $item->kuotaPeserta }} Kursi</span></td>
                                <td>
                                    <strong class="text-success">
                                        @if($item->hargaTiket == 0)
                                            Gratis
                                        @else
                                            Rp. {{ number_format($item->hargaTiket, 0, ',', '.') }}
                                        @endif
                                    </strong>
                                </td>
                                <td>
                                    <div class="badge bg text-dark fs-6">
                                        @if($item->status == 'pending')
                                            <small class="badge bg-secondary text-white">Pending</small>
                                        @elseif($item->status == 'approved')
                                            <small class="badge bg-success text-white">Approved</small>
                                        @elseif($item->status == 'rejected')
                                            <small class="badge bg-danger text-white">Rejected</small>
                                        @elseif($item->status == 'cancelled')
                                            <small class="badge bg-danger text-white">Cancelled</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Opsi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ route('panitia.event.edit', $item->idEvent) }}"
                                                    class="dropdown-item">Edit</a></li>
                                            <li>
                                                <form action="{{ route('panitia.event.destroy', $item->idEvent) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn dropdown-item text-danger"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus event ini?')">Hapus</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection