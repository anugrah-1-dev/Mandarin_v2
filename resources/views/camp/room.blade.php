@extends('layouts.app')

@section('content')
@php
    use App\Helpers\RoomDummy as RD;
@endphp

<style>
    .room-box {
        display: inline-block;
        min-width: 60px;
        min-height: 60px;
        padding: 10px;
        margin: 5px;
        color: white;
        border-radius: 10px;
        font-weight: bold;
        font-size: 16px;
        text-align: center;
        line-height: 40px;
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
        user-select: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .room-box:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .room-box.selected {
        border: 3px solid #fff;
        outline: 3px solid #0d6efd;
    }
</style>

<div class="card shadow-sm border-0 mb-4 mt-5" style="width: 83%; margin: auto; border-radius: 20px;">
    <div class="card-body">
        <h5 class="font-weight-bold">Ketersediaan Kamar</h5>
        <p class="text-muted">Warna: Hijau (kosong), Kuning (sebagian), Merah (penuh)</p>
        <p class="text-muted">Warna (Barack): Coklat (terisi 1), Ungu (terisi 2), Orange (terisi 3), Biru (terisi 4)</p>

        {{-- ================= VVIP ================= --}}
        <h3 class="mt-4 text-center fw-bold">VVIP</h3>
        <div class="d-flex justify-content-between" style="max-width: 1000px; gap: 40px;">
            <div class="text-center fw-bold" style="flex: 1; font-size: 18px;">Putri</div>
            <div class="text-center fw-bold" style="flex: 1; font-size: 18px;">Putra</div>
        </div>
        <div class="d-flex justify-content-between flex-wrap" style="gap: 40px; max-width: 1000px;">
            <div style="flex: 1;" class="d-flex flex-wrap justify-content-start">
                @foreach(RD::filter($kamars, 'A', 19, 23) as $kamar)
                    <div class="room-box" data-kamar="{{ $kamar->nomor_kamar }}" style="background-color: {{ RD::warna($kamar) }}">{{ $kamar->nomor_kamar }}</div>
                @endforeach
            </div>
            <div style="flex: 1;" class="d-flex flex-wrap justify-content-end">
                @foreach(RD::filter($kamars, 'A', 24, 28) as $kamar)
                    <div class="room-box" data-kamar="{{ $kamar->nomor_kamar }}" style="background-color: {{ RD::warna($kamar) }}">{{ $kamar->nomor_kamar }}</div>
                @endforeach
            </div>
        </div>

        {{-- ================= VIP ================= --}}
        <h3 class="mt-5 text-center fw-bold">VIP</h3>
        <div class="d-flex flex-wrap justify-content-center" style="gap: 6px; max-width: 1000px; margin: auto;">
            @php
                $vipKamars = collect()
                    ->merge(RD::filter($kamars, 'A', 1, 18))
                    ->merge(RD::filter($kamars, 'A', 29, 46))
                    ->merge(RD::filter($kamars, 'B', 1, 50))
                    ->merge(RD::filter($kamars, 'C', 1, 50))
                    ->push($kamars->firstWhere('nomor_kamar', 'B-12B'))
                    ->push($kamars->firstWhere('nomor_kamar', 'C-12C'))
                    ->unique('nomor_kamar')
                    ->reject(fn($k) => in_array($k->nomor_kamar, ['A-12A', 'A-35']));
            @endphp

            @foreach($vipKamars as $kamar)
                <div class="room-box" data-kamar="{{ $kamar->nomor_kamar }}" style="background-color: {{ RD::warna($kamar) }}">{{ $kamar->nomor_kamar }}</div>
            @endforeach
        </div>

        {{-- ================= Barack ================= --}}
        <h3 class="mt-4 text-center fw-bold">BARACK</h3>
        <div class="d-flex justify-content-between" style="max-width: 1000px; gap: 40px;">
            <div class="text-center fw-bold" style="flex: 1; font-size: 18px;">Putri</div>
            <div class="text-center fw-bold" style="flex: 1; font-size: 18px;">Putra</div>
        </div>
        <div class="d-flex justify-content-between flex-wrap" style="gap: 40px; max-width: 1000px;">
            <div style="flex: 1;">
                <div class="d-flex flex-wrap justify-content-start">
                    @php $kamarPutriBarack = $kamars->firstWhere('nomor_kamar', 'A-12A'); @endphp
                    @if($kamarPutriBarack)
                        <div class="room-box" data-kamar="{{ $kamarPutriBarack->nomor_kamar }}" style="background-color: {{ RD::warna($kamarPutriBarack) }}">{{ $kamarPutriBarack->nomor_kamar }}</div>
                    @endif
                </div>
            </div>
            <div style="flex: 1;">
                <div class="d-flex flex-wrap justify-content-end">
                    @php $kamarPutraBarack = $kamars->firstWhere('nomor_kamar', 'A-35'); @endphp
                    @if($kamarPutraBarack)
                        <div class="room-box" data-kamar="{{ $kamarPutraBarack->nomor_kamar }}" style="background-color: {{ RD::warna($kamarPutraBarack) }}">{{ $kamarPutraBarack->nomor_kamar }}</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Statistik Lingkaran --}}
        <div class="d-flex justify-content-center mt-5 gap-4">
            <div id="circles-1"></div>
            <div id="circles-2"></div>
            <div id="circles-3"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/circles.js@0.0.6/circles.min.js"></script>
<script>
    Circles.create({
        id: 'circles-1',
        radius: 45,
        value: {{ $vvipCount }},
        maxValue: 10,
        width: 8,
        text: '{{ $vvipCount }}/{{ $vvipPenghuni }}',
        colors: ['#e6e6e6', '#FFA726'],
        duration: 400
    });
    Circles.create({
        id: 'circles-2',
        radius: 45,
        value: {{ $vipCount }},
        maxValue: 136,
        width: 8,
        text: '{{ $vipCount }}/{{ $vipPenghuni }}',
        colors: ['#e6e6e6', '#66BB6A'],
        duration: 400
    });
    Circles.create({
        id: 'circles-3',
        radius: 45,
        value: {{ $barackCount }},
        maxValue: 2,
        width: 8,
        text: '{{ $barackCount }}/{{ $barackPenghuni }}',
        colors: ['#e6e6e6', '#EF5350'],
        duration: 400
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.room-box').forEach(box => {
            box.addEventListener('click', () => {
                box.classList.toggle('selected');
                console.log('Dipilih:', box.dataset.kamar);
            });
        });
    });
</script>
@endsection
