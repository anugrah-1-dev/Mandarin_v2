<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pembayaran Pendaftaran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .payment-details {
            border: 2px dashed #0d6efd;
            padding: 1.5rem;
            border-radius: .5rem;
            background-color: #f8f9fa;
        }

        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">

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
                            <hr>
                            <p class="mb-1"><strong>Program:</strong></p>
                            <p class="lead">{{ $pendaftaran->program->nama }}</p>

                            {{-- Rincian Biaya --}}
                            @php
                                $programHarga      = $pendaftaran->program->harga ?? 0;
                                $biayaAdmin        = $pendaftaran->program->biaya_admin ?? 0;
                                $akomodasiHarga    = $pendaftaran->akomodasi_harga ?? 0;
                                $transport         = isset($pendaftaran->transport) ? $pendaftaran->transport : null;
                                $transportHarga    = $transport ? $transport->price : 0;
                                $hasTransportBank  = $transport && $transport->bank_number;

                                // Total yg harus ditransfer ke rekening program (tanpa transport jika transport punya rekening sendiri)
                                $totalProgram = $hasTransportBank
                                    ? ($pendaftaran->subtotal - $transportHarga)
                                    : $pendaftaran->subtotal;
                            @endphp

                            {{-- Jika transport punya rekening terpisah: tampilkan 2 kotak transfer --}}
                            @if ($hasTransportBank)
                                <div class="alert alert-warning text-start py-2 px-3 mb-3">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    <strong>Perhatian:</strong> Program ini menggunakan transportasi dengan rekening terpisah.
                                    Silakan lakukan <strong>2 kali transfer</strong> ke rekening yang berbeda.
                                </div>

                                {{-- Transfer 1: Program --}}
                                <div class="border rounded p-3 mb-3 text-start">
                                    <p class="fw-bold mb-2 text-primary"><i class="bi bi-1-circle-fill"></i> Transfer ke Rekening Program</p>
                                    <table class="table table-sm table-borderless mb-1">
                                        <tbody>
                                            <tr>
                                                <td>Harga Program</td>
                                                <td class="text-end">Rp {{ number_format($programHarga, 0, ',', '.') }}</td>
                                            </tr>
                                            @if ($biayaAdmin > 0)
                                            <tr>
                                                <td>Biaya Admin</td>
                                                <td class="text-end">Rp {{ number_format($biayaAdmin, 0, ',', '.') }}</td>
                                            </tr>
                                            @endif
                                            @if ($akomodasiHarga > 0)
                                            <tr>
                                                <td>Akomodasi ({{ $pendaftaran->akomodasi_tipe }})</td>
                                                <td class="text-end">Rp {{ number_format($akomodasiHarga, 0, ',', '.') }}</td>
                                            </tr>
                                            @endif
                                            <tr class="fw-bold border-top">
                                                <td>Subtotal Transfer 1</td>
                                                <td class="text-end text-primary">Rp {{ number_format($totalProgram, 0, ',', '.') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Transfer 2: Transport --}}
                                <div class="border rounded p-3 mb-3 text-start border-warning">
                                    <p class="fw-bold mb-2 text-warning"><i class="bi bi-2-circle-fill"></i> Transfer ke Rekening Transportasi</p>
                                    <table class="table table-sm table-borderless mb-1">
                                        <tbody>
                                            <tr>
                                                <td>{{ $transport->name }}</td>
                                                <td class="text-end">Rp {{ number_format($transportHarga, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr class="fw-bold border-top">
                                                <td>Subtotal Transfer 2</td>
                                                <td class="text-end text-warning">Rp {{ number_format($transportHarga, 0, ',', '.') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="border-top pt-2 mb-2">
                                    <p class="mb-0 fw-bold">Grand Total: <span class="fs-5">Rp {{ number_format($pendaftaran->subtotal, 0, ',', '.') }}</span></p>
                                </div>

                            {{-- Jika tidak ada transport terpisah: tampilkan breakdown biasa --}}
                            @else
                                <table class="table table-sm table-borderless text-start mt-2 mb-1">
                                    <tbody>
                                        <tr>
                                            <td>Harga Program</td>
                                            <td class="text-end">Rp {{ number_format($programHarga, 0, ',', '.') }}</td>
                                        </tr>
                                        @if ($biayaAdmin > 0)
                                        <tr>
                                            <td>Biaya Admin</td>
                                            <td class="text-end">Rp {{ number_format($biayaAdmin, 0, ',', '.') }}</td>
                                        </tr>
                                        @endif
                                        @if ($transportHarga > 0)
                                        <tr>
                                            <td>Transportasi ({{ $transport->name }})</td>
                                            <td class="text-end">Rp {{ number_format($transportHarga, 0, ',', '.') }}</td>
                                        </tr>
                                        @endif
                                        @if ($akomodasiHarga > 0)
                                        <tr>
                                            <td>Akomodasi ({{ $pendaftaran->akomodasi_tipe }})</td>
                                            <td class="text-end">Rp {{ number_format($akomodasiHarga, 0, ',', '.') }}</td>
                                        </tr>
                                        @endif
                                        <tr class="fw-bold border-top">
                                            <td>Total Pembayaran</td>
                                            <td class="text-end">Rp {{ number_format($pendaftaran->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <h2 class="fw-bolder">Rp {{ number_format($pendaftaran->subtotal, 0, ',', '.') }}</h2>
                            @endif


                            <div class="instructions mb-4">
                                <h5 class="text-center mb-3">Instruksi Pembayaran</h5>
                                <p>Silakan transfer ke rekening berikut:</p>
                                <ul class="list-group">
                                    @if ($pendaftaran->bank)
                                        <li class="list-group-item">
                                            <div>
                                                <i class="bi bi-bank"></i>
                                                <strong>{{ $pendaftaran->bank->name }}:</strong>
                                                <span id="bank-number">{{ $pendaftaran->bank->number }}</span> (a.n.
                                                {{ $pendaftaran->bank->owner }})
                                            </div>
                                            <button class="btn btn-sm btn-outline-secondary"
                                                onclick="copyToClipboard('{{ $pendaftaran->bank->number }}', this)">
                                                <i class="bi bi-clipboard"></i>
                                                <span class="copy-text">Salin</span>
                                            </button>
                                        </li>
                                    @else
                                        <li class="list-group-item text-center text-muted">Informasi bank belum dipilih.
                                        </li>
                                    @endif
                                </ul>

                                {{-- Rekening transportasi (khusus pendaftaran offline yang punya transport) --}}
                                @if (isset($pendaftaran->transport) && $pendaftaran->transport && $pendaftaran->transport->bank_number)
                                    <p class="mt-3">Transfer biaya transportasi ke rekening terpisah:</p>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div>
                                                <i class="bi bi-bus-front-fill"></i>
                                                <strong>{{ $pendaftaran->transport->bank_name }}:</strong>
                                                <span id="transport-bank-number">{{ $pendaftaran->transport->bank_number }}</span>
                                                (a.n. {{ $pendaftaran->transport->bank_owner }})
                                                &mdash; <span class="text-muted small">Biaya Transport: Rp {{ number_format($pendaftaran->transport->price, 0, ',', '.') }}</span>
                                            </div>
                                            <button class="btn btn-sm btn-outline-secondary"
                                                onclick="copyToClipboard('{{ $pendaftaran->transport->bank_number }}', this)">
                                                <i class="bi bi-clipboard"></i>
                                                <span class="copy-text">Salin</span>
                                            </button>
                                        </li>
                                    </ul>
                                @endif
                            </div>

                            <hr>
                            <div class="upload-section mt-4">
                                <h5 class="text-center mb-3">Unggah Bukti Pembayaran</h5>
                                <p class="text-center text-muted small">Setelah transfer, unggah bukti Anda di sini
                                    (JPG,
                                    PNG, PDF. Maks 2MB).</p>

                                {{-- Menentukan tipe pendaftaran secara dinamis berdasarkan model --}}
                                @php
                                    $registrationType = '';
                                    if ($pendaftaran instanceof \App\Models\PendaftaranProgramOnline) {
                                        $registrationType = 'online';
                                    } elseif ($pendaftaran instanceof \App\Models\PendaftaranProgramOffline) {
                                        $registrationType = 'offline';
                                    } elseif ($pendaftaran instanceof \App\Models\PendaftaranProgramCamp) {
                                        $registrationType = 'camp';
                                    }
                                @endphp

                                <form action="{{ route('payment.upload') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $pendaftaran->id }}">
                                    {{-- PERBAIKAN: Nilai 'type' sekarang dinamis sesuai dengan tipe pendaftaran --}}
                                    <input type="hidden" name="type" value="{{ $registrationType }}">

                                    <div class="input-group">
                                        <input type="file" class="form-control" name="bukti_pembayaran"
                                            id="bukti_pembayaran" required>
                                        <button class="btn btn-primary" type="submit">
                                            <i class="bi bi-upload"></i> Kirim Bukti
                                        </button>
                                    </div>
                                </form>

                                {{-- Upload bukti transfer transportasi (hanya tampil jika ada transport dengan rekening terpisah) --}}
                                @if (isset($pendaftaran->transport) && $pendaftaran->transport && $pendaftaran->transport->bank_number)
                                    <div class="mt-3">
                                        <h6 class="text-center mb-2"><i class="bi bi-bus-front-fill"></i> Bukti Transfer Transportasi</h6>
                                        <p class="text-center text-muted small">Upload bukti transfer biaya transportasi ke rekening {{ $pendaftaran->transport->bank_name }}.</p>
                                        <form action="{{ route('payment.upload.transport') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $pendaftaran->id }}">
                                            <div class="input-group">
                                                <input type="file" class="form-control" name="bukti_pembayaran_transport"
                                                    id="bukti_pembayaran_transport" required>
                                                <button class="btn btn-warning" type="submit">
                                                    <i class="bi bi-upload"></i> Kirim Bukti Transport
                                                </button>
                                            </div>
                                        </form>
                                        @if ($pendaftaran->bukti_pembayaran_transport)
                                            <p class="text-success text-center mt-2 small"><i class="bi bi-check-circle-fill"></i> Bukti transport sudah diunggah.</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="mt-4 text-center">
                                @php
                                    $rawNumber = $contactServices->isNotEmpty()
                                        ? $contactServices->first()->nomor
                                        : '6281234567890';
                                    $waNumber = preg_replace('/[^0-9]/', '', $rawNumber);
                                    if (substr($waNumber, 0, 1) === '0') {
                                        $waNumber = '62' . substr($waNumber, 1);
                                    }
                                @endphp
                                <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo, saya ingin konfirmasi pembayaran untuk ID Transaksi: ' . $pendaftaran->trx_id . ' dengan total Rp ' . number_format($pendaftaran->subtotal, 0, ',', '.')) }}"
                                    class="btn btn-success mb-2" target="_blank"><i class="bi bi-whatsapp"></i>
                                    Konfirmasi via WhatsApp</a>
                                <a href="{{ url('/') }}" class="btn btn-outline-secondary mb-2"><i
                                        class="bi bi-house-door-fill"></i> Kembali ke Beranda</a>
                                <button onclick="confirmCetak('{{ route('invoice.cetak', ['trx_id' => $pendaftaran->trx_id]) }}')" class="btn btn-primary mb-2"><i class="bi bi-printer-fill"></i> Cetak Invoice</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script untuk copy di halaman utama -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function copyToClipboard(text, buttonElement) {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                try {
                    document.execCommand('copy');
                    const copyTextSpan = buttonElement.querySelector('.copy-text');
                    const originalText = copyTextSpan ? copyTextSpan.innerHTML : 'Salin';
                    const icon = buttonElement.querySelector('i');

                    if (copyTextSpan) {
                        copyTextSpan.innerHTML = 'Tersalin!';
                    }
                    icon.classList.remove('bi-clipboard');
                    icon.classList.add('bi-check-lg');
                    buttonElement.classList.remove('btn-outline-secondary');
                    buttonElement.classList.add('btn-success');

                    setTimeout(() => {
                        if (copyTextSpan) {
                            copyTextSpan.innerHTML = originalText;
                        }
                        icon.classList.remove('bi-check-lg');
                        icon.classList.add('bi-clipboard');
                        buttonElement.classList.remove('btn-success');
                        buttonElement.classList.add('btn-outline-secondary');
                    }, 2000);

                } catch (err) {
                    console.error('Gagal menyalin teks: ', err);
                }
                document.body.removeChild(textArea);
            }
        </script>

        <!-- SweetAlert untuk pesan sukses/error -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- SCRIPT BARU UNTUK MENAMPILKAN POP-UP SUKSES DENGAN TOMBOL SALIN --}}
        @if (session('success_message') && session('trx_id'))
            <script>
                // Fungsi ini khusus untuk tombol salin di dalam SweetAlert
                function copySwalId(text, buttonElement) {
                    const textArea = document.createElement('textarea');
                    textArea.value = text;
                    document.body.appendChild(textArea);
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        const copyTextSpan = buttonElement.querySelector('span');
                        const icon = buttonElement.querySelector('i');

                        if (copyTextSpan) copyTextSpan.textContent = 'Tersalin!';
                        icon.classList.remove('bi-clipboard');
                        icon.classList.add('bi-check-lg');
                        buttonElement.disabled = true; // Nonaktifkan tombol setelah disalin
                    } catch (err) {
                        console.error('Gagal menyalin teks: ', err);
                    }
                    document.body.removeChild(textArea);
                }

                const trxId = "{{ session('trx_id') }}";
                const successMessage = "{{ session('success_message') }}";

                // Membuat konten HTML untuk SweetAlert
                const alertHtml = `
                    <div class="text-start">
                        <p>${successMessage}</p>
                        <div class="mt-3">
                            <strong>ID Transaksi Anda:</strong>
                            <div class="input-group mt-1">
                                <input type="text" class="form-control bg-light" value="${trxId}" readonly>
                                <button class="btn btn-outline-secondary" onclick="copySwalId('${trxId}', this)">
                                    <i class="bi bi-clipboard"></i>
                                    <span class="copy-text"> Salin</span>
                                </button>
                            </div>
                            <small class="form-text text-muted">Silakan simpan ID ini untuk referensi Anda.</small>
                        </div>
                    </div>
                `;

                // Menampilkan SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    html: alertHtml,
                    showConfirmButton: true,
                    confirmButtonText: 'Tutup'
                });
            </script>
            <script>
                function confirmCetak(url) {
                    Swal.fire({
                        title: 'Cetak Invoice?',
                        text: "Apakah Anda yakin ingin mencetak invoice ini?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#0d6efd',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Cetak!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.open(url, '_blank');
                        }
                    })
                }
            </script>
        @endif

        {{-- Menjaga blok error tetap berfungsi --}}
        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: `{!! nl2br(e(session('error'))) !!}`,
                    showConfirmButton: true,
                    confirmButtonText: 'Tutup'
                });
            </script>
        @endif

</body>

</html>
