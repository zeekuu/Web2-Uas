<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket SIEKA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px 0; }
        .ticket-card { max-width: 520px; margin: 0 auto; border: 2px dashed #0d6efd !important; border-radius: 12px; background-color: #ffffff; }
        .qrcode-box { background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; display: inline-block; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card ticket-card shadow-sm p-4 text-center">
            
            <div class="text-center mb-4">
                <h3 class="text-primary fw-bold mb-1">TIKET MASUK ACARA</h3>
                <h5 class="text-secondary fw-semibold">{{ $transaksi->Event->namaEvent }}</h5>
                <div class="w-100 border-top my-3"></div>
            </div>

            <div class="card-body p-0">
                <p class="text-dark">Halo <strong>{{ $transaksi->User->nama }}</strong>,</p>
                <p class="text-muted small">Pembayaran Anda telah berhasil dikonfirmasi. Berikut adalah detail tiket resmi Anda:</p>
                
                <div class="bg-light p-3 rounded-3 mb-4 border">
                    <h6 class="fw-bold text-dark mb-3">Detail Pelaksanaan:</h6>
                    <table class="table table-borderless table-sm mb-0 text-secondary" style="font-size: 14px;">
                        <tr>
                            <td style="width: 25%;"><strong>Lokasi</strong></td>
                            <td>: {{ $transaksi->Event->tempatEvent }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal</strong></td>
                            <td>: {{ $transaksi->Event->tanggalEvent }}</td>
                        </tr>
                        <tr>
                            <td><strong>Waktu</strong></td>
                            <td>: {{ $transaksi->Event->waktuEvent }} WIB</td>
                        </tr>
                    </table>
                </div>

                <div class="text-center mb-4">
                    <div class="qrcode-box">
                        @php
                            $qrPath = storage_path('app/public/qrcode/' . $transaksi->qr_code);
                        @endphp

                        @if(file_exists($qrPath))
                            <img src="{{ $message->embed($qrPath) }}" width="200" height="200" class="img-fluid rounded border shadow-sm" alt="QR Code Tiket">
                        @else
                            <div class="p-2 text-danger small font-monospace">
                                Gambar fisik QR Code tidak ditemukan di server.<br>
                                Gunakan Kode Tiket di atas untuk registrasi manual.
                            </div>
                        @endif
                    </div>
                </div>

                <p class="text-center text-muted border-top pt-3" style="font-size: 12px;">
                    *Tunjukkan kode QR atau email ini kepada panitia penjaga pintu masuk saat registrasi check-in di lokasi acara.
                </p>

                <div class="text-center mt-4">
                    <a href="{{ route('user.transaksi.index') }}" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm py-2">
                        Lihat Riwayat Tiket Saya
                    </a>
                </div>

            </div>
        </div>
    </div>
</body>
</html>