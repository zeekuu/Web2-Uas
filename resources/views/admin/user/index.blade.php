@extends('layouts.app')

@section('title', 'SIEKA - Manajemen User')

@section('content')
    <div class="container">
        <div class="card bg-white border-0 shadow-sm mb-4 p-3">
            <div class="row">
                <div class="col-md-10">
                    <h3 class="fw-bold mb-1">Manajemen User</h3>
                    <p class="text-muted mb-0">Kelola Semua Informasi User yang Terdaftar</p>
                </div>
                <div class="col-md-2 d-flex justify-content-end">
                    <a href="{{ route('admin.user.create') }}" class="btn btn-primary py-3 px-3 fw-bold">
                        TAMBAH USER
                    </a>
                </div>
            </div>
            @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm mt-3 mb-0">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm mt-3 mb-0">{{ session('error') }}</div>
                @endif
        </div>
        <div class="card shadow-sm border-0 p-3">
            <table class="table table-striped table-hover align-middle" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th class="text-start">Nim</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Password</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->nama }}</td>
                            <td class="text-start">{{ $user->nim }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->role === 'admin')
                                    <span class="badge bg-warning text-dark">ADMIN</span>
                                @elseif ($user->role === 'panitia')
                                    <span class="badge bg-success text-white">PANITIA</span>
                                @elseif ($user->role === 'user')
                                    <span class="badge bg-primary text-white">USER</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($user->password, 30) }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Opsi
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.user.edit', $user->idUser) }}"
                                                class="dropdown-item">Edit</a></li>
                                        <li>
                                            <form action="{{ route('admin.user.destroy', $user->idUser) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn dropdown-item text-danger"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">Hapus</button>
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
@endsection