@extends('layouts.app')

@section('title', 'SIEKA - Manajemen Event')

@section('content')
    <div class="container">
        <div class="card bg-white border-0 shadow-sm mb-4 p-3">
            <div class="row">
                <div class="col-md-10">
                    <h3 class="fw-bold mb-1">Manajemen Event</h3>
                    <p class="text-muted mb-0">Kelola Semua Informasi Event yang Terdaftar</p>
                </div>
                <div class="col-md-2 d-flex justify-content-end">
                    <a href="{{ route('admin.event.create') }}" class="btn btn-primary py-3 px-3 fw-bold">
                        BUAT EVENT BARU
                    </a>
                </div>
            </div>
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mt-3 mb-0">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm mt-3 mb-0">{{ session('error') }}</div>
        @endif
        </div>
        <div class="card border-0 shadow-sm p-3">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Penanggung Jawab</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Proposal</th>
                            <th>Poster</th>
                            <th>Status</th>
                            <th>Kuota Peserta</th>
                            <th>Harga Tiket</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $index => $item)
                            @if ($item->status === 'rejected' || $item->status === 'cancelled')
                                <tr class="table-danger">
                            @endif
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->user->nama }}</td>
                                <td>{{ $item->namaEvent }}</td>
                                <td>{{ Str::limit($item->deskripsi, 100) }}</td>
                                <td> @if($item->fileProposal)
                                    <a href="{{ asset('storage/proposal/' . $item->fileProposal) }}"
                                        class="btn btn-sm btn-info">Lihat
                                        Proposal</a>
                                @endif
                                </td>
                                <td>
                                    @if($item->poster)
                                        <a href="{{ asset('storage/poster/' . $item->poster) }}" class="btn btn-sm btn-info">Lihat
                                            Poster</a>
                                    @endif
                                </td>
                                <td>
                                    <div class="badge bg text-dark fs-6">
                                        @if($item->status == 'pending')
                                            <small class="badge bg-secondary text-white">Pending</small>
                                        @elseif($item->status == 'approved')
                                            <small class="badge bg-success text-white">Approved</small>
                                        @elseif($item->status == 'rejected')
                                            <small class="badge bg-warning text-dark">Rejected</small>
                                        @elseif($item->status == 'cancelled')
                                            <small class="badge bg-danger text-white">Cancelled</small>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $item->kuotaPeserta }} Peserta</td>
                                <td>
                                    <small class="text-success fw-bold">
                                        @if($item->hargaTiket == 0)
                                            Gratis
                                        @else
                                            Rp. {{ number_format($item->hargaTiket, 0, ',', '.') }}
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Opsi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button class="dropdown-item btn-review-status" data-id="{{ $item->idEvent }}"
                                                    data-nama="{{ $item->namaEvent }}" data-status="{{ $item->status }}"
                                                    data-alasan="{{ $item->alasan }}" data-bs-toggle="modal"
                                                    data-bs-target="#modalApproval">
                                                    Konfirmasi Event
                                                </button>
                                            </li>
                                            <li><a href="{{ route('admin.event.edit', $item->idEvent) }}"
                                                    class="dropdown-item">Edit</a></li>
                                            <li>
                                                <form action="{{ route('admin.event.destroy', $item->idEvent) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn dropdown-item text-danger"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus event ini?')">Hapus</button>
                                                </form>
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

    <div class="modal fade" id="modalApproval" tabindex="-1" aria-labelledby="modalApprovalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formApproval" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalApprovalLabel">Konfirmasi Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>EVENT <strong id="modalNamaEvent">-</strong></p>

                        <div class="mb-3">
                            <label for="statusSelect" class="form-label">Pilih Status</label>
                            <select class="form-select" name="status" id="statusSelect" required>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="mb-3" id="wrapperAlasan" style="display: none;">
                            <label for="alasanInput" class="form-label">Alasan Penolakan</label>
                            <textarea class="form-control" name="alasan" id="alasanInput" rows="3"
                                placeholder="Masukkan alasan penolakan"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.btn-review-status');
            const form = document.getElementById('formApproval');
            const modalNamaEvent = document.getElementById('modalNamaEvent');
            const statusSelect = document.getElementById('statusSelect');
            const wrapperAlasan = document.getElementById('wrapperAlasan');
            const alasanInput = document.getElementById('alasanInput');

            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const nama = this.getAttribute('data-nama');
                    const status = this.getAttribute('data-status');
                    const alasan = this.getAttribute('data-alasan');

                    // Set action URL secara dinamis ke route update-status
                    form.action = `/admin/event/${id}/update-status`;

                    // Set data teks di modal
                    modalNamaEvent.textContent = nama;
                    statusSelect.value = status;
                    alasanInput.value = alasan || '';

                    // Trigger logic tampil/sembunyi alasan saat modal pertama kali dibuka
                    toggleAlasanInput(status);
                });
            });

            // Listen perubahan pada pilihan select status
            statusSelect.addEventListener('change', function () {
                toggleAlasanInput(this.value);
            });

            function toggleAlasanInput(status) {
                if (status === 'rejected') {
                    wrapperAlasan.style.display = 'block';
                    alasanInput.setAttribute('required', 'required');
                } else {
                    wrapperAlasan.style.display = 'none';
                    alasanInput.removeAttribute('required');
                }
            }
        });
    </script>
@endsection