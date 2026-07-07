@extends('layouts.app')

@section('title')
    SIEKA - Tambah User
@endsection


@section('content')
    <div class="container">
        <div class="card border-0 shadow-sm bg-white p-3 mb-3 rounded-3">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.user.index') }}" class="btn btn-primary fw-bold px-3">
                    KEMBALI
                </a>
                <h3 class="fw-bold mb-0 text-dark fs-4">TAMBAH USER</h3>
            </div>
        </div>
        <div class="card border-0 shadow-sm bg-white p-3 mb-3 rounded-3">
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label fw-bold small text-muted">NAMA</label>
                        <input type="text" class="form-control @error('nama') is-invalid
                        @enderror" id="nama" name="nama" value="{{ old('nama') }}" >
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="nim" class="form-label fw-bold small text-muted">NIM</label>
                        <input type="text" class="form-control @error('nim') is-invalid
                        @enderror" id="nim" name="nim" value="{{ old('nim') }}">
                        @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-1 mb-3">
                        <label for="role" class="form-label fw-bold small text-muted">ROLE</label>
                        <select name="role" id="role" class="form-select @error('role') is-invalid
                        @enderror">
                            <option value="">Role</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="panitia">Panitia</option>
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label fw-bold small text-muted">EMAIL</label>
                        <input type="email" class="form-control @error('email') is-invalid
                        @enderror" id="email" name="email" value="{{ old('email') }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="password" class="form-label fw-bold small text-muted">PASSWORD</label>
                        <input type="password" class="form-control @error('password') is-invalid
                        @enderror" id="password" name="password"
                            value="{{ old('password') }}">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="password_confirmation" class="form-label fw-bold small text-muted">PASSWORD CONFIRM</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid
                        @enderror" id="password_confirmation" name="password_confirmation"
                            value="{{ old('password_confirmation') }}">
                        @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mt-2 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary fw-bold shadow-sm">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
@endsection