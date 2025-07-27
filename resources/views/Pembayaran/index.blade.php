<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Pendaftaran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .payment-details { border: 2px dashed #0d6efd; padding: 1.5rem; border-radius: .5rem; background-color: #f8f9fa; }
        .list-group-item { display: flex; justify-content: space-between; align-items: center; }
    </style>
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            @if(session('success'))
                <div class="alert alert-success text-center"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Selesaikan Pembayaran Anda</h4>
                </div>
                <div class="card-body p-4">
                    <div class="payment-details text-center mb-4">
                        <h5 class="mb-3">Detail Pendaftaran</h5>
                        <p class="mb-1"><strong>ID Transaksi:</strong></p>
                        <h3 class="fw-bold text-primary">{{ $pendaftaran->trx_id }}</h3>
                        <hr>
                        <p class="mb-1"><strong>Program:</strong></p>
                        <p class="lead">{{ $pendaftaran->program->nama }}</p>
                        <p class="mb-1"><strong>Total Pembayaran:</strong></p>
                        <h2 class="fw-bolder">Rp {{ number_format($pendaftaran->program->harga, 0, ',', '.') }}</h2>
                    </div>

                    <div class="instructions mb-4">
                        <h5 class="text-center mb-3">Instruksi Pembayaran</h5>
                        <p>Silakan transfer ke salah satu rekening berikut:</p>
                        <ul class="list-group">
                             @forelse($banks as $bank)
                                <li class="list-group-item">
                                    <div><i class="bi bi-bank"></i> <strong>{{ $bank->name }}:</strong> {{ $bank->number }} (a.n. {{ $bank->owner }})</div>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard('{{ $bank->number }}', this)"><i class="bi bi-clipboard"></i></button>
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted">Informasi rekening bank tidak tersedia.</li>
                            @endforelse
                        </ul>
                    </div>

                    <hr>
                    <div class="upload-section mt-4">
                        <h5 class="text-center mb-3">Unggah Bukti Pembayaran</h5>
                        <p class="text-center text-muted small">Setelah transfer, ungg  ah bukti Anda di sini (JPG, PNG, PDF. Maks 2MB).</p>

                        <form action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- Input tersembunyi untuk mengirim ID dan Tipe pendaftaran ke Controller --}}
                            <input type="hidden" name="id" value="{{ $pendaftaran->id }}">
                            <input type="hidden" name="type" value="{{ str_contains($pendaftaran->getTable(), 'online') ? 'online' : 'offline' }}">

                            <div class="input-group">
                                <input type="file" class="form-control" name="bukti_pembayaran" id="bukti_pembayaran" required>
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-upload"></i> Unggah
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="https://wa.me/6289675330202?text={{ urlencode('Halo, saya ingin konfirmasi pembayaran untuk ID Transaksi: ' . $pendaftaran->trx_id . ' dengan total Rp ' . number_format($pendaftaran->program->harga, 0, ',', '.')) }}" class="btn btn-success mb-2" target="_blank"><i class="bi bi-whatsapp"></i> Konfirmasi via WhatsApp</a>
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary mb-2"><i class="bi bi-house-door-fill"></i> Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function copyToClipboard(text, buttonElement) { /* ...Fungsi copy... */ }
</script>
</body>
</html>
