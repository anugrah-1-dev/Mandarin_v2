@extends('layouts.app')

@section('content')
    <div class="container py-5" id="TrackingTrx">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bold text-primary">Tracking Transaksi</h1>
                    <p class="lead text-muted">Cek status transaksi dan program Anda dengan mudah</p>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show text-center">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm mb-5">
                    <div class="card-body p-4">
                        <form action="{{ route('tracking.search') }}" method="POST" class="row g-3">
                            @csrf
                            <div class="col-md-8">
                                <input type="text" name="trx_id" class="form-control form-control-lg"
                                    placeholder="Masukkan Kode Transaksi (TRX-XXXXXX)" required
                                    value="{{ old('trx_id', $trx_id ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="bi bi-search me-2"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Hasil Tracking --}}
                @isset($camp)
                    <div class="card shadow-sm mb-4 border-primary">
                        <div class="card-header bg-primary text-white fw-bold">
                            <i class="bi bi-house-door me-2"></i> Program Camp
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Nama Peserta</h5>
                                    <p class="fs-5">{{ $camp->nama_lengkap }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Status</h5>
                                    <span
                                        class="badge fs-6 bg-{{ $camp->status == 'diterima'
                                            ? 'success'
                                            : ($camp->status == 'diproses'
                                                ? 'warning text-dark'
                                                : ($camp->status == 'ditolak'
                                                    ? 'danger'
                                                    : 'secondary')) }}">
                                        {{ ucfirst($camp->status) }}
                                    </span>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Nama Program</h5>
                                    @if ($camp)
                                        <p class="fs-5">{{ $camp->program->nama ?? '-' }}</p>
                                    @endif
                                </div>

                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Kamar</h5>
                                    @if ($camp->status === 'diterima')
                                        <p class="fs-5">{{ $camp->nama_kamar }}</p>
                                    @else
                                        <p class="fs-5 text-muted"><em>Kamar sedang diproses oleh admin</em></p>
                                    @endif
                                </div>
                                @if ($camp->bukti_pembayaran)
                                    <div class="col-md-12 mb-3">
                                        <h5 class="text-muted">Bukti Pembayaran</h5>
                                        <a href="{{ asset('storage/' . $camp->bukti_pembayaran) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $camp->bukti_pembayaran) }}" alt="Bukti Pembayaran"
                                                class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </div>

                    </div>
                @endisset

                @isset($offline)
                    <div class="card shadow-sm mb-4 border-info">
                        <div class="card-header bg-info text-white fw-bold">
                            <i class="bi bi-building me-2"></i> Program Offline
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Nama Peserta</h5>
                                    <p class="fs-5">{{ $offline->nama_lengkap }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Status</h5>
                                    <span class="badge bg-{{ $offline->status == 'aktif' ? 'success' : 'warning' }} fs-6">
                                        {{ ucfirst($offline->status) }}
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Program ID</h5>
                                    @if ($offline)
                                        <p class="fs-5">{{ $offline->program->nama ?? '-' }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Transportasi</h5>
                                    <p class="fs-5">{{ $offline->transport_id }}</p>
                                </div>
                                @if ($offline->bukti_pembayaran)
                                    <div class="col-md-12 mb-3">
                                        <h5 class="text-muted">Bukti Pembayaran</h5>
                                        <a href="{{ asset('storage/bukti_pembayaran/' . $offline->bukti_pembayaran) }}"
                                            target="_blank">
                                            <img src="{{ asset('storage/bukti_pembayaran/' . $offline->bukti_pembayaran) }}"
                                                alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm"
                                                style="max-height: 300px;">
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                @endisset

                @isset($online)
                    <div class="card shadow-sm mb-4 border-success">
                        <div class="card-header bg-success text-white fw-bold">
                            <i class="bi bi-laptop me-2"></i> Program Online
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Nama Peserta</h5>
                                    <p class="fs-5">{{ $online->nama_lengkap }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h5 class="text-muted">Status</h5>
                                    <span class="badge bg-{{ $online->status == 'aktif' ? 'success' : 'warning' }} fs-6">
                                        {{ ucfirst($online->status) }}
                                    </span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <h5 class="text-muted">Program</h5>
                                    @if ($online)
                                        <p class="fs-5">{{ $online->program->nama ?? '-' }}</p>
                                    @endif

                                </div>

                            </div>
                            @if ($online->bukti_pembayaran)
                                <div class="col-md-12 mb-3">
                                    <h5 class="text-muted">Bukti Pembayaran</h5>
                                    <a href="{{ asset('storage/bukti_pembayaran/' . $online->bukti_pembayaran) }}"
                                        target="_blank">
                                        <img src="{{ asset('storage/bukti_pembayaran/' . $online->bukti_pembayaran) }}"
                                            alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm"
                                            style="max-height: 300px;">
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>
                @endisset

                @if (isset($camp) || isset($offline) || isset($online))
                    <div class="text-center mt-4">
                        <a href="{{ route('tracking.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Cari Transaksi Lain
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
