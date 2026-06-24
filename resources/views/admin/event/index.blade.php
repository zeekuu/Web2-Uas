@extends('layouts.app')

@section('title')
    SIEKA - Data Event
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex flex-row justify-content-between align-items-center">
                <h4 class="card-title">
                    Data Event
                </h4>
                <div class=""><a href="{{ route('admin.event.create') }}" class="btn btn-primary">Tambah Event</a></div>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success"
                        style="padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 20px; border-radius: 4px;">
                        {{ session('success') }}
                    </div>
                @endif
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Penanggung Jawab</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Proposal</th>
                            <th>Poster</th>
                            <th>Status</th>
                            <th>Kuota Peserta</th>
                            <th>Harga Tiket</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->user->nama }}</td>
                                <td>{{ $item->namaEvent }}</td>
                                <td>{{ Str::limit($item->deskripsi, 100) }}</td>
                                <td> @if($item->fileProposal)
                                    <a href="{{ asset('storage/proposal/' . $item->fileProposal) }}"
                                        class="btn btn-sm btn-warning">Lihat
                                        Proposal</a>
                                @endif
                                </td>
                                <td>
                                    @if($item->poster)
                                        <a href="{{ asset('storage/poster/' . $item->poster) }}"
                                            class="btn btn-sm btn-warning">Lihat
                                            Poster</a>
                                    @endif
                                </td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->kuotaPeserta }} Peserta</td>
                                <td>Rp. {{ number_format($item->hargaTiket, 0, ',', '.') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Opsi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ route('admin.event.edit', $item->idEvent) }}"
                                                    class="dropdown-item">Edit</a></li>
                                            <li>
                                                <form action="{{ route('admin.event.destroy', $item->idEvent) }}" method="POST"
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