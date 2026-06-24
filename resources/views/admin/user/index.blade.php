@extends('layouts.app')

@section('title')
    Data User
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex flex-row justify-content-between align-items-center">
                <h4 class="card-title">
                    Data User
                </h4>
                <div class="">
                    <a href="{{ route('admin.user.create') }}" class="btn btn-primary">Tambah User</a>
                </div>
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
                            <th>Nama</th>
                            <th>Nim</th>
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
                                <td>{{ $user->nim }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->password }}</td>
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
    </div>
@endsection