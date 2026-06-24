@extends('layouts.app')
@section('title')
    ERROR
@endsection
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="card-body">
                    <h1> @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection