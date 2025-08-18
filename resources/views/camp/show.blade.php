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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#videoModal">
                        Lihat Tutorial Pendaftaran Camp BIE+
                    </button>
                </div>


                <!-- Modal -->
                <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title text-center w-100" id="videoModalLabel">Tutorial Pendaftaran Camp
                                    BIE+
                                </h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body d-flex justify-content-center">
                                <div class="sosmed-card-video" style="max-width: 560px; width: 100%;">
                                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/rMfdvef5os4"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Image and Description Section -->
                <div class="container">
                    <!-- Gambar / Carousel di atas -->
                    @php
                        // Mengelompokkan thumbnail menjadi grup 3

                        $thumbnails = $program->thumbnail_urls->toArray();
                        $chunks = array_chunk($thumbnails, 3);
                    @endphp



                    <div class="rounded-3 overflow-hidden shadow-sm mb-4" style="padding: 8px;">
                        @if (count($program->thumbnail_urls) > 1)
                            <div id="campCarousel" class="carousel slide" data-bs-ride="false">

                                {{-- Gambar --}}
                                <div class="carousel-inner">
                                    @foreach ($chunks as $index => $group)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <div class="d-flex gap-3 justify-content-center">
                                                @foreach ($group as $url)
                                                    <div
                                                        style="width: 350px; height: 350px; overflow: hidden; border-radius: 8px;">
                                                        <img src="{{ $url }}"
                                                            style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Bulatan indikator di bawah gambar --}}
                                <div class="carousel-indicators mt-3 d-flex justify-content-center gap-2">
                                    @foreach ($chunks as $index => $group)
                                        <button type="button" data-bs-target="#campCarousel"
                                            data-bs-slide-to="{{ $index }}"
                                            class="{{ $index === 0 ? 'active' : '' }}"
                                            aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                            aria-label="Slide {{ $index + 1 }}">
                                        </button>
                                    @endforeach
                                </div>

                            </div>

                            <style>
                                /* Override default Bootstrap */
                                #campCarousel .carousel-indicators {
                                    position: static !important;
                                    /* biar ikut flow dokumen */
                                    margin-top: 20px;
                                }

                                #campCarousel .carousel-indicators button {
                                    width: 16px;
                                    height: 16px;
                                    border-radius: 50%;
                                    border: none;
                                    background-color: rgba(255, 165, 0, 0.6);
                                    transition: background-color 0.3s;
                                }

                                #campCarousel .carousel-indicators button.active {
                                    background-color: orange !important;
                                }

                                #campCarousel .carousel-indicators button:hover {
                                    background-color: #ffb347 !important;
                                }
                            </style>
                        @else
                            <img src="{{ $program->thumbnail_url }}" class="img-fluid w-100 card-img-top"
                                alt="{{ $program->nama }}" style="object-fit: cover; height: 350px;" loading="lazy">
                        @endif
                    </div>





                    <!-- Fasilitas dan lokasi di bawah, kiri-kanan -->
                    <div class="row g-3 g-lg-4">
                        <!-- Fasilitas kiri -->
                        <div class="col-12 col-lg-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body p-3 p-lg-4">
                                    <h3 class="fw-bold text-white text-center mb-3 bg-primary p-2 rounded">Fasilitas</h3>

                                    @php
                                        $items = is_array($program->fasilitas)
                                            ? $program->fasilitas
                                            : preg_split(
                                                '/\s*,\s*/',
                                                (string) $program->fasilitas,
                                                -1,
                                                PREG_SPLIT_NO_EMPTY,
                                            );
                                        $iconmap = [
                                            'pemanas air' => '🛁',
                                            'wifi' => '📶',
                                            'pendingin ruangan' => '❄️',
                                            'tempat tidur' => '🛏️',
                                            'kamar terpisah' => '🚻',
                                            'shower' => '🚿',
                                            'area umum' => '🛋️',
                                            'tempat sampah' => '🪣',
                                            'lemari' => '🗄️',
                                            'keset' => '🚪',
                                            'cctv' => '📹',
                                            'keamanan 24 jam' => '🛡️',
                                        ];
                                        $maxItems = 6;
                                    @endphp

                                    <div class="list-unstyled mb-4">
                                        @foreach ($items as $index => $fasilitas)
                                            @php
                                                $icon = '✅';
                                                foreach ($iconmap as $keyword => $emoji) {
                                                    if (stripos($fasilitas, $keyword) !== false) {
                                                        $icon = $emoji;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            <div
                                                class="facility-item d-flex align-items-start mb-2 {{ $index >= $maxItems ? 'extra-facility d-none' : '' }}">
                                                <span class="me-2">{{ $icon }}</span>
                                                <span>{{ trim($fasilitas) }}</span>
                                            </div>
                                        @endforeach

                                        @if (count($items) > $maxItems)
                                            <button id="showMoreBtn" class="btn btn-link p-0">Tampilkan
                                                selengkapnya</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body p-3 p-lg-4">
                                    <h3 class="fw-bold text-white text-center mb-3 bg-primary p-2 rounded">Lokasi</h3>
                                    @php
                                        $locations = [
                                            ['icon' => 'bi-tree-fill text-success', 'text' => '1.6km dari Taman Kota'],
                                            [
                                                'icon' => 'bi-bus-front-fill text-warning',
                                                'text' => '1.4km dari Terminal Pare',
                                            ],
                                            ['icon' => 'bi-shop text-primary', 'text' => '1.3km dari Pasar Induk Pare'],
                                            ['icon' => 'bi-hospital text-danger', 'text' => '700m dari Klinik'],
                                            [
                                                'icon' => 'bi-brightness-alt-high-fill text-warning',
                                                'text' => '150m dari Wisata Pasar Senja',
                                            ],
                                            ['icon' => 'bi-building text-success', 'text' => '60m dari Masjid'],
                                            ['icon' => 'bi-cup-straw text-danger', 'text' => '50m dari Warung Makan'],
                                        ];
                                    @endphp
                                    <div class="list-unstyled">
                                        @foreach ($locations as $loc)
                                            <div class="d-flex align-items-start mb-2">
                                                <i class="bi {{ $loc['icon'] }} me-2"></i>
                                                <span>{{ $loc['text'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <link rel="stylesheet"
                            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
                        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
                            rel="stylesheet">


                    </div>




                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const btn = document.getElementById('showMoreBtn');
                            if (btn) {
                                btn.addEventListener('click', function() {
                                    document.querySelectorAll('.extra-facility').forEach(function(el) {
                                        el.classList.remove('d-none');
                                    });
                                    btn.style.display = 'none';
                                });
                            }
                        });
                    </script>


                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const btn = document.getElementById('showMoreBtn');
                            if (btn) {
                                btn.addEventListener('click', function() {
                                    document.querySelectorAll('.extra-facility').forEach(function(el) {
                                        el.classList.remove('d-none');
                                    });
                                    btn.style.display = 'none';
                                });
                            }
                        });
                    </script>

                    <style>
                        #campCarousel .carousel-indicators button.active {
                            background-color: orange !important;
                        }

                        #campCarousel .carousel-indicators button:hover {
                            background-color: #ffb347 !important;
                        }
                    </style>

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
                                        <input type="text" name="nama_lengkap" class="form-control form-control-lg"
                                            required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <input type="email" name="email" class="form-control form-control-lg" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="no_hp" class="form-label fw-semibold">Phone Number</label>
                                        <input type="text" name="no_hp" class="form-control form-control-lg"
                                            required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="asal_kota" class="form-label fw-semibold">City of Origin</label>
                                        <input type="text" id="asal_kota" name="asal_kota"
                                            class="form-control form-control-lg" required>



                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="gender" class="form-label fw-semibold">Gender</label>
                                        <select name="gender" id="gender" class="form-select form-select-lg"
                                            required>
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

                                                {{-- hanya tampilkan period yang >= hari ini --}}
                                                @if ($periodDate >= $today)
                                                    <option value="{{ $period->id }}"
                                                        {{ $periodDate == $today ? 'selected' : '' }}>
                                                        Periode:
                                                        {{ \Carbon\Carbon::parse($period->date)->translatedFormat('d M Y') }}
                                                        {{ $periodDate == $today ? '(Aktif Hari Ini)' : '' }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>



                                    <div class="row">
                                        <!-- JavaScript untuk menampilkan/sembunyikan form bank -->
                                        <div class="col-12 col-md-6 mt-3">
                                            <label for="payment_type" class="form-label fw-semibold">Jenis
                                                Pembayaran</label>
                                            <select name="payment_type" id="payment_type"
                                                class="form-select form-select-lg" required>
                                                <option value="">-- Pilih Jenis Pembayaran --</option>
                                                <option value="tunai"
                                                    {{ old('payment_type') == 'tunai' ? 'selected' : '' }}>
                                                    Tunai</option>
                                                <option value="nontunai"
                                                    {{ old('payment_type') == 'nontunai' ? 'selected' : '' }}>NonTunai
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-6 mt-3" id="bankForm" style="display: none;">
                                            <label for="bank_id" class="form-label fw-semibold">Pilih Bank</label>
                                            <select name="bank_id" id="bank_id" class="form-select form-select-lg">
                                                <option value="">-- Pilih Bank --</option>
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank->id }}"
                                                        {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                                                        {{ $bank->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-6 mt-3 bukti-section" style="display:none;">
                                            <label for="bukti_pembayaran" class="form-label fw-semibold">Upload Bukti
                                                Pembayaran</label>
                                            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran"
                                                class="form-control" accept="image/*" />
                                        </div>

                                        <script>
                                            document.getElementById('payment_type').addEventListener('change', function() {
                                                const bankForm = document.getElementById('bankForm');
                                                if (this.value === 'nontunai') {
                                                    bankForm.style.display = 'block';
                                                    document.getElementById('bank_id').setAttribute('required', 'required');
                                                } else {
                                                    bankForm.style.display = 'none';
                                                    document.getElementById('bank_id').removeAttribute('required');
                                                    document.getElementById('bank_id').value = '';
                                                }
                                            });

                                            document.addEventListener('DOMContentLoaded', function() {
                                                document.getElementById('payment_type').dispatchEvent(new Event('change'));
                                            });
                                        </script>

                                        <div class="col-12">
                                            <label class="form-label fw-semibold d-block mb-2">Package Duration</label>
                                            <div class="duration-options-container">
                                                @php
                                                    $durasiOptions = [
                                                        'perhari' => [
                                                            'label' => 'Per Day',
                                                            'harga' => $program->harga_perhari,
                                                        ],
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
                                                            <input class="form-check-input d-none" type="radio"
                                                                name="durasi_paket" id="{{ $key }}"
                                                                value="{{ $key }}" required>
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
                                        <button type="submit"
                                            class="btn btn-primary btn-lg px-4 px-lg-5 py-3 fw-semibold">
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
