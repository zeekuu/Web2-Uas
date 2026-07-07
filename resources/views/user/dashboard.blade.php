@extends('layouts.app')
@section('title', 'SIEKA - Dashboard User')

@section('content')
    <div class="container">
        <div class="mb-4">
            <div class="card p-3 bg-white border-0 shadow-sm">
                <h3 class="fw-bold">Selamat Datang, {{ Auth::user()->nama }}!</h3>
                <p class="fw-bold mb-0">Temukan dan ikuti berbagai event menarik yang tersedia.</p>
            </div>
        </div>

        <div class="row">
            @forelse($events as $event)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 overflow-hidden">
                        
                        <div style="height: 220px; overflow: hidden;" class="bg-light position-relative">
                            @if($event->poster)
                                <img src="{{ asset('storage/poster/' . $event->poster) }}" 
                                     class="card-img-top w-100 h-100 object-fit-cover" 
                                     alt="poster">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                    <span>🖼️ No Poster Available</span>
                                </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark">{{ $event->namaEvent }}</h5>
                            
                            <p class="card-text text-muted grow">
                                {{ Str::limit($event->deskripsi, 100) }}
                            </p>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-6 mb-1">
                                    <p><i class="fa-solid fa-calendar"></i> {{ \Carbon\Carbon::parse($event->tanggalEvent)->translatedFormat('l, d F Y') }}</p>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <p><i class="fa-solid fa-clock"></i> {{ $event->waktuEvent }}</p>
                                </div>
                            </div>
                            <div class="row align-items-center ">
                                <div class="col-md-6">
                                    <h6 class="fw-bold text-dark">Harga Tiket</h6>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-success fw-bold fs-3 text-end">
                                        @if($event->hargaTiket == 0)
                                            Gratis
                                        @else
                                            Rp. {{ number_format($event->hargaTiket, 0, ',', '.') }}
                                        @endif
                                    </h6>
                                </div>
                            </div>
                        </div>
                            
                            <div class="mt-auto pt-3 border-top">
                                <a href="{{ route('user.event.show', $event->idEvent) }}" class="btn btn-primary w-100">
                                    Lihat Event
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h4 class="text-muted">Tidak ada event yang tersedia.</h4>
                </div>
            @endforelse
        </div>
    </div>
@endsection