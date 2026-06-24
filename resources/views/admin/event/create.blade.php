@extends('layouts.app')
@section('title')
    SIEKA - Tambah Event
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    Tambah Event
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="namaEvent">Nama Event</label>
                            <input type="text" class="form-control" id="namaEvent" name="namaEvent"
                                value="{{ old('namaEvent') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tempatEvent">Tempat Event</label>
                            <input type="text" class="form-control" id="tempatEvent" name="tempatEvent"
                                value="{{ old('tempatEvent') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="idUser">Penanggung Jawab</label>
                            <select name="idUser" id="idUser" class="form-select">
                                <option value="">Opsi</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->idUser }}">{{ $user->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" value="{{ old('deskripsi') }}" "></textarea>
                            </div>
                        </div>
                        <div class=" row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggalEvent">Tanggal Event</label>
                                <input type="date" class="form-control" id="tanggalEvent" name="tanggalEvent"
                                    value="{{ old('tanggalEvent') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="waktuEvent">Waktu Pelaksanaan</label>
                                <input type="text" class="form-control" id="waktuEvent" name="waktuEvent"
                                    value="{{ old('waktuEvent') }}" placeholder="hh:mm - hh:mm">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kuotaPeserta">Jumlah Peserta</label>
                                <input type="number" class="form-control" id="kuotaPeserta" name="kuotaPeserta"
                                    value="{{ old('kuotaPeserta') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="hargaTiket">Harga Tiket</label>
                                <input type="number" class="form-control" id="hargaTiket" name="hargaTiket"
                                    value="{{ old('hargaTiket') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="poster">Poster</label>
                                <input type="file" name="poster" id="poster" class="form-control" value="{{ old('poster') }}" accept="image/*" onchange="bacaGambar(this)">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="fileProposal">Proposal</label>
                                <input type="file" class="form-control" id="fileProposal" name="fileProposal"
                                    value="{{ old('fileProposal') }}" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status">Status</label>
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
                            <a href="{{ route('admin.event.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
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