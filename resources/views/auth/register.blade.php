@extends('layouts.app')
@section('title')
    SIEKA - Register
@endsection
@section('content')
    <div class="container min-vh-90">
        <div class="row justify-content-center align-items-center h-100 pt-5">
            <div class="col-md-5">
                <div class="card border-0 shadow-sm">
                        
                        <div class="card bg-white border-0 p-4">
                            <span class="fw-bold fs-2 text-center">REGISTER</span>
                            <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="nama" class="form-label fw-semibold text-secondary small">{{ __('Nama Lengkap') }}</label>
                                <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" 
                                    name="nama" value="{{ old('nama') }}" required autocomplete="nama" autofocus>

                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nim" class="form-label fw-semibold text-secondary small">{{ __('NIM') }}</label>
                                <input id="nim" type="text" class="form-control @error('nim') is-invalid @enderror" 
                                    name="nim" value="{{ old('nim') }}" autocomplete="nim">

                                @error('nim')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold text-secondary small">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold text-secondary small">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                    name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm" class="form-label fw-semibold text-secondary small">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" 
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary fw-bold">
                                    {{ __('Register') }}
                                </button>
                            </div>

                            <div class="text-start mt-1">
                                <span class="small text-muted">Sudah punya akun? </span>
                                <a href="{{ route('login') }}" class="text-decoration-none small fw-semibold">Login di sini</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
