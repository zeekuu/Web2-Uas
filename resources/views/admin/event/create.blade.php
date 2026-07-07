@extends('layouts.app')
@section('title')
    SIEKA - Tambah Event
@endsection

@section('content')
    <div class="container">
        <div class="card border-0 shadow-sm bg-white p-3 mb-3 rounded-3">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.event.index') }}" class="btn btn-primary fw-bold px-3">
                    KEMBALI
                </a>
                <h3 class="fw-bold mb-0 text-dark fs-4">TAMBAH EVENT</h3>
            </div>
        </div>
        <div class="card bg-white border-0 shadow-sm p-3">
            <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="namaEvent" class="form-label fw-bold small text-muted">NAMA EVENT</label>
                        <input type="text" class="form-control @error('namaEvent') is-invalid @enderror" id="namaEvent"
                            name="namaEvent" value="{{ old('namaEvent') }}">
                        @error('namaEvent') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tempatEvent" class="form-label fw-bold small text-muted">TEMPAT EVENT</label>
                        <input type="text" class="form-control @error('tempatEvent') is-invalid @enderror" id="tempatEvent"
                            name="tempatEvent" value="{{ old('tempatEvent') }}">
                        @error('tempatEvent') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="idUser" class="form-label fw-bold small text-muted">PENANGGUNG JAWAB</label>
                        <select name="idUser" id="idUser" class="form-select @error('idUser') is-invalid @enderror">
                            <option value="">Opsi</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->idUser }}">{{ $user->nama }}</option>
                            @endforeach
                        </select>
                        @error('idUser') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label fw-bold small text-muted">DESKRIPSI</label>
                        <textarea name="deskripsi" id="deskripsi"
                            class="form-control @error('deskripsi') is-invalid @enderror"
                            rows="4">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class=" row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggalEvent" class="form-label fw-bold small text-muted">TANGGAL EVENT</label>
                        <input type="date" class="form-control @error('tanggalEvent') is-invalid @enderror"
                            id="tanggalEvent" name="tanggalEvent" value="{{ old('tanggalEvent') }}">
                        @error('tanggalEvent') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="waktuEvent" class="form-label fw-bold small text-muted">WAKTU PELAKSANAAN</label>
                        <input type="text" class="form-control @error('waktuEvent') is-invalid @enderror" id="waktuEvent"
                            name="waktuEvent" value="{{ old('waktuEvent') }}" placeholder="hh:mm - hh:mm">
                        @error('waktuEvent') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kuotaPeserta" class="form-label fw-bold small text-muted">JUMLAH PESERTA</label>
                        <input type="number" class="form-control @error('kuotaPeserta') is-invalid @enderror"
                            id="kuotaPeserta" name="kuotaPeserta" value="{{ old('kuotaPeserta') }}">
                        @error('kuotaPeserta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="hargaTiket" class="form-label fw-bold small text-muted">HARGA TIKET</label>
                        <input type="number" class="form-control @error('hargaTiket') is-invalid @enderror" id="hargaTiket"
                            name="hargaTiket" value="{{ old('hargaTiket') }}">
                        @error('hargaTiket') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="poster" class="form-label fw-bold small text-muted">POSTER</label>
                        <input type="file" name="poster" id="poster"
                            class="form-control @error('poster') is-invalid @enderror" value="{{ old('poster') }}"
                            accept="image/*" onchange="bacaGambar(this)">
                        @error('poster') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="fileProposal" class="form-label fw-bold small text-muted">PROPOSAL</label>
                        <input type="file" class="form-control @error('fileProposal') is-invalid @enderror"
                            id="fileProposal" name="fileProposal" value="{{ old('fileProposal') }}">
                        @error('fileProposal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label fw-bold small text-muted">STATUS</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Opsi</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 d-none" id="wadah-preview">
                        <p class="text-muted small mb-1">Pratinjau Gambar:</p>
                        <img id="gambar-preview" src="#" alt="Pratinjau" class="img-thumbnail" style="max-height: 250px;">
                    </div>
                </div>
                <div class="mt-2 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary fw-bold shadow-sm">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function bacaGambar(input) {
            const wadah = document.getElementById('wadah-preview');
            const preview = document.getElementById('gambar-preview');

            // Cek apakah ada file yang dipilih oleh pengguna
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                // Ketika file selesai dibaca oleh sistem browser
                reader.onload = function (e) {
                    preview.src = e.target.result; // Ubah src gambar menjadi data base64 lokal
                    wadah.classList.remove('d-none'); // Munculkan area preview
                }

                // Membaca file gambar lokal sebagai URL data
                reader.readAsDataURL(input.files[0]);
            } else {
                // Jika user membatalkan pilihan file, sembunyikan kembali preview
                wadah.classList.add('d-none');
                preview.src = '#';
            }
        }
    </script>
@endsection