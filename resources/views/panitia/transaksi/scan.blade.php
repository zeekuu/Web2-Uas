@extends('layouts.app')
@section('title', 'SIEKA - Pemindai Tiket')

@section('content')
<style>
    #reader video {
        transform: scaleX(-1);
        -webkit-transform: scaleX(-1);
    }
</style>
<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm text-center p-3 mb-4 bg-white">
                <h4 class="fw-bold mb-1">Pemindai QR Code Tiket</h4>
                <p class="text-muted small">Izinkan akses kamera perangkat untuk memulai proses check-in peserta.</p>
                
                <div id="reader" style="width: 100%; max-width: 450px; margin: 0 auto;" class="rounded border shadow-sm"></div>
                
                <div id="scanResult" class="mt-3 p-3 rounded fw-bold d-none"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Matikan scanner sementara agar tidak menembak ajax beruntung berulang-ulang
        html5QrcodeScanner.clear();
        
        let resultDiv = document.getElementById('scanResult');
        resultDiv.className = "mt-3 p-3 rounded fw-bold alert alert-info";
        resultDiv.innerText = "Sedang memvalidasi kode tiket...";
        resultDiv.classList.remove('d-none');

        // Kirim data string hasil baca kamera ke controller panitia menggunakan AJAX Fetch
        fetch("{{ route('panitia.scan.proses') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                qr_code: decodedText
            })
        })
        .then(response => response.json())
        .then(data => {
            resultDiv.className = "mt-3 p-3 rounded fw-bold alert";
            
            if(data.status === 'success') {
                resultDiv.classList.add('alert-success');
                resultDiv.innerText = "✅ " + data.message;
            } else if(data.status === 'warning') {
                resultDiv.classList.add('alert-warning');
                resultDiv.innerText = "⚠️ " + data.message;
            } else {
                resultDiv.classList.add('alert-danger');
                resultDiv.innerText = "❌ " + data.message;
            }

            // Nyalakan ulang kamera pemindai 3 detik kemudian untuk peserta berikutnya
            setTimeout(() => {
                location.reload();
            }, 3500);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kendala koneksi ke server.');
            location.reload();
        });
    }

    function onScanFailure(error) {
        // Abaikan kegagalan frame pembacaan kecil
    }

    // Jalankan inisialisasi modul kamera
    let html5QrcodeScanner = new Html5QrcodeScanner("reader", { 
        fps: 10, 
        qrbox: {width: 250, height: 250},
        rememberLastUsedCamera: true,
        videoConstraints: {
            facingMode: "user",
            transform: 'scaleX(-1)' // Gunakan kamera belakang jika tersedia
        }
    }, false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
@endsection