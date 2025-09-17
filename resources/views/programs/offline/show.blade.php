<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $program->nama }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- jQuery UI Autocomplete Stylesheet -->

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
</head>

<body class="bg-light">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="text-center mb-4">
                    <h1 class="fw-bold">{{ $program->nama }}</h1>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                @if ($program->thumbnail)
                                    <div class="text-center mb-3">

                                        <img src="{{ asset('storage/' . $program->thumbnail) }}"
                                            class="img-fluid rounded" alt="{{ $program->nama }}">
                                    </div>
                                @endif

                                <table class="table table-bordered">
                                    <tr>
                                        <th class="bg-light">Harga</th>
                                        <td>Rp {{ number_format($program->harga, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Jadwal</th>
                                        <td>{{ \Carbon\Carbon::parse($program->jadwal_mulai)->format('d M Y') }} -

                                            {{ \Carbon\Carbon::parse($program->jadwal_selesai)->format('d M Y') }}</td>

                                    </tr>
                                    <tr>
                                        <th class="bg-light">Kuota</th>
                                        <td>{{ $program->kuota }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Fasilitas</th>
                                        <td>
                                            @php
                                                $features = $program->features_program;
                                                if (is_string($features)) {
                                                    $decoded = json_decode($features, true);

                                                    $features =
                                                        json_last_error() === JSON_ERROR_NONE && is_array($decoded)
                                                            ? $decoded
                                                            : explode("\n", $features);
                                                }
                                            @endphp

                                            @if (!empty($features) && is_array($features))
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($features as $fitur)
                                                        <li>{{ \App\Helpers\FeatureHelper::getFeatureIcon($fitur) }}
                                                            {{ trim($fitur) }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <em>Tidak ada fasilitas tersedia.</em>
                                            @endif
                                        </td>

                                    </tr>
                                    <tr>
                                        <th class="bg-light">Status</th>
                                        <td>
                                            @if ($program->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-primary shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Formulir Pendaftaran</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">Silakan lengkapi data diri Anda untuk mendaftar program ini.
                                </p>
                                <div class="card-body">

                                    @if (session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    @php

                                        $activePeriods = $periods->where('is_active', 1);
                                    @endphp

                                    <form method="POST"
                                        action="{{ route('public.program.offline.daftar', $program->slug) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-person-fill"></i> Nama
                                            </label>
                                            <input type="text" name="nama_lengkap" class="form-control"
                                                value="{{ old('nama_lengkap') }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-geo-alt-fill"></i> Tempat &
                                                Tanggal Lahir</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" name="tempat_lahir" class="form-control"
                                                        value="{{ old('tempat_lahir') }}" placeholder="" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="date" name="tanggal_lahir" class="form-control"
                                                        value="{{ old('tanggal_lahir') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-gender-ambiguous"></i>
                                                Gender</label>
                                            <select name="gender" class="form-select" required>
                                                <option value="" disabled selected>-- Pilih Gender --</option>
                                                <option value="Laki-laki"
                                                    {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                                </option>
                                                <option value="Perempuan"
                                                    {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-telephone-fill"></i> No.
                                                HP</label>
                                            <input type="text" name="no_hp" class="form-control"
                                                value="{{ old('no_hp') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-geo-alt-fill"></i> Kota
                                                asal</label>
                                            <input type="text" name="asal_kota" class="form-control"
                                                value="{{ old('asal_kota') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-envelope-fill"></i> Email</label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email') }}" required>
                                        </div>


                                        {{-- ====================================================== --}}
                                        {{-- PERUBAHAN DIMULAI: Tambah Ukuran Seragam --}}
                                        @if (in_array(strtolower($program->program_bahasa), ['nhc', 'inggris', 'mandarin', 'jerman']))
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-tag"></i> Ukuran Seragam
                                                </label>
                                                <select name="ukuran_seragam" class="form-select" required>
                                                    <option value="">Pilih Ukuran Seragam</option>
                                                    <option value="S"
                                                        {{ old('ukuran_seragam') == 'S' ? 'selected' : '' }}>S</option>
                                                    <option value="M"
                                                        {{ old('ukuran_seragam') == 'M' ? 'selected' : '' }}>M</option>
                                                    <option value="L"
                                                        {{ old('ukuran_seragam') == 'L' ? 'selected' : '' }}>L</option>
                                                    <option value="XL"
                                                        {{ old('ukuran_seragam') == 'XL' ? 'selected' : '' }}>XL
                                                    </option>
                                                    <option value="XXL"
                                                        {{ old('ukuran_seragam') == 'XXL' ? 'selected' : '' }}>XXL
                                                    </option>
                                                </select>
                                            </div>
                                        @endif

                                        <div class="mb-4">
                                            <h5 class="mb-3"><i class="bi bi-basket"></i> Tambahan Layanan</h5>
                                            <small class="text-muted d-block mb-2">
                                                Opsional, isi jika ingin menerima layanan tambahan dari kami.
                                            </small>

                                            {{-- Navigation Tabs --}}
                                            <ul class="nav nav-tabs mb-3" id="servicesTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="catering-tab"
                                                        data-bs-toggle="tab" data-bs-target="#catering"
                                                        type="button" role="tab">Catering</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="laundry-tab" data-bs-toggle="tab"
                                                        data-bs-target="#laundry" type="button"
                                                        role="tab">Laundry</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="holiday-tab" data-bs-toggle="tab"
                                                        data-bs-target="#holiday" type="button"
                                                        role="tab">Holiday</button>
                                                </li>
                                                <li class="nav-item ms-auto" role="presentation">
                                                    <button class="nav-link position-relative" id="cart-tab"
                                                        data-bs-toggle="tab" data-bs-target="#cart" type="button"
                                                        role="tab">
                                                        Keranjang
                                                        <span id="cart-badge"
                                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
                                                    </button>
                                                </li>
                                            </ul>

                                            <div class="tab-content" id="servicesTabContent">
                                                {{-- Catering Tab --}}
                                                <div class="tab-pane fade show active" id="catering"
                                                    role="tabpanel">
                                                    <div class="row">
                                                        @if (isset($catering_packages) && count($catering_packages) > 0)
                                                            @foreach ($catering_packages as $catering)
                                                                <div class="col-md-4 mb-4">
                                                                    <div class="card h-100 service-card">
                                                                        <!-- Thumbnail di tengah -->
                                                                        <div class="text-center p-3">
                                                                            <img src="{{ $catering->thumbnail ? asset('storage/' . $catering->thumbnail) : 'https://via.placeholder.com/150' }}"
                                                                                alt="{{ $catering->nama_paket }}"
                                                                                class="img-fluid rounded"
                                                                                style="height: 150px; object-fit: cover;">
                                                                        </div>


                                                                        <div class="card-body d-flex flex-column p-3">
                                                                            <!-- Nama paket di tengah -->
                                                                            <div class="text-center mb-2">
                                                                                <h6 class="card-title fw-bold mb-1">
                                                                                    {{ $catering->nama_paket }}</h6>
                                                                                <!-- Harga di tengah bawah -->
                                                                                <p
                                                                                    class="card-text text-primary fw-semibold mb-2">
                                                                                    Rp
                                                                                    {{ number_format($catering->harga, 0, ',', '.') }}
                                                                                </p>
                                                                            </div>

                                                                            <div class="mt-auto">
                                                                                <div
                                                                                    class="d-flex justify-content-center align-items-center mb-2">
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-outline-secondary px-2"
                                                                                        onclick="decreaseQuantity('catering{{ $catering->id }}')">-</button>
                                                                                    <input type="number"
                                                                                        id="catering{{ $catering->id }}"
                                                                                        class="form-control form-control-sm mx-2 text-center"
                                                                                        value="0" min="0"
                                                                                        style="width: 50px;">
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-outline-secondary px-2"
                                                                                        onclick="increaseQuantity('catering{{ $catering->id }}')">+</button>
                                                                                </div>

                                                                                <button type="button"
                                                                                    class="btn btn-primary btn-sm w-100 py-1"
                                                                                    onclick="addToCart('catering', {{ $catering->id }}, '{{ $catering->nama_paket }}', {{ $catering->harga }}, document.getElementById('catering{{ $catering->id }}').value)">
                                                                                    <i
                                                                                        class="bi bi-cart-plus me-1"></i>
                                                                                    Tambah
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div class="col-12 text-center py-4">
                                                                <p class="text-muted">Tidak ada paket catering tersedia
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Laundry Tab --}}
                                                <div class="tab-pane fade" id="laundry" role="tabpanel">
                                                    <div class="row">
                                                        @if (isset($laundry_packages) && count($laundry_packages) > 0)
                                                            @foreach ($laundry_packages as $laundry)
                                                                <div class="col-md-4 mb-4">
                                                                    <div class="card h-100 service-card">
                                                                        <!-- Thumbnail di tengah -->
                                                                        <div class="text-center p-3">
                                                                            <img src="{{ $laundry->thumbnail ? asset('storage/' . $laundry->thumbnail) : 'https://via.placeholder.com/150' }}"
                                                                                alt="{{ $laundry->nama_paket }}"
                                                                                class="img-fluid rounded"
                                                                                style="height: 150px; object-fit: cover;">
                                                                        </div>

                                                                        <div class="card-body d-flex flex-column p-3">
                                                                            <!-- Nama paket di tengah -->
                                                                            <div class="text-center mb-2">
                                                                                <h6 class="card-title fw-bold mb-1">
                                                                                    {{ $laundry->nama_paket }}</h6>
                                                                                <!-- Harga di tengah bawah -->
                                                                                <p
                                                                                    class="card-text text-primary fw-semibold mb-2">
                                                                                    Rp
                                                                                    {{ number_format($laundry->harga, 0, ',', '.') }}
                                                                                </p>
                                                                            </div>

                                                                            <div class="mt-auto">
                                                                                <div
                                                                                    class="d-flex justify-content-center align-items-center mb-2">
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-outline-secondary px-2"
                                                                                        onclick="decreaseQuantity('laundry{{ $laundry->id }}')">-</button>
                                                                                    <input type="number"
                                                                                        id="laundry{{ $laundry->id }}"
                                                                                        class="form-control form-control-sm mx-2 text-center"
                                                                                        value="0" min="0"
                                                                                        style="width: 50px;">
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-outline-secondary px-2"
                                                                                        onclick="increaseQuantity('laundry{{ $laundry->id }}')">+</button>
                                                                                </div>

                                                                                <button type="button"
                                                                                    class="btn btn-primary btn-sm w-100 py-1"
                                                                                    onclick="addToCart('laundry', {{ $laundry->id }}, '{{ $laundry->nama_paket }}', {{ $laundry->harga }}, document.getElementById('laundry{{ $laundry->id }}').value)">
                                                                                    <i
                                                                                        class="bi bi-cart-plus me-1"></i>
                                                                                    Tambah
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div class="col-12 text-center py-4">
                                                                <p class="text-muted">Tidak ada paket laundry tersedia
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Holiday Tab --}}
                                                <div class="tab-pane fade" id="holiday" role="tabpanel">
                                                    <div class="row">
                                                        @if (isset($holiday_packages) && count($holiday_packages) > 0)
                                                            @foreach ($holiday_packages as $holiday)
                                                                <div class="col-md-4 mb-4">
                                                                    <div class="card h-100 service-card">
                                                                        <!-- Thumbnail di tengah -->
                                                                        <div class="text-center p-3">
                                                                            <img src="{{ $holiday->thumbnail ? asset('storage/' . $laundry->thumbnail) : 'https://via.placeholder.com/150' }}"
                                                                                alt="{{ $holiday->nama_paket }}"
                                                                                class="img-fluid rounded"
                                                                                style="height: 150px; object-fit: cover;">
                                                                        </div>


                                                                        <div class="card-body d-flex flex-column p-3">
                                                                            <!-- Nama paket di tengah -->
                                                                            <div class="text-center mb-2">
                                                                                <h6 class="card-title fw-bold mb-1">
                                                                                    {{ $holiday->nama_paket }}</h6>
                                                                                <!-- Harga di tengah bawah -->
                                                                                <p
                                                                                    class="card-text text-primary fw-semibold mb-2">
                                                                                    Rp
                                                                                    {{ number_format($holiday->harga, 0, ',', '.') }}
                                                                                </p>
                                                                            </div>

                                                                            <div class="mt-auto">
                                                                                <div
                                                                                    class="d-flex justify-content-center align-items-center mb-2">
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-outline-secondary px-2"
                                                                                        onclick="decreaseQuantity('holiday{{ $holiday->id }}')">-</button>
                                                                                    <input type="number"
                                                                                        id="holiday{{ $holiday->id }}"
                                                                                        class="form-control form-control-sm mx-2 text-center"
                                                                                        value="0" min="0"
                                                                                        style="width: 50px;">
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-outline-secondary px-2"
                                                                                        onclick="increaseQuantity('holiday{{ $holiday->id }}')">+</button>
                                                                                </div>

                                                                                <button type="button"
                                                                                    class="btn btn-primary btn-sm w-100 py-1"
                                                                                    onclick="addToCart('holiday', {{ $holiday->id }}, '{{ $holiday->nama_paket }}', {{ $holiday->harga }}, document.getElementById('holiday{{ $holiday->id }}').value)">
                                                                                    <i
                                                                                        class="bi bi-cart-plus me-1"></i>
                                                                                    Tambah
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div class="col-12 text-center py-4">
                                                                <p class="text-muted">Tidak ada paket holiday tersedia
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Cart Tab --}}
                                            <div class="tab-pane fade" id="cart" role="tabpanel">
                                                <div class="card">
                                                    <div class="card-header bg-light">
                                                        <h5 class="mb-0">Keranjang Layanan</h5>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div id="cart-items" class="list-group list-group-flush">
                                                            <div class="list-group-item text-center text-muted py-4"
                                                                id="empty-cart-message">
                                                                Keranjang masih kosong
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <strong>Total: <span id="cart-total">Rp 0</span></strong>
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="clearCart()">
                                                                <i class="bi bi-trash"></i> Kosongkan Keranjang
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Hidden input untuk kirim data ke controller --}}
                                            <input type="hidden" name="catering" id="cateringInput">
                                            <input type="hidden" name="laundry" id="laundryInput">
                                            <input type="hidden" name="holiday" id="holidayInput">


                                            <style>
                                                .service-card {
                                                    transition: transform 0.2s, box-shadow 0.2s;
                                                    border-radius: 12px;
                                                    border: 1px solid #e9ecef;
                                                    overflow: hidden;
                                                }

                                                .service-card:hover {
                                                    transform: translateY(-5px);
                                                    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
                                                }

                                                .card-title {
                                                    font-size: 1rem;
                                                    line-height: 1.4;
                                                    color: #333;
                                                }

                                                .card-text {
                                                    font-size: 1.1rem;
                                                    color: #0d6efd;
                                                }

                                                .btn-outline-secondary {
                                                    border-color: #dee2e6;
                                                    color: #6c757d;
                                                    width: 28px;
                                                    height: 28px;
                                                    display: flex;
                                                    align-items: center;
                                                    justify-content: center;
                                                    padding: 0;
                                                    font-size: 0.8rem;
                                                    border-radius: 4px;
                                                }

                                                .btn-primary {
                                                    font-weight: 500;
                                                    font-size: 0.9rem;
                                                    border-radius: 6px;
                                                    background-color: #0d6efd;
                                                    border: none;
                                                }

                                                .btn-primary:hover {
                                                    background-color: #0b5ed7;
                                                }

                                                .form-control-sm {
                                                    height: 28px;
                                                    font-size: 0.85rem;
                                                    border-radius: 4px;
                                                }
                                            </style>

                                            <script>
                                                let cart = {
                                                    catering: [],
                                                    laundry: [],
                                                    holiday: []
                                                };

                                                function increaseQuantity(inputId) {
                                                    const input = document.getElementById(inputId);
                                                    input.value = parseInt(input.value) + 1;
                                                }

                                                function decreaseQuantity(inputId) {
                                                    const input = document.getElementById(inputId);
                                                    if (parseInt(input.value) > 0) {
                                                        input.value = parseInt(input.value) - 1;
                                                    }
                                                }

                                                function addToCart(type, id, name, price, quantity) {
                                                    quantity = parseInt(quantity);
                                                    if (quantity <= 0) return;

                                                    // Cek apakah item sudah ada di keranjang
                                                    const existingIndex = cart[type].findIndex(item => item.id === id);

                                                    if (existingIndex !== -1) {
                                                        // Update quantity jika sudah ada
                                                        cart[type][existingIndex].quantity += quantity;
                                                    } else {
                                                        // Tambah item baru jika belum ada
                                                        cart[type].push({
                                                            id: id,
                                                            name: name,
                                                            price: price,
                                                            quantity: quantity
                                                        });
                                                    }

                                                    updateCart();
                                                    updateHiddenInputs();

                                                    // Reset quantity input
                                                    document.getElementById(type + id).value = 0;

                                                    // Switch to cart tab
                                                    const cartTab = new bootstrap.Tab(document.getElementById('cart-tab'));
                                                    cartTab.show();
                                                }

                                                function removeFromCart(type, id) {
                                                    cart[type] = cart[type].filter(item => item.id !== id);
                                                    updateCart();
                                                    updateHiddenInputs();
                                                }

                                                function clearCart() {
                                                    if (confirm('Apakah Anda yakin ingin mengosongkan keranjang?')) {
                                                        cart = {
                                                            catering: [],
                                                            laundry: [],
                                                            holiday: []
                                                        };
                                                        updateCart();
                                                        updateHiddenInputs();
                                                    }
                                                }

                                                function updateCart() {
                                                    const cartItems = document.getElementById('cart-items');
                                                    const emptyCartMessage = document.getElementById('empty-cart-message');
                                                    const cartBadge = document.getElementById('cart-badge');
                                                    const cartTotal = document.getElementById('cart-total');

                                                    let totalItems = 0;
                                                    let totalPrice = 0;

                                                    // Hapus semua item cart (kecuali pesan kosong)
                                                    while (cartItems.firstChild && cartItems.firstChild !== emptyCartMessage) {
                                                        cartItems.removeChild(cartItems.firstChild);
                                                    }

                                                    // Tambahkan item dari setiap kategori
                                                    for (const type in cart) {
                                                        cart[type].forEach(item => {
                                                            const itemTotal = item.price * item.quantity;
                                                            totalItems += item.quantity;
                                                            totalPrice += itemTotal;

                                                            const listItem = document.createElement('div');
                                                            listItem.className = 'list-group-item cart-item';
                                                            listItem.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">${item.name}</h6>
                            <small class="text-muted">Rp ${formatNumber(item.price)} x ${item.quantity}</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="me-3 fw-bold">Rp ${formatNumber(itemTotal)}</span>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFromCart('${type}', ${item.id})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                `;

                                                            cartItems.insertBefore(listItem, emptyCartMessage);
                                                        });
                                                    }

                                                    // Tampilkan/sembunyikan pesan keranjang kosong
                                                    if (totalItems > 0) {
                                                        emptyCartMessage.classList.add('d-none');
                                                    } else {
                                                        emptyCartMessage.classList.remove('d-none');
                                                    }

                                                    // Update badge dan total
                                                    cartBadge.textContent = totalItems;
                                                    cartTotal.textContent = `Rp ${formatNumber(totalPrice)}`;
                                                }

                                                function updateHiddenInputs() {
                                                    document.getElementById('cateringInput').value = JSON.stringify(cart.catering);
                                                    document.getElementById('laundryInput').value = JSON.stringify(cart.laundry);
                                                    document.getElementById('holidayInput').value = JSON.stringify(cart.holiday);
                                                }

                                                function formatNumber(number) {
                                                    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                                }

                                                // Inisialisasi cart saat halaman dimuat
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    updateCart();
                                                });
                                            </script>

                                            {{-- <div class="mb-3">
                                            <label class="form-label">
                                                <i class="bi bi-house-fill"></i> Akomodasi (Camp Reguler) - Optional
                                            </label>
                                            <select name="akomodasi" class="form-select" id="campSelect">
                                                <option value="" data-harga="0">Pilih Akomodasi (Opsional)
                                                </option>

                                                <option value="reguler" data-harga="180000">Reguler (Rp 180.000)
                                                </option>
                                                   </select>
                                        </div> --}}
                                            <div class="mb-3">
                                                <label class="form-label"><i class="bi bi-person-lines-fill"></i> No.
                                                    HP
                                                    Wali</label>
                                                <input type="text" name="no_wali" class="form-control"
                                                    value="{{ old('no_wali') }}">
                                            </div>

                                            @if (strtolower($program->program_bahasa) === 'arab')
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        <i class="bi bi-house-fill"></i> Akomodasi (Camp Reguler) -
                                                        Optional
                                                    </label>
                                                    <select name="akomodasi" class="form-select" id="campSelect">
                                                        <option value="" data-harga="0">Pilih Akomodasi
                                                            (Opsional)
                                                        </option>
                                                        <option value="reguler" data-harga="180000">Reguler (Rp
                                                            180.000)
                                                        </option>
                                                    </select>
                                                </div>
                                            @endif


                                            {{-- Camp VIP dari database --}}
                                            {{-- @foreach ($camps as $camp)
                                                    @if ($camp->kategori === 'VIP')
                                                        <option value="camp-{{ $camp->id }}"
                                                            data-harga="{{ $camp->harga }}">
                                                            {{ $camp->nama }} (VIP) - Rp
                                                            {{ number_format($camp->harga, 0, ',', '.') }}
                                                        </option>
                                                    @endif
                                                @endforeach --}}


                                            {{-- Tempat tampil harga
                                        <div id="akomodasi-harga" class="mt-2 fw-bold text-success"></div>
 --}}



                                            {{-- <div class="duration-options-container" id="durasiContainer"
                                            style="display:none;">
                                            @php
                                                $durasiOptions = [
                                                    'perhari' => [
                                                        'label' => 'Per Day',
                                                        'harga' => $camp->harga_perhari ?? 0,
                                                    ],
                                                    'satu_minggu' => [
                                                        'label' => '1 Week',
                                                        'harga' => $camp->harga_satu_minggu ?? 0,
                                                    ],
                                                    'dua_minggu' => [
                                                        'label' => '2 Weeks',
                                                        'harga' => $camp->harga_dua_minggu ?? 0,
                                                    ],
                                                    'satu_bulan' => [
                                                        'label' => '1 Month',
                                                        'harga' => $camp->harga_satu_bulan ?? 0,
                                                    ],
                                                    'dua_bulan' => [
                                                        'label' => '2 Months',
                                                        'harga' => $camp->harga_dua_bulan ?? 0,
                                                    ],
                                                    'tiga_bulan' => [
                                                        'label' => '3 Months',
                                                        'harga' => $camp->harga_tiga_bulan ?? 0,
                                                    ],
                                                    'enam_bulan' => [
                                                        'label' => '6 Months',
                                                        'harga' => $camp->harga_enam_bulan ?? 0,
                                                    ],
                                                    'satu_tahun' => [
                                                        'label' => '1 Year',
                                                        'harga' => $camp->harga_satu_tahun ?? 0,
                                                    ],
                                                ];
                                            @endphp
                                            <select name="durasi" class="form-select" id="durasiSelect">
                                                <option value="">Pilih Durasi</option>
                                                @foreach ($durasiOptions as $key => $option)
                                                    <option value="{{ $key }}"
                                                        data-harga="{{ $option['harga'] }}">
                                                        {{ $option['label'] }} -
                                                        Rp.{{ number_format($option['harga'], 0, ',', '.') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div> --}}

                                            {{-- <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                const campSelect = document.getElementById("campSelect");
                                                const durasiContainer = document.getElementById("durasiContainer");

                                                campSelect.addEventListener("change", function() {
                                                    if (this.value) {
                                                        durasiContainer.style.display = "block"; // tampilkan jika ada camp dipilih
                                                    } else {
                                                        durasiContainer.style.display = "none"; // sembunyikan jika kosong
                                                    }
                                                });
                                            });
                                        </script> --}}


                                            <br>

                                            {{-- Preview total --}}
                                            <div
                                                class="d-flex align-items-center border rounded p-3 bg-light mt-3 shadow-sm">
                                                <strong class="me-2">Total:</strong>
                                                <span id="totalPreview" class="fw-bold text-success">
                                                    Rp{{ number_format($program->harga, 0, ',', '.') }}
                                                </span>

                                                <a href="javascript:void(0)" id="btnLihatTotal"
                                                    class="ms-auto btn btn-sm btn-outline-primary rounded-pill px-3">
                                                    Lihat Detail
                                                </a>
                                            </div>

                                            {{-- Modal struk --}}
                                            <div class="modal fade" id="modalTotal" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                                    <div class="modal-content rounded-3 shadow-lg">
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title fw-bold">Rincian Pembayaran</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <span>Harga Program</span>
                                                                <span id="hargaProgram">
                                                                    Rp{{ number_format($program->harga, 0, ',', '.') }}
                                                                </span>
                                                            </div>

                                                            <div class="d-flex justify-content-between mb-2">
                                                                <span>Transportasi</span>
                                                                <span id="hargaTransport">Rp0</span>
                                                            </div>

                                                            @if (strtolower($program->program_bahasa) === 'arab')
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <span>Akomodasi Camp (Reguler)</span>
                                                                    <span id="hargaCamp">Rp0</span>
                                                                </div>
                                                            @endif

                                                            <hr>
                                                            <div
                                                                class="d-flex justify-content-between fw-bold fs-5 text-primary">
                                                                <span>Total</span>
                                                                <span id="totalModal">
                                                                    Rp{{ number_format($program->harga, 0, ',', '.') }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    let basePrice = {{ $program->harga }};
                                                    let selectTransport = document.getElementById("transportSelect");
                                                    let selectCamp = document.getElementById("campSelect");
                                                    let btnLihatTotal = document.getElementById("btnLihatTotal");

                                                    let hargaProgram = document.getElementById("hargaProgram");
                                                    let hargaTransport = document.getElementById("hargaTransport");
                                                    let hargaCamp = document.getElementById("hargaCamp");
                                                    let totalPreview = document.getElementById("totalPreview");
                                                    let totalModal = document.getElementById("totalModal");

                                                    function updateTotal() {
                                                        let transportPrice = selectTransport?.selectedOptions[0]?.dataset.harga ?
                                                            parseInt(selectTransport.selectedOptions[0].dataset.harga) : 0;

                                                        let campPrice = selectCamp?.selectedOptions[0]?.dataset.harga ?
                                                            parseInt(selectCamp.selectedOptions[0].dataset.harga) : 0;

                                                        let total = basePrice + transportPrice + campPrice;

                                                        // update preview total
                                                        totalPreview.textContent = "Rp" + total.toLocaleString('id-ID');

                                                        // update detail modal
                                                        hargaProgram.textContent = "Rp" + basePrice.toLocaleString('id-ID');
                                                        hargaTransport.textContent = "Rp" + transportPrice.toLocaleString('id-ID');
                                                        if (hargaCamp) {
                                                            hargaCamp.textContent = "Rp" + campPrice.toLocaleString('id-ID');
                                                        }
                                                        totalModal.textContent = "Rp" + total.toLocaleString('id-ID');
                                                    }

                                                    // trigger saat pilih transport / camp
                                                    if (selectTransport) selectTransport.addEventListener("change", updateTotal);
                                                    if (selectCamp) selectCamp.addEventListener("change", updateTotal);

                                                    // buka modal
                                                    btnLihatTotal.addEventListener("click", function() {
                                                        new bootstrap.Modal(document.getElementById('modalTotal')).show();
                                                    });
                                                });
                                            </script>

                                            <br>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="bi bi-wallet2"></i> Metode Pembayaran
                                                </label>
                                                <div class="d-flex flex-wrap gap-3">

                                                    {{-- Tunai --}}
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="payment_type" id="pay_tunai" value="tunai"
                                                            {{ old('payment_type') == 'tunai' ? 'checked' : '' }}
                                                            required>
                                                        <label class="form-check-label" for="pay_tunai">Bayar Tunai
                                                            (Cash)</label>
                                                    </div>

                                                    {{-- Transfer --}}
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="payment_type" id="pay_transfer" value="transfer"
                                                            {{ old('payment_type') == 'transfer' ? 'checked' : '' }}
                                                            required>
                                                        <label class="form-check-label" for="pay_transfer">Transfer
                                                            Bank</label>
                                                    </div>

                                                    {{-- Qris muncul hanya jika bahasa == mandarin --}}
                                                    @if (strtolower($program->program_bahasa) === 'mandarin')
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="payment_type" id="pay_qris" value="qris"
                                                                {{ old('payment_type') == 'qris' ? 'checked' : '' }}
                                                                required>
                                                            <label class="form-check-label"
                                                                for="pay_qris">QRIS</label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="mb-3" id="bankDropdown" style="display: none;">
                                                <label class="form-label fw-bold"><i class="bi bi-bank"></i> Pilih
                                                    Bank
                                                    Tujuan</label>
                                                <select name="bank_id" class="form-select"
                                                    {{ old('payment_type') == 'transfer' ? 'required' : '' }}>
                                                    <option value="">-- Pilih Bank --</option>
                                                    @if (isset($banks) && $banks->isNotEmpty())
                                                        @foreach ($banks as $bank)
                                                            <option value="{{ $bank->id }}"
                                                                {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                                                                {{ $bank->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>


                                            <div class="mb-3">
                                                <label class="form-label"><i class="bi bi-bus-front-fill"></i>
                                                    Transportasi
                                                    (Optional)</label>
                                                <select name="transport_id" class="form-select" id="transportSelect">
                                                    <option value="" data-harga="0">Pilih Transportasi </option>
                                                    @foreach ($transports as $transport)
                                                        <option value="{{ $transport->id }}"
                                                            data-harga="{{ $transport->price }}">
                                                            {{ $transport->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <script>
                                                $(document).ready(function() {
                                                    toggleBankDropdown();

                                                    $('input[name="payment_type"]').change(function() {
                                                        toggleBankDropdown();
                                                    });

                                                    function toggleBankDropdown() {
                                                        if ($('input[name="payment_type"]:checked').val() === 'transfer') {
                                                            $('#bankDropdown').slideDown();
                                                            $('select[name="bank_id"]').attr('required', true);
                                                        } else {
                                                            $('#bankDropdown').slideUp();
                                                            $('select[name="bank_id"]').removeAttr('required');
                                                        }
                                                    }
                                                });
                                            </script>


                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-calendar-check-fill"></i> Periode
                                                </label>

                                                @php
                                                    $today = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
                                                @endphp

                                                @if ($program->program_bahasa === 'nhc')
                                                    <select name="period_nhc_id" class="form-select" required>
                                                        <option value="">Pilih Periode</option>
                                                        @forelse ($activePeriodsNHC as $period)
                                                            @php
                                                                $isToday =
                                                                    $today >= $period->start_date->toDateString() &&
                                                                    $today <= $period->end_date->toDateString();
                                                            @endphp
                                                            <option value="{{ $period->id }}"
                                                                {{ old('period_nhc_id') == $period->id ? 'selected' : ($isToday ? 'selected' : '') }}>
                                                                {{ $period->start_date->translatedFormat('d M Y') }}
                                                                -
                                                                {{ $period->end_date->translatedFormat('d M Y') }}
                                                                {{ $isToday ? '(Aktif Hari Ini)' : '' }}
                                                            </option>
                                                        @empty
                                                        @endforelse
                                                    </select>

                                                    @if ($activePeriodsNHC->isEmpty())
                                                        <div class="form-text text-danger">
                                                            Tidak ada periode pendaftaran NHC yang aktif saat ini.
                                                        </div>
                                                    @endif
                                                @else
                                                    <select name="period_id" class="form-select" required>
                                                        <option value="">Pilih Periode</option>
                                                        @forelse ($activePeriods as $period)
                                                            @php
                                                                $periodDate = \Carbon\Carbon::parse(
                                                                    $period->date,
                                                                )->toDateString();
                                                                $isToday = $periodDate === $today;
                                                            @endphp
                                                            <option value="{{ $period->id }}"
                                                                {{ old('period_id') == $period->id ? 'selected' : ($isToday ? 'selected' : '') }}>
                                                                {{ \Carbon\Carbon::parse($period->date)->translatedFormat('d M Y') }}
                                                                {{ $isToday ? '(Aktif Hari Ini)' : '' }}
                                                            </option>
                                                        @empty
                                                        @endforelse
                                                    </select>

                                                    @if ($activePeriods->isEmpty())
                                                        <div class="form-text text-danger">
                                                            Tidak ada periode pendaftaran yang aktif saat ini.
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>

                                            <button type="submit" class="btn btn-primary w-100"
                                                @if (
                                                    ($program->program_bahasa === 'nhc' && $activePeriodsNHC->isEmpty()) ||
                                                        ($program->program_bahasa !== 'nhc' && $periods->isEmpty()) ||
                                                        !isset($banks) ||
                                                        $banks->isEmpty()) disabled @endif>

                                                <i class="bi bi-send-fill"></i>

                                                @if (
                                                    ($program->program_bahasa === 'nhc' && $activePeriodsNHC->isNotEmpty()) ||
                                                        ($program->program_bahasa !== 'nhc' && $periods->isNotEmpty()))
                                                    Daftar Sekarang
                                                @else
                                                    Pendaftaran Ditutup
                                                @endif
                                            </button>

                                            <a href="{{ url('/') }}"
                                                class="btn btn-outline-secondary w-100 mt-2"><i
                                                    class="bi bi-arrow-left"></i> Kembali ke Beranda</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery dan jQuery UI (untuk autocomplete) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <!-- Script Autocomplete -->
    <script>
        $(function() {
            $.getJSON('/indonesia-indonesian.json', function(data) {
                let kotaList = [];

                // Gabungkan semua kota/kab dari semua provinsi jadi satu array
                for (let provinsi in data) {
                    kotaList = kotaList.concat(data[provinsi]);
                }

                // Inisialisasi autocomplete
                $('[name="asal_kota"]').autocomplete({
                    source: kotaList,
                    minLength: 2
                });
            });
        });
    </script>



    {{-- <script>
document.addEventListener("DOMContentLoaded", function() {
    Swal.fire({
        icon: 'warning',
        title: 'PERHATIAN',
        html: 'Formulir pendaftaran ini <b>dikhususkan untuk pendaftaran PROGRAM</b>.<br>Apabila ingin mendaftar camp, maka <b>kembalilah ke HALAMAN UTAMA</b>.',
        confirmButtonText: 'Mengerti',
        confirmButtonColor: '#d33'
    });
});
</script> --}}


</body>

</html>
