    @extends('layouts.app')

    @section('title', $program->nama)

    @section('content')
    <style>
        /* Base styles for all devices */
        .program-card {
            transition: transform 0.3s ease;
        }
        .program-card:hover {
            transform: translateY(-5px);
        }
        .duration-option {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .duration-option:hover {
            background-color: #f8f9fa;
        }
        .duration-option input[type="radio"]:checked + label {
            background-color: #e9f7fe;
            border-color: #0d6efd;
        }

        /* Mobile-specific styles */
        @media (max-width: 767.98px) {
            .display-4 {
                font-size: 1.8rem !important;
                line-height: 1.3;
            }
            .lead {
                font-size: 1rem !important;
            }
            .card-header h3 {
                font-size: 1.25rem;
            }
            .btn-lg {
                padding: 0.5rem 1rem !important;
                font-size: 1rem !important;
            }
            .form-control-lg, .form-select-lg {
                font-size: 1rem !important;
                padding: 0.5rem 1rem !important;
            }
            .table-responsive-mobile {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            .table-responsive-mobile table {
                width: 100%;
                min-width: 500px;
            }
            .card-img-top {
                height: 250px !important;
            }
            .duration-options-container {
                overflow-x: auto;
                white-space: nowrap;
                display: flex;
                padding-bottom: 10px;
            }
            .duration-option {
                min-width: 120px;
                display: inline-block;
                margin-right: 10px;
                white-space: normal;
            }
        }

        /* Desktop-specific styles */
        @media (min-width: 768px) {
            .card-img-top {
                height: 400px !important;
            }
            .duration-option {
                height: 100%;
            }
        }

        /* Common styles for both */
        .facility-item {
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .facility-item:last-child {
            border-bottom: none;
        }
        .border-primary-custom {
            border-color: #0d6efd !important;
        }
    </style>

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
                        class="img-fluid w-100 card-img-top"
                        alt="{{ $program->nama }}"
                        style="object-fit: cover;"
                        loading="lazy">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3 p-lg-4">
                        <h3 class="fw-bold text-primary mb-3">Program Facilities</h3>
                        <div class="list-unstyled mb-4">
                            @foreach($facilities as $fasilitas)
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
                {{-- <form action="{{ route('camp.pendaftaran.store', $program->id) }}" method="POST">
                    @csrf --}}
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
                            <input type="text" name="asal_kota" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="period_id" class="form-label fw-semibold">Select Period</label>
                            <select name="period_id" class="form-select form-select-lg" required>
                                <option value="">-- Select Period --</option>
                                @foreach($periods as $period)
                                    <option value="{{ $period->id }}">{{ $period->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold d-block mb-2">Package Duration</label>
                            <div class="duration-options-container">
                                @php
                                    $durasiOptions = [
                                        'perhari' => ['label' => 'Per Day', 'harga' => $program->harga_perhari],
                                        'satu_minggu' => ['label' => '1 Week', 'harga' => $program->harga_satu_minggu],
                                        'dua_minggu' => ['label' => '2 Weeks', 'harga' => $program->harga_dua_minggu],
                                        'satu_bulan' => ['label' => '1 Month', 'harga' => $program->harga_satu_bulan],
                                        'dua_bulan' => ['label' => '2 Months', 'harga' => $program->harga_dua_bulan],
                                        'tiga_bulan' => ['label' => '3 Months', 'harga' => $program->harga_tiga_bulan],
                                    ];
                                @endphp
                                @foreach($durasiOptions as $key => $option)
                                    @if($option['harga'] > 0)
                                    <div class="duration-option">
                                        <input class="form-check-input d-none" type="radio" name="durasi_paket" id="{{ $key }}" value="{{ $key }}" required>
                                        <label class="d-flex flex-column p-3 rounded border w-100 h-100" for="{{ $key }}">
                                            <span class="fw-semibold text-center">{{ $option['label'] }}</span>
                                            <small class="text-muted text-center">Rp {{ number_format($option['harga']) }}</small>
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

        <a href="{{ route('camp.room', ['slug' => $program->slug]) }}" class="btn btn-primary mt-3">
            Pilih Kamar Sekarang
        </a>


        <!-- Back Button -->
        <div class="text-center mb-4 mb-lg-5">
            <a href="{{ route('camps.index') }}" class="btn btn-outline-secondary px-4 py-2 fw-semibold">
                <i class="fas fa-arrow-left me-2"></i> Back to Camp List
            </a>
        </div>
    </div>
    @endsection
