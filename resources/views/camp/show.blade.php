    @extends('layouts.app')

    @section('title', $program->nama)

    @section('content')
        <link rel="stylesheet" href="{{ asset('css/camp.css') }}">
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

                if (copyTextSpan) copyTextSpan.textContent = ' Tersalin!';
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
@endif



        <div class="container my-4 my-lg-5 px-3 px-lg-4">
            <!-- Header Section -->
            <div class="text-center mb-4 mb-lg-5">
                <h1 class="display-4 fw-bold text-dark mb-3">{{ $program->nama }}</h1>
                <p class="lead text-muted mb-3">Choose your program duration and fill out the registration form</p>
                <div class="mx-auto border-bottom border-3 border-primary" style="width: 80px;"></div>
            </div>

            <!-- Image and Description Section -->
            <div class="row g-3 g-lg-4 mb-4 mb-lg-5">
                <div class="col-12 col-lg-6">
                    <div class="rounded-3 overflow-hidden shadow-sm h-100">
                        <img src="{{ asset('upload/camp/' . ($program->thumbnail ?? 'placeholder.jpg')) }}"
                            class="img-fluid w-100 card-img-top" alt="{{ $program->nama }}" style="object-fit: cover;"
                            loading="lazy">
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-3 p-lg-4">
                            <h3 class="fw-bold text-primary mb-3">Program Facilities</h3>
                            <div class="list-unstyled mb-4">
                                @foreach ($facilities as $fasilitas)
                                    <div class="facility-item d-flex align-items-start">
                                        <i class="fas fa-check-circle text-success mt-1 me-2"></i>
                                        <span>{{ $fasilitas }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-auto pt-3 border-top">
                                <p class="mb-0">
                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                    <strong>Location:</strong> Brilliant English Course, Pare, Kediri
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Registration Form Section -->
            <div class="card border-0 shadow-sm mb-4 mb-lg-5">
                <div class="card-header bg-primary text-white py-3">
                    <h3 class="fw-bold mb-0 text-center">Camp Registration Form</h3>
                </div>
                <div class="card-body p-3 p-lg-4">

                    <form action="{{ route('camp.pendaftaran.store', $program->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="program_id" value="{{ $program->id }}">

                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-6">
                                <label for="nama_lengkap" class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="nama_lengkap" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="no_hp" class="form-label fw-semibold">Phone Number</label>
                                <input type="text" name="no_hp" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="asal_kota" class="form-label fw-semibold">City of Origin</label>
                                <input type="text" id="asal_kota" name="asal_kota" class="form-control form-control-lg"
                                    required>



                            </div>

                            <div class="col-12 col-md-6">
                                <label for="gender" class="form-label fw-semibold">Gender</label>
                                <select name="gender" id="gender" class="form-select form-select-lg" required>
                                    <option value="">-- Select Gender --</option>
                                    <option value="putra">Putra</option>
                                    <option value="putri">Putri</option>
                                </select>
                            </div>

                            @php
                                $today = \Carbon\Carbon::now('Asia/Jakarta')->toDateString(); // format: '2025-07-27'
                            @endphp


                            <div class="col-12 col-md-6">
                                <label for="period_id" class="form-label fw-semibold">Select Period</label>
                                <select name="period_id" class="form-select form-select-lg" required>
                                    <option value="">-- Select Period --</option>
                                    @foreach ($periods as $period)
                                        @php
                                            $periodDate = \Carbon\Carbon::parse($period->date)->toDateString();
                                        @endphp
                                        <option value="{{ $period->id }}" {{ $periodDate == $today ? 'selected' : '' }}>
                                            Periode: {{ \Carbon\Carbon::parse($period->date)->translatedFormat('d M Y') }}
                                            {{ $periodDate == $today ? '(Aktif Hari Ini)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-12 col-md-6 mt-3">
                                <label for="bank_id" class="form-label fw-semibold">Pilih Bank</label>
                                <select name="bank_id" id="bank_id" class="form-select form-select-lg" required>
                                    <option value="">-- Pilih Bank --</option>
                                    @isset($banks) <!-- Pastikan variabel banks ada -->
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold d-block mb-2">Package Duration</label>
                                <div class="duration-options-container">
                                    @php
                                        $durasiOptions = [
                                            'perhari' => ['label' => 'Per Day', 'harga' => $program->harga_perhari],
                                            'satu_minggu' => [
                                                'label' => '1 Week',
                                                'harga' => $program->harga_satu_minggu,
                                            ],
                                            'dua_minggu' => [
                                                'label' => '2 Weeks',
                                                'harga' => $program->harga_dua_minggu,
                                            ],
                                            'satu_bulan' => [
                                                'label' => '1 Month',
                                                'harga' => $program->harga_satu_bulan,
                                            ],
                                            'dua_bulan' => [
                                                'label' => '2 Months',
                                                'harga' => $program->harga_dua_bulan,
                                            ],
                                            'tiga_bulan' => [
                                                'label' => '3 Months',
                                                'harga' => $program->harga_tiga_bulan,
                                            ],
                                            'enam_bulan' => [
                                                'label' => '6 Months',
                                                'harga' => $program->harga_enam_bulan,
                                            ],
                                            'satu_tahun' => [
                                                'label' => '1 Years',
                                                'harga' => $program->harga_satu_tahun,
                                            ],
                                        ];
                                    @endphp
                                    @foreach ($durasiOptions as $key => $option)
                                        @if ($option['harga'] > 0)
                                            <div class="duration-option">
                                                <input class="form-check-input d-none" type="radio" name="durasi_paket"
                                                    id="{{ $key }}" value="{{ $key }}" required>
                                                <label
                                                    class="d-flex flex-column justify-content-center align-items-center p-3 rounded border text-center"
                                                    for="{{ $key }}">
                                                    <span class="fw-semibold">{{ $option['label'] }}</span>
                                                    <small class="text-muted">Rp
                                                        {{ number_format($option['harga']) }}</small>
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-4 px-lg-5 py-3 fw-semibold">
                                <i class="fas fa-arrow-right me-2"></i> Proceed to Room Selection
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- jQuery UI CDN -->
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <script>
            $(function() {
                $.getJSON('/indonesia-indonesian.json', function(data) {
                    let kotaList = [];

                    // Gabungkan semua kota/kab dari semua provinsi jadi satu array
                    for (let provinsi in data) {
                        kotaList = kotaList.concat(data[provinsi]);
                    }

                    // Inisialisasi autocomplete
                    $('#asal_kota').autocomplete({
                        source: kotaList,
                        minLength: 2
                    });
                });
            });
        </script>

    @endsection
