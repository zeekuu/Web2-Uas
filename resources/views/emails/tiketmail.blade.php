<!DOCTYPE html>
<html>
<head>
    <title>E-Tiket SIEKA</title>
</head>
<body>
    <h2>Halo, {{ $transaksi->User->nama }}!</h2>
    <p>Pembayaran Anda untuk event <strong>{{ $transaksi->Event->namaEvent }}</strong> telah berhasil diverifikasi oleh panitia.</p>
    
    <h4>Detail Tiket:</h4>
    <ul>
        <li><strong>Kode Transaksi:</strong> TRX-{{ $transaksi->idTransaksi }}</li>
        <li><strong>Lokasi:</strong> {{ $transaksi->Event->tempatEvent }}</li>
        <li><strong>Tanggal:</strong> {{ $transaksi->Event->tanggalEvent }}</li>
    </ul>

    <p>Kami telah melampirkan **QR Code Masuk** pada email ini. Silakan tunjukkan QR Code tersebut kepada panitia di lokasi acara untuk proses *scan check-in*.</p>
    
    <p>Terima kasih,<br>Team SIEKA</p>
</body>
</html>