@extends('layouts.app')
@section('title', 'SIEKA - Manajemen Event')

@section('content')
<div class="container">
        <div class="card bg-white border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="fw-bold mb-1">Manajemen Event</h3>
                            <p class="text-muted mb-0">Kelola informasi jadwal pelaksanaan, kuota, serta brosur poster event Anda.</p>
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
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if($item->poster)
                                    <img src="{{ asset('storage/poster/' . $item->poster) }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <span class="badge bg-secondary">No Image</span>
                                @endif
                            </td>
                            <td><strong class="text-dark">{{ $item->namaEvent ?? $item->nama }}</strong></td>
                            <td>
                                <small class="d-block text-muted"> Lokasi {{ $item->tempatEvent }}</small>
                                <small class="d-block text-muted"> {{ Carbon\Carbon::parse($item->tanggalEvent)->translatedFormat('l, d F Y') }} | Waktu {{ $item->waktuEvent }}</small>
                            </td>
                            <td><span class="badge bg-info text-dark">{{ $item->kuotaPeserta }} Kursi</span></td>
                            <td>
                                <strong class="text-success">
                                    {{ $item->hargaTiket == 0 ? 'Gratis' : 'Rp' . number_format($item->hargaTiket, 0, ',', '.') }}
                                </strong>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('panitia.event.edit', $item->idEvent) }}" class="btn btn-sm btn-warning fw-bold">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('panitia.event.destroy', $item->idEvent) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger fw-bold" onclick="return confirm('Apakah Anda yakin ingin menghapus event ini?')">
                                            🗑️ Hapus
                                        </button>
                                    </form>
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