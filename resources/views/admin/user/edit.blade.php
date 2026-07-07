@extends('layouts.app')
@section('title')
    SIEKA - Edit User
@endsection

@section('content')
    <div class="container">
        <div class="card border-0 shadow-sm bg-white p-3 mb-3 rounded-3">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.user.index') }}" class="btn btn-primary fw-bold px-3">
                    KEMBALI
                </a>
                <h3 class="fw-bold mb-0 text-dark fs-4">EDIT USER <span class="text-primary">{{ $users->nama }}</span></h3>
            </div>
        </div>
        <div class="card bg-white border-0 shadow-sm mb-4 p-3">
            <form action="{{ route('admin.user.update', $users->idUser) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label fw-bold small text-muted">NAMA</label>
                        <input type="text" class="form-control @error('nama') is-invalid
                        @enderror" id="nama" name="nama" value="{{ $users->nama }}">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="nim" class="form-label fw-bold small text-muted">NIM</label>
                        <input type="text" class="form-control @error('nim') is-invalid
                        @enderror" id="nim" name="nim" value="{{ $users->nim }}">
                        @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="role" class="form-label fw-bold small text-muted">ROLE</label>
                        <select name="role" id="role" class="form-select @error('role') is-invalid
                        @enderror">
                            <option value="">Role</option>
                            <option value="user" {{ $users->role == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $users->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="panitia" {{ $users->role == 'panitia' ? 'selected' : '' }}>Panitia</option>
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label fw-bold small text-muted">EMAIL</label>
                        <input type="email" class="form-control @error('email') is-invalid
                        @enderror" id="email" name="email" value="{{ $users->email }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="password" class="form-label fw-bold small text-muted">PASSWORD</label>
                        <input type="password" class="form-control" id="password" name="password"
                            value="{{ old('password') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="password_confirmation" class="form-label fw-bold small text-muted">PASSWORD CONFIRM</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            value="{{ old('password_confirmation') }}">
                    </div>
                </div>
                <div class="mt-2 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary fw-bold shadow-sm">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
@endsection