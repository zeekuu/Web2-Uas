@extends('layouts.app')

@section('title')
    SIEKA - Data Transaksi
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    Data Transaksi
                </h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Peserta</th>
                            <th>Nama Event</th>
                            <th>Bukti Transfer</th>
                            <th>Status Pembayaran</th>
                            <th>QR Code</th>
                            <th>Kehadiran</th>
                            <th>Waktu Kehadiran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksis as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->user->nama }}</td>
                                <td>{{ $item->event->namaEvent }}</td>
                                <td>{{ $item->buktiTransafer }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->qr_code }}</td>
                                <td>{{ $item->kehadiran }}</td>
                                <td>{{ $item->waktuHadir }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Opsi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                            </li>
                                            <li>
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