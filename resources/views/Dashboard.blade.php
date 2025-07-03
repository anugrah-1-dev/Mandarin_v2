@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard Admin</h1>
@endsection

@section('content')
{{-- Ringkasan --}}
<div class="row mt-4">
    <div class="col-6 col-md-3">
        <x-adminlte-info-box title="Total Pengguna" text="124" icon="fas fa-users" theme="info"/>
    </div>
    <div class="col-6 col-md-3">
        <x-adminlte-info-box title="Kursus Terjual" text="89" icon="fas fa-shopping-cart" theme="success"/>
    </div>
    <div class="col-6 col-md-3">
        <x-adminlte-info-box title="Keuntungan" text="Rp 12.500.000" icon="fas fa-money-bill" theme="warning"/>
    </div>
    <div class="col-6 col-md-3">
        <x-adminlte-info-box title="Media Sosial" text="321 Upload" icon="fas fa-photo-video" theme="primary"/>
    </div>
</div>

{{-- Grafik --}}
<div class="row mt-4">
    <div class="col-md-6">
        <x-adminlte-card title="Keuntungan Bulanan" theme="info" icon="fas fa-chart-line">
            <canvas id="profitChart" height="180"></canvas>
        </x-adminlte-card>
    </div>
    <div class="col-md-6">
        <x-adminlte-card title="Penjualan Kursus" theme="success" icon="fas fa-chart-bar">
            <canvas id="salesChart" height="180"></canvas>
        </x-adminlte-card>
    </div>
</div>


{{-- Galeri Media Sosial --}}
<div class="row mt-4 justify-content-center">
    <div class="col-12">
        <x-adminlte-card title="Galeri Media Sosial" theme="light" icon="fas fa-photo-video">
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
                @for ($i = 1; $i <= 8; $i++)
                    <div class="d-flex flex-column align-items-center m-2">
                        <img src="https://picsum.photos/seed/social{{ $i }}/100/100" class="shadow" style="width: 100px; height: 100px; object-fit: cover; border-radius: 16px;" alt="Media Sosial {{ $i }}">
                        <small class="mt-2 text-muted">
                            @if($i % 2 == 0)
                                <i class="fab fa-instagram"></i> Instagram
                            @else
                                <i class="fab fa-facebook"></i> Facebook
                            @endif
                        </small>
                    </div>
                @endfor
            </div>
        </x-adminlte-card>
    </div>
</div>
@endsection

@section('css')
    <style>
        .gap-2 { gap: 0.5rem; }
        @media (max-width: 768px) {
            canvas {
                max-width: 100%;
            }
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Grafik Keuntungan
        new Chart(document.getElementById('profitChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Keuntungan (Rp)',
                    data: [2000000, 3000000, 2500000, 4000000, 3500000, 4500000],
                    borderColor: '#17a2b8',
                    backgroundColor: 'rgba(23, 162, 184, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            }
        });

        // Grafik Penjualan Kursus
        new Chart(document.getElementById('salesChart'), {
            type: 'bar',
            data: {
                labels: ['Kursus A', 'Kursus B', 'Kursus C', 'Kursus D'],
                datasets: [{
                    label: 'Jumlah Terjual',
                    data: [30, 45, 20, 50],
                    backgroundColor: ['#28a745', '#007bff', '#ffc107', '#dc3545']
                }]
            }
        });


        console.log('Dashboard dimuat.');
    </script>
@endsection
