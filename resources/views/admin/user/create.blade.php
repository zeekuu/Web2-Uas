@extends('layouts.app')

@section('title')
    SIEKA - Tambah User
@endsection


@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah User</h4>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="card-body">
                <form action="{{ route('admin.user.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label for="nim">Nim</label>
                            <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim') }}">
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-select">
                                <option value="">Role</option>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="panitia">Panitia</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="password_confirmation">Password Confirm</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" required>
                        </div>
                    </div>
                    <div class="mt-2 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection