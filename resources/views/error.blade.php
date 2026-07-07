@extends('layouts.app')
@section('title')
    ERROR
@endsection
@section('content')
    <div class="container text-center">
        @if (session('error'))
            <div class="alert alert-danger fs-1">
                {{ session('error') }}
            </div>
        @endif
    </div>
@endsection