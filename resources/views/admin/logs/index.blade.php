@extends('layouts.app')

@section('title', 'SIEKA - Log Aktivitas')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <div class="card p-3 bg-white border-0 shadow-sm">
                    <h3 class="fw-bold mb-1">Log Aktivitas Sistem</h3>
                    <p class="text-muted mb-0">Pantau perubahan data yang terjadi di sistem</p>
                </div>
            </div>
        </div>
        <div class="card bg-white border-0 shadow-sm mb-4 p-3">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle" id="table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Tanggal</th>
                            <th>User</th>
                            <th>Aksi</th>
                            <th>Tabel</th>
                            <th>Detail Perubahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $index =>$log)
                                @php
                                    // 1. Ambil data asli
                                    $rawChanges = $log->getRawOriginal('attribute_changes');

                                    // 2. Ubah JSON menjadi Array Asosiatif
                                    $changes = json_decode($rawChanges, true);

                                    // 3. Fallback keamanan ekstrim
                                    if (!is_array($changes)) {
                                        $changes = [];
                                    }

                                    // --- TAMBAHAN BARU: Fungsi untuk memformat tanggal ---
                                    $formatDates = function ($dataArray) {
                                        if (!is_array($dataArray))
                                            return $dataArray;

                                        // Daftar key yang berisi tanggal (tambahkan jika ada field lain)
                                        $dateKeys = ['created_at', 'updated_at', 'deleted_at', 'waktuHadir'];

                                        foreach ($dataArray as $key => $value) {
                                            // Jika nama key-nya ada di daftar dateKeys dan valuenya berupa string/teks
                                            if (in_array($key, $dateKeys) && !empty($value)) {
                                                try {
                                                    // Ubah formatnya menjadi: 05 Jul 2026 07:20:17
                                                    $dataArray[$key] = \Carbon\Carbon::parse($value)->format('d-M-Y H:i:s');
                                                } catch (\Exception $e) {
                                                    // Jika gagal diparse, biarkan format aslinya
                                                }
                                            }
                                        }
                                        return $dataArray;
                                    };
                                    // ----------------------------------------------------

                                    // 4. Cek ketersediaan data dan terapkan format tanggal
                                    $hasOld = isset($changes['old']);
                                    if ($hasOld) {
                                        $changes['old'] = $formatDates($changes['old']);
                                    }

                                    $hasNew = isset($changes['attributes']);
                                    if ($hasNew) {
                                        $changes['attributes'] = $formatDates($changes['attributes']);
                                    }

                                    $hasDetails = $hasOld || $hasNew;
                                @endphp

                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>
                                        <span class="fw-medium">{{ $log->created_at->format('d M Y') }}</span><br>
                                        <small class="text-muted">{{ $log->created_at->format('H:i:s') }} WIB</small>
                                    </td>
                                    <td>
                                        @if ($log->causer)
                                            <span class="fw-bold">{{ $log->causer->nama }}</span><br>
                                            <small class="text-muted">
                                                @if ($log->causer->role === 'admin')
                                                    <span class="badge bg-warning text-dark">ADMIN</span>
                                                @elseif ($log->causer->role === 'panitia')
                                                    <span class="badge bg-success">PANITIA</span>
                                                @elseif ($log->causer->role === 'user')
                                                    <span class="badge bg-info text-white">USER</span>
                                                @endif
                                            </small>
                                        @else
                                            <span class="badge bg-secondary">System / Guest</span>
                                        @endif
                                    </td>
                                    <td>
                                        
                                        @if ( $log->description === 'created')
                                            <span class="badge bg-success text-uppercase">Created</span>
                                        @elseif ( $log->description === 'updated')
                                            <span class="badge bg-warning text-dark text-uppercase">Updated</span>
                                        @elseif ( $log->description === 'deleted')
                                            <span class="badge bg-danger text-uppercase">Deleted</span>
                                        @else
                                            <span class="badge bg-secondary"> {{ $log->description }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-dark text-uppercase">{{ $log->subject_type ? class_basename($log->subject_type) : 'General' }}</span>
                                    </td>
                                    <td>
                                        @if($hasDetails)
                                            <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="modal"
                                                data-bs-target="#modal-log-{{ $log->id }}">
                                                <i class="fa-solid fa-eye"></i> Cek Detail
                                            </button>

                                            <div class="modal fade text-start" id="modal-log-{{ $log->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title fw-bold">Detail Perubahan Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body bg-light">
                                                            <div class="row">
                                                                @if($hasOld)
                                                                    <div class="col-md-6 mb-3 mb-md-0">
                                                                        <h6 class="text-danger fw-bold"><i
                                                                                class="fa-solid fa-minus-circle"></i> Data Lama:</h6>
                                                                        <pre class="mb-0 bg-white p-3 border rounded shadow-sm"
                                                                            style="font-size: 0.85rem; overflow-x: auto;"><code>{{ json_encode($changes['old'], JSON_PRETTY_PRINT) }}</code></pre>
                                                                    </div>
                                                                @endif
                                                                @if($hasNew)
                                                                    <div class="col-md-6">
                                                                        <h6 class="text-success fw-bold"><i
                                                                                class="fa-solid fa-plus-circle"></i> Data Baru:</h6>
                                                                        <pre class="mb-0 bg-white p-3 border rounded shadow-sm"
                                                                            style="font-size: 0.85rem; overflow-x: auto;"><code>{{ json_encode($changes['attributes'], JSON_PRETTY_PRINT) }}</code></pre>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted fst-italic">Tidak ada detail</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection