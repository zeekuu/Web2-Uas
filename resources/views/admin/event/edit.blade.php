@extends('layouts.app')
@section('title')
    SIEKA - Edit Event
@endsection

@section('content')
    <div class="container">
        <div class="card border-0 shadow-sm bg-white p-3 mb-3 rounded-3">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.event.index') }}" class="btn btn-primary fw-bold px-3">
                    KEMBALI
                </a>
                <h3 class="fw-bold mb-0 text-dark fs-4">EDIT EVENT <span class="text-primary">{{ $events->namaEvent }}</span></h3>
            </div>
        </div>

        <div class="card bg-white border-0 shadow-sm p-3">
            <form action="{{ route('admin.event.update', $events->idEvent)  }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="namaEvent" class="form-label fw-bold small text-muted">NAMA EVENT</label>
                        <input type="text" class="form-control" id="namaEvent" name="namaEvent"
                            value="{{ $events->namaEvent }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tempatEvent" class="form-label fw-bold small text-muted">TEMPAT EVENT</label>
                        <input type="text" class="form-control" id="tempatEvent" name="tempatEvent"
                            value="{{ $events->tempatEvent }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="idUser" class="form-label fw-bold small text-muted">PENANGGUNG JAWAB</label>
                        <select name="idUser" id="idUser" class="form-select">
                            <option value="">Opsi</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->idUser }}" {{ $user->idUser == $events->idUser ? 'selected' : '' }}>
                                    {{ $user->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label fw-bold small text-muted">DESKRIPSI</label>
                        <textarea name="deskripsi" id="deskripsi"
                            class="form-control">{{ old('deskripsi', $events->deskripsi) }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggalEvent" class="form-label fw-bold small text-muted">TANGGAL EVENT</label>
                        <input type="date" class="form-control" id="tanggalEvent" name="tanggalEvent"
                            value="{{ $events->tanggalEvent }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="waktuEvent" class="form-label fw-bold small text-muted">WAKTU PELAKSANAAN</label>
                        <input type="text" class="form-control" id="waktuEvent" name="waktuEvent"
                            value="{{ $events->waktuEvent }}" placeholder="hh:mm - hh:mm">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kuotaPeserta" class="form-label fw-bold small text-muted">JUMLAH PESERTA</label>
                        <input type="number" class="form-control" id="kuotaPeserta" name="kuotaPeserta"
                            value="{{ $events->kuotaPeserta }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="hargaTiket" class="form-label fw-bold small text-muted">HARGA TIKET</label>
                        <input type="number" class="form-control" id="hargaTiket" name="hargaTiket"
                            value="{{$events->hargaTiket}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="fileProposal" class="form-label fw-bold small text-muted">PROPOSAL</label>
                        <input type="file" class="form-control" id="fileProposal" name="fileProposal"
                            value="{{ $events->fileProposal }}">
                        @if($events->fileProposal)
                            File saat ini: <a href="{{ asset('storage/proposal/' . $events->fileProposal) }}">Lihat
                                Proposal</a>
                        @endif
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="poster" class="form-label fw-bold small text-muted">POSTER</label>
                        <input type="file" class="form-control" id="poster" name="poster" value="{{ $events->poster }}">
                        @if($events->poster)
                            File saat ini: <a href="{{ asset('storage/poster/' . $events->poster) }}">Lihat Poster</a>
                        @endif
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="status" class="form-label fw-bold small text-muted">STATUS</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Opsi</option>
                            <option value="pending" {{ $events->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $events->status == 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="rejected" {{ $events->status == 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                            <option value="cancelled" {{ $events->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row" id="wrapperAlasan" style="display: none;">
                    <div class="col-md-12 mb-3">
                        <label for="alasanInput" class="form-label text-danger fw-bold">ALASAN PENOLAKAN</label>
                        <textarea class="form-control" name="alasan" id="alasanInput" rows="3"
                            placeholder="Masukkan alasan penolakan">{{ old('alasan', $events->alasan) }}</textarea>
                    </div>
                </div>
                <div class="mt-2 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary fw-bold shadow-sm">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status');
            const wrapperAlasan = document.getElementById('wrapperAlasan');
            const alasanInput = document.getElementById('alasanInput');

            // Cek status saat halaman pertama kali dimuat
            toggleAlasanInput(statusSelect.value);

            // Dengarkan perubahan pada select status
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