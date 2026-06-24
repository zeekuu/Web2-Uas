@extends('layouts.app')
@section('title')
 SIEKA - Tambah Transaksi
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h4>Tambah Transaksi</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.transaksi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection