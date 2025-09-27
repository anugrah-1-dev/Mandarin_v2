@extends('layouts.app')

@section('content')
    <div class="container py-5" id="TrackingTrx">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div id="tracking-section"
                    class="text-center mb-5 text-white d-flex flex-column justify-content-center align-items-center"
                    style="height: 300px; background-size: cover; background-position: center; transition: background-image 1s ease-in-out;">

                    <h1 class="display-5 fw-bold">Tracking Transaksi</h1>
                    <p class="lead">Cek status transaksi dan program Anda dengan mudah</p>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        let images = [
                            "{{ asset('asset/gif/a.gif') }}",
                            "{{ asset('asset/gif/b.gif') }}",
                            "{{ asset('asset/gif/c.gif') }}",

                        ];
                        let index = 0;
                        let section = document.getElementById("tracking-section");

                        // Set awal
                        section.style.backgroundImage = `url('${images[index]}')`;

                        // Ganti tiap 5 detik
                        setInterval(() => {
                            index = (index + 1) % images.length;
                            section.style.backgroundImage = `url('${images[index]}')`;
                        }, 5000);
                    });
                </script>

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
                                    <span
                                        class="badge
                                      @if ($offline->status == 'aktif') bg-success
                                       @elseif($offline->status == 'ditolak') bg-danger
                                       @else bg-warning @endif fs-6">
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
                                    <p class="fs-5">
                                        {{ $offline->transport_id ? $offline->transport->name : '-' }}
                                    </p>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <h5 class="text-muted">Total Harga</h5>
                                    <p class="fs-5">
                                        Rp. {{ number_format($offline->subtotal, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="container mt-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="mb-4 text-start">Ringkasan Pemesanan</h4>

                                            <!-- Tabel Catering -->
                                            @if ($caterings->count() > 0)
                                                <div class="table-responsive mb-4">
                                                    <h5 class="text-muted mb-3 text-start">Catering</h5>
                                                    <table class="table table-bordered table-striped">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th width="50%" class="text-start">Nama Paket</th>
                                                                <th width="20%" class="text-center">Jumlah Porsi</th>
                                                                <th width="30%" class="text-end">Harga</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $totalCatering = 0; @endphp
                                                            @foreach ($caterings as $c)
                                                                @php $totalCatering += $c->harga; @endphp
                                                                <tr>
                                                                    <td class="text-start">
                                                                        {{ $c->cateringPackage->nama_paket ?? 'Paket Tidak Ditemukan' }}
                                                                    </td>
                                                                    <td class="text-center">x{{ $c->jumlah_porsi }}</td>
                                                                    <td class="text-end">Rp
                                                                        {{ number_format($c->harga, 0, ',', '.') }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr class="table-active">
                                                                <td colspan="2" class="text-end fw-bold">Total Catering:</td>
                                                                <td class="text-end fw-bold">Rp
                                                                    {{ number_format($totalCatering, 0, ',', '.') }}</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            @endif

                                            <!-- Tabel Laundry -->
                                            @if ($laundries->count() > 0)
                                                <div class="table-responsive mb-4">
                                                    <h5 class="text-muted mb-3 text-start">Laundry</h5>
                                                    <table class="table table-bordered table-striped">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th width="50%" class="text-start">Nama Paket</th>
                                                                <th width="20%" class="text-center">Jumlah</th>
                                                                <th width="30%" class="text-end">Harga</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $totalLaundry = 0; @endphp
                                                            @foreach ($laundries as $l)
                                                                @php $totalLaundry += $l->harga; @endphp
                                                                <tr>
                                                                    <td class="text-start">
                                                                        {{ $l->laundryPackage->nama_paket ?? 'Paket Tidak Ditemukan' }}
                                                                    </td>
                                                                    <td class="text-center">x{{ $l->jumlah }}</td>
                                                                    <td class="text-end">Rp
                                                                        {{ number_format($l->harga, 0, ',', '.') }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr class="table-active">
                                                                <td colspan="2" class="text-end fw-bold">Total Laundry:
                                                                </td>
                                                                <td class="text-end fw-bold">Rp
                                                                    {{ number_format($totalLaundry, 0, ',', '.') }}</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            @endif

                                            <!-- Tabel Holiday -->
                                            @if ($holidays->count() > 0)
                                                <div class="table-responsive mb-4">
                                                    <h5 class="text-muted mb-3 text-start">Holiday</h5>
                                                    <table class="table table-bordered table-striped">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th width="50%" class="text-start">Nama Paket</th>
                                                                <th width="20%" class="text-center">Jumlah Peserta</th>
                                                                <th width="30%" class="text-end">Harga</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $totalHoliday = 0; @endphp
                                                            @foreach ($holidays as $h)
                                                                @php $totalHoliday += $h->harga; @endphp
                                                                <tr>
                                                                    <td class="text-start">
                                                                        {{ $h->holidayPackage->nama_paket ?? 'Paket Tidak Ditemukan' }}
                                                                    </td>
                                                                    <td class="text-center">x{{ $h->jumlah_peserta }}</td>
                                                                    <td class="text-end">Rp
                                                                        {{ number_format($h->harga, 0, ',', '.') }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr class="table-active">
                                                                <td colspan="2" class="text-end fw-bold">Total Holiday:
                                                                </td>
                                                                <td class="text-end fw-bold">Rp
                                                                    {{ number_format($totalHoliday, 0, ',', '.') }}</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            @endif


                                            <!-- Total Keseluruhan -->
                                            @php
                                                $totalOnline =
                                                    ($totalCatering ?? 0) + ($totalLaundry ?? 0) + ($totalHoliday ?? 0);
                                                $grandTotal = $totalOnline + (isset($offline) ? $offline->subtotal : 0);
                                            @endphp

                                            @if ($grandTotal > 0)
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="card border-primary">
                                                            <div class="card-body text-start">
                                                                <h5 class="card-title text-primary">Total Keseluruhan</h5>
                                                                <h3 class="text-primary">Rp
                                                                    {{ number_format($grandTotal, 0, ',', '.') }}</h3>
                                                                @if ($totalOnline > 0 && isset($offline) && $offline->subtotal > 0)
                                                                    <p class="text-muted mb-0">
                                                                        (Add Ons: Rp
                                                                        {{ number_format($totalOnline, 0, ',', '.') }} +
                                                                        Offline: Rp
                                                                        {{ number_format($offline->subtotal, 0, ',', '.') }})
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if ($cs)
                                    <div class="text-end">
                                        <h6 class="text-muted mb-1">Hubungi CS</h6>
                                        <a href="https://wa.me/+62{{ preg_replace('/[^0-9]/', '', $cs->nomor) }}"
                                            class="btn btn-success btn-sm" target="_blank">
                                            <i class="bi bi-whatsapp"></i> {{ $cs->nama }}
                                        </a>
                                    </div>
                                @endif
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
                                <span
                                    class="badge
                                      @if ($online->status == 'aktif') bg-success
                                       @elseif($online->status == 'ditolak') bg-danger
                                       @else bg-warning @endif fs-6">
                                    {{ ucfirst($online->status) }}
                                </span>
                            </div>

                            <div class="col-md-12 mb-3">
                                <h5 class="text-muted">Program</h5>
                                @if ($online)
                                    <p class="fs-5">{{ $online->program->nama ?? '-' }}</p>
                                @endif

                            </div>

                            <div class="col-md-12 mb-3">
                                <h5 class="text-muted">Total Harga</h5>
                                <p class="fs-5">
                                    Rp. {{ number_format($online->subtotal, 0, ',', '.') }}
                                </p>
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
