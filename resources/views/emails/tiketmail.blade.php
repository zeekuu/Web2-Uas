<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Tiket SIEKA</title>
    <style>
        body { font-family: 'Nunito', sans-serif; color: #333; line-height: 1.6; }
        .ticket-box { border: 2px dashed #435ebe; padding: 20px; border-radius: 8px; max-width: 500px; margin: 0 auto; background-color: #fafafa; }
        .qrcode-container { text-align: center; margin: 20px 0; background: #fff; padding: 15px; display: inline-block; border: 1px solid #ddd; }
        /* Mengontrol ukuran inline SVG agar tidak meluber di email */
        .qrcode-container svg { width: 200px; height: 200px; }
        .text-center { text-align: center; }
        .btn { display: inline-block; padding: 10px 20px; color: #fff; background-color: #435ebe; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="ticket-box">
        <h2 style="color: #435ebe; text-align: center; margin-top: 0;">🎟️ TIKET MASUK ACARA</h2>
        <p>Halo <strong>{{ $transaksi->User->nama }}</strong>,</p>
        <p>Pembayaran Anda untuk event <strong>{{ $transaksi->Event->namaEvent }}</strong> telah berhasil dikonfirmasi oleh panitia.</p>
        
        <hr style="border: 0; border-top: 1px solid #ddd;">
        
        <h4>📌 Detail Acara:</h4>
        <table style="width: 100%; font-size: 14px;">
            <tr><td><strong>Lokasi</strong></td><td>: {{ $transaksi->Event->tempatEvent }}</td></tr>
            <tr><td><strong>Tanggal</strong></td><td>: {{ $transaksi->Event->tanggalEvent }}</td></tr>
            <tr><td><strong>Waktu</strong></td><td>: {{ $transaksi->Event->waktuEvent }} WIB</td></tr>
        </table>

        <div class="text-center" style="text-align: center; margin: 20px 0;">
    <div class="qrcode-container" style="background: #fff; padding: 15px; display: inline-block; border: 1px solid #ddd;">
        @php
            // Mendapatkan path file fisik SVG di dalam folder storage server Anda
            $path = storage_path('app/public/qrcode/' . $transaksi->qr_code);
        @endphp
        
        @if(file_exists($path))
            @php
                // Membaca file SVG dan mengubahnya menjadi format Data URL Base64 yang aman untuk Gmail
                $svgContent = file_get_contents($path);
                $base64Svg = base64_encode($svgContent);
            @endphp
            <img src="data:image/svg+xml;base64,{{ $base64Svg }}" width="200" height="200" alt="QR Code Tiket Masuk">
        @else
            <p style="color: red; font-size: 12px; font-family: sans-serif;">
                Gagal memuat QR Code secara langsung.<br>
                Silakan unduh file lampiran <strong>QR_Code_Masuk.svg</strong> di bawah email ini.
            </p>
        @endif
    </div>
</div>

        <p style="font-size: 13px; text-align: center; color: #666; margin-bottom: 25px;">
            *Simpan email ini atau tunjukkan file lampiran <strong>QR_Code_Masuk.svg</strong> kepada panitia saat registrasi di lokasi.
        </p>

        <div class="text-center">
            <a href="{{ route('user.transaksi.index') }}" class="btn">Lihat Riwayat Tiket Saya</a>
        </div>
    </div>
</body>
</html>