    @extends('layouts.app') {{-- Pastikan Anda memiliki layout master ini --}}

    @section('content')
        <!DOCTYPE html>
        <html lang="id">

        <head>
            <meta charset="UTF-8">
            <title>Pembayaran Pendaftaran Camp</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            {{-- Bootstrap & Icons (biasanya sudah ada di layouts.app) --}}
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
            <style>
                body {
                    background-color: #f0f2f5;
                    /* Warna latar belakang yang lebih lembut */
                }

                .payment-card {
                    border: none;
                    border-radius: 0.75rem;
                }

                .payment-details {
                    border: 2px dashed #0d6efd;
                    padding: 1.5rem;
                    border-radius: .5rem;
                    background-color: #e9f3ff;
                    /* Latar biru muda untuk detail */
                }

                .list-group-item {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 1rem 1.25rem;
                }

                .list-group-item strong {
                    color: #333;
                }

                .btn-copy {
                    transition: all 0.2s ease-in-out;
                }

                .btn-copy:active {
                    transform: scale(0.95);
                }
            </style>

        </head>

        <body>


            <div class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">

                        {{-- Menampilkan pesan sukses atau error --}}
                        @if (session('success'))
                            <div class="alert alert-success text-center shadow-sm"><i class="bi bi-check-circle-fill"></i>
                                {{ session('success') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger shadow-sm">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="card shadow-sm payment-card">
                            <div class="card-header bg-primary text-white text-center py-3">
                                <h4 class="mb-0"><i class="bi bi-credit-card-fill"></i> Selesaikan Pembayaran Anda</h4>
                            </div>
                            <div class="card-body p-4">
                                {{-- Detail Pendaftaran --}}
                                <div class="payment-details text-center mb-4">
                                    <h5 class="mb-3">Detail Pendaftaran</h5>
                                    <p class="mb-1"><strong>ID Transaksi:</strong></p>
                                    {{-- Diasumsikan $pendaftaran memiliki properti trx_id --}}
                                    <h3 class="fw-bold text-primary">{{ $pendaftaran->trx_id }}</h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6 text-start">
                                            <p class="mb-1"><strong>Program:</strong></p>
                                            {{-- Diasumsikan ada relasi ke program --}}
                                            <p class="lead">{{ $pendaftaran->program->nama }}</p>
                                        </div>
                                        <div class="col-6 text-end">
                                            <p class="mb-1"><strong>Kamar Dipilih:</strong></p>
                                            {{-- Diasumsikan ada relasi ke kamar --}}
                                            <p class="lead">{{ $pendaftaran->kamar->nomor_kamar }}</p>
                                        </div>
                                    </div>
                                    <div class="total-pembayaran">
                                        <strong>Total Pembayaran:</strong>
                                        @php
                                            // Debugging - bisa dihapus setelah fix
                                            $harga = $pendaftaran->programCamp->harga_satu_bulan;
                                            $durasi = $pendaftaran->durasi_paket;

                                            // Cara alternatif jika masih bermasalah
                                            $harga = match ($durasi) {
                                                'satu_minggu' => $pendaftaran->programCamp->harga_satu_minggu,
                                                'dua_minggu' => $pendaftaran->programCamp->harga_dua_minggu,
                                                'tiga_minggu' => $pendaftaran->programCamp->harga_tiga_minggu,
                                                'satu_bulan' => $pendaftaran->programCamp->harga_satu_bulan,
                                                'dua_bulan' => $pendaftaran->programCamp->harga_dua_bulan,
                                                'tiga_bulan' => $pendaftaran->programCamp->harga_tiga_bulan,
                                                'enam_bulan' => $pendaftaran->programCamp->harga_enam_bulan,
                                                'setahun' => $pendaftaran->programCamp->harga_setahun,
                                                'perhari' => $pendaftaran->programCamp->harga_perhari,
                                                default => $pendaftaran->programCamp->harga_perhari,
                                            };
                                        @endphp

                                        Rp {{ number_format($harga, 0, ',', '.') }}
                                    </div>
                                    </h2>
                                </div>
                                {{-- Instruksi Pembayaran --}}
                                <div class="instructions mb-4">
                                    <h5 class="text-center mb-3">Instruksi Pembayaran</h5>
                                    <p class="text-center">Silakan transfer ke rekening berikut:</p>

                                    @if ($pendaftaran->bank)
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div>
                                                    <i class="bi bi-bank"></i>
                                                    <strong>{{ $pendaftaran->bank->name }}:</strong>
                                                    {{ $pendaftaran->bank->number }} (a.n. {{ $pendaftaran->bank->owner }})
                                                </div>
                                                <button class="btn btn-sm btn-outline-secondary btn-copy"
                                                    onclick="copyToClipboard('{{ $pendaftaran->bank->number }}', this)"
                                                    title="Salin Nomor Rekening">
                                                    <i class="bi bi-clipboard"></i>
                                                </button>
                                            </li>
                                        </ul>
                                    @else
                                        <div class="text-center text-danger">
                                            <em>Informasi bank tidak tersedia.</em>
                                        </div>
                                    @endif
                                </div>


                                <hr>

                                {{-- Form Unggah Bukti --}}
                                <div class="upload-section mt-4">
                                    <h5 class="text-center mb-3">Unggah Bukti Pembayaran</h5>
                                    <p class="text-center text-muted small">Setelah transfer, unggah bukti Anda di sini
                                        (JPG, PNG, PDF. Maks 2MB).</p>

                                    <form action="{{ route('payment.upload') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        {{-- Hidden input: ID pendaftaran camp --}}
                                        <input type="hidden" name="id" value="{{ $pendaftaran->id }}">

                                        {{-- Hidden input: Tipe program --}}
                                        <input type="hidden" name="type" value="camp">

                                        {{-- Label dan input dalam satu baris --}}
                                        <label for="bukti_pembayaran" class="form-label mb-1">Upload Bukti
                                            Pembayaran</label>
                                        <div class="input-group">
                                            <input type="file"
                                                class="form-control @error('bukti_pembayaran') is-invalid @enderror"
                                                name="bukti_pembayaran" id="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf"
                                                required>
                                            <button class="btn btn-primary" type="submit">
                                                <i class="bi bi-upload"></i> Kirim Bukti
                                            </button>
                                        </div>
                                        @error('bukti_pembayaran')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </form>




                                    @if ($pendaftaran->bukti_pembayaran)
                                        <div class="text-center mt-3">
                                            <a href="{{ asset('storage/' . $pendaftaran->bukti_pembayaran) }}"
                                                class="btn btn-success btn-sm" target="_blank">
                                                <i class="bi bi-eye"></i> Lihat Bukti Pembayaran
                                            </a>
                                        </div>
                                    @endif


                                </div>

                                {{-- Tombol Aksi Tambahan --}}
                                <div class="mt-4 text-center">
                                    @php
                                        $harga = getHargaDurasi($pendaftaran);
                                        $waText =
                                            "Halo, saya ingin konfirmasi pembayaran untuk ID Transaksi: {$pendaftaran->trx_id} atas nama [NAMA ANDA] dengan total Rp " .
                                            number_format($harga, 0, ',', '.');
                                    @endphp



                                    <a href="https://wa.me/62NOMORADMIN?text={{ urlencode($waText) }}"
                                        class="btn btn-success mb-2" target="_blank">
                                        <i class="bi bi-whatsapp"></i> Konfirmasi via WhatsApp
                                    </a>
                                    <a href="{{ url('/') }}" class="btn btn-outline-secondary mb-2">
                                        <i class="bi bi-house-door-fill"></i> Kembali ke Beranda
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                function copyToClipboard(text, buttonElement) {
                    navigator.clipboard.writeText(text).then(function() {
                        // Sukses menyalin
                        const originalIcon = buttonElement.innerHTML;
                        buttonElement.innerHTML = '<i class="bi bi-check-lg"></i>';
                        buttonElement.classList.add('btn-success');
                        buttonElement.classList.remove('btn-outline-secondary');

                        setTimeout(() => {
                            buttonElement.innerHTML = originalIcon;
                            buttonElement.classList.remove('btn-success');
                            buttonElement.classList.add('btn-outline-secondary');
                        }, 1500); // Kembalikan ke ikon semula setelah 1.5 detik
                    }, function(err) {
                        // Gagal menyalin
                        alert('Gagal menyalin nomor rekening.');
                    });
                }
            </script>
        </body>

        </html>
    @endsection
