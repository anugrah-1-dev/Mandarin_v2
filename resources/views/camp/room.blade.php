@extends('layouts.app')
@section('content')

<div class="container py-5">
    <h2 class="text-center mb-4">Pilih Kamar Camp</h2>

          @php
            use App\Helpers\RoomDummy as RD;
        @endphp


    {{-- <form action="{{ route('camp.pendaftaran.store') }}" method="POST">
        @csrf --}}


        {{-- === Hidden Input untuk Kamar Terpilih === --}}
        <input type="hidden" name="nama_kamar" id="inputNamaKamar">
        <input type="hidden" name="kamar_id" id="inputKamarId">

        {{-- === Tampilan Kamar yang Terpilih === --}}
        <div id="selectedRoomInfo" class="alert alert-info d-none">
            Kamar terpilih: <strong id="selectedRoomName"></strong>
        </div>

        {{-- ===================== VVIP ===================== --}}
        <div class="room-section mt-5">
            <h3 class="section-title">Kamar VVIP</h3>
            <div class="row">
                {{-- Putri --}}
                <div class="col-md-6">
                    <div class="gender-column">
                        <div class="gender-title">Putri</div>
                        <div class="room-grid">
                            @foreach (RD::filter($rooms, 'A', 19, 23) as $kamar)
                                @if ($kamar->nomor_kamar != 'A-12A')
                                    <div class="room-card {{ RD::getStatusClass($kamar) }}"
                                        data-id="{{ $kamar->id }}" data-nama="{{ $kamar->nomor_kamar }}"
                                        data-kamar="{{ $kamar->nomor_kamar }}"
                                        data-gender="{{ $kamar->gender }}"
                                        data-kategori="{{ $kamar->kategori }}"
                                        data-kapasitas="{{ $kamar->kapasitas }}"
                                        data-penghuni="{{ $kamar->penghuni }}"
                                        onclick="selectRoom(this)">
                                        <span class="room-number">{{ $kamar->nomor_kamar }}</span>
                                        <span class="room-status">{{ RD::getStatusText($kamar) }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Putra --}}
                <div class="col-md-6">
                    <div class="gender-column">
                        <div class="gender-title">Putra</div>
                        <div class="room-grid">
                            @foreach (RD::filter($rooms, 'A', 24, 28) as $kamar)
                                <div class="room-card {{ RD::getStatusClass($kamar) }}"
                                    data-id="{{ $kamar->id }}" data-nama="{{ $kamar->nomor_kamar }}"
                                    data-kamar="{{ $kamar->nomor_kamar }}"
                                    data-gender="{{ $kamar->gender }}"
                                    data-kategori="{{ $kamar->kategori }}"
                                    data-kapasitas="{{ $kamar->kapasitas }}"
                                    data-penghuni="{{ $kamar->penghuni }}"
                                    onclick="selectRoom(this)">
                                    <span class="room-number">{{ $kamar->nomor_kamar }}</span>
                                    <span class="room-status">{{ RD::getStatusText($kamar) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== VIP ===================== --}}
        <div class="room-section mt-5">
            <h3 class="section-title">Kamar VIP</h3>
            <div class="row">
                {{-- Putri --}}
                <div class="col-md-6">
                    <div class="gender-column">
                        <div class="gender-title">Putri</div>
                        <div class="room-grid">
                            @php
                                $vipPutri = collect()
                                    ->merge(RD::filter($rooms, 'A', 1, 18))
                                    ->merge(RD::filter($rooms, 'B', 1, 25))
                                    ->merge(RD::filter($rooms, 'C', 1, 25))
                                    ->reject(fn($k) => $k->nomor_kamar === 'A-12A' || strtoupper($k->kategori) !== 'VIP');
                            @endphp
                            @foreach ($vipPutri->unique('nomor_kamar') as $kamar)
                                <div class="room-card {{ RD::getStatusClass($kamar) }}"
                                    data-id="{{ $kamar->id }}" data-nama="{{ $kamar->nomor_kamar }}"
                                    data-kamar="{{ $kamar->nomor_kamar }}"
                                    data-gender="{{ $kamar->gender }}"
                                    data-kategori="{{ $kamar->kategori }}"
                                    data-kapasitas="{{ $kamar->kapasitas }}"
                                    data-penghuni="{{ $kamar->penghuni }}"
                                    onclick="selectRoom(this)">
                                    <span class="room-number">{{ $kamar->nomor_kamar }}</span>
                                    <span class="room-status">{{ RD::getStatusText($kamar) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Putra --}}
                <div class="col-md-6">
                    <div class="gender-column">
                        <div class="gender-title">Putra</div>
                        <div class="room-grid">
                            @php
                                $vipPutra = collect()
                                    ->merge(
                                        RD::filter($rooms, 'A', 29, 46, 'putra')->reject(fn($k) =>
                                            $k->nomor_kamar === 'A-35' ||
                                            ($k->nomor_kamar >= 'A-24' && $k->nomor_kamar <= 'A-28') ||
                                            strtoupper($k->kategori) !== 'VIP'
                                        )
                                    )
                                    ->merge(RD::filter($rooms, 'B', 26, 50, 'putra')->reject(fn($k) => strtoupper($k->kategori) !== 'VIP'))
                                    ->merge(RD::filter($rooms, 'C', 26, 50, 'putra')->reject(fn($k) => strtoupper($k->kategori) !== 'VIP'));
                            @endphp
                            @foreach ($vipPutra->unique('nomor_kamar') as $kamar)
                                <div class="room-card {{ RD::getStatusClass($kamar) }}"
                                    data-id="{{ $kamar->id }}" data-nama="{{ $kamar->nomor_kamar }}"
                                    data-kamar="{{ $kamar->nomor_kamar }}"
                                    data-gender="{{ $kamar->gender }}"
                                    data-kategori="{{ $kamar->kategori }}"
                                    data-kapasitas="{{ $kamar->kapasitas }}"
                                    data-penghuni="{{ $kamar->penghuni }}"
                                    onclick="selectRoom(this)">
                                    <span class="room-number">{{ $kamar->nomor_kamar }}</span>
                                    <span class="room-status">{{ RD::getStatusText($kamar) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== BARACK ===================== --}}
        <div class="room-section mt-5">
            <h3 class="section-title">Kamar Barack</h3>
            <div class="row">
                {{-- Putri --}}
                <div class="col-md-6">
                    <div class="gender-column">
                        <div class="gender-title">Putri</div>
                        <div class="room-grid">
                            @php $kamarPutriBarack = $rooms->firstWhere('nomor_kamar', 'A-12A'); @endphp
                            @if ($kamarPutriBarack)
                                <div class="room-card {{ RD::getStatusClass($kamarPutriBarack) }}"
                                    data-id="{{ $kamarPutriBarack->id }}"
                                    data-nama="{{ $kamarPutriBarack->nomor_kamar }}"
                                    data-kamar="{{ $kamarPutriBarack->nomor_kamar }}"
                                    data-gender="{{ $kamarPutriBarack->gender }}"
                                    data-kategori="{{ $kamarPutriBarack->kategori }}"
                                    data-kapasitas="{{ $kamarPutriBarack->kapasitas }}"
                                    data-penghuni="{{ $kamarPutriBarack->penghuni }}"
                                    onclick="selectRoom(this)">
                                    <span class="room-number">{{ $kamarPutriBarack->nomor_kamar }}</span>
                                    <span class="room-status">{{ RD::getStatusText($kamarPutriBarack) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Putra --}}
                <div class="col-md-6">
                    <div class="gender-column">
                        <div class="gender-title">Putra</div>
                        <div class="room-grid">
                            @php $kamarPutraBarack = $rooms->firstWhere('nomor_kamar', 'A-35'); @endphp
                            @if ($kamarPutraBarack)
                                <div class="room-card {{ RD::getStatusClass($kamarPutraBarack) }}"
                                    data-id="{{ $kamarPutraBarack->id }}"
                                    data-nama="{{ $kamarPutraBarack->nomor_kamar }}"
                                    data-kamar="{{ $kamarPutraBarack->nomor_kamar }}"
                                    data-gender="{{ $kamarPutraBarack->gender }}"
                                    data-kategori="{{ $kamarPutraBarack->kategori }}"
                                    data-kapasitas="{{ $kamarPutraBarack->kapasitas }}"
                                    data-penghuni="{{ $kamarPutraBarack->penghuni }}"
                                    onclick="selectRoom(this)">
                                    <span class="room-number">{{ $kamarPutraBarack->nomor_kamar }}</span>
                                    <span class="room-status">{{ RD::getStatusText($kamarPutraBarack) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOMBOL DAFTAR --}}
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-5">Daftar Sekarang</button>
        </div>
    </form>
</div>

{{-- SCRIPT PILIH KAMAR --}}
<script>
    function selectRoom(element) {
        const kamarId = element.getAttribute('data-id');
        const namaKamar = element.getAttribute('data-nama');

        document.getElementById('inputKamarId').value = kamarId;
        document.getElementById('inputNamaKamar').value = namaKamar;

        document.getElementById('selectedRoomName').textContent = namaKamar;
        document.getElementById('selectedRoomInfo').classList.remove('d-none');

        document.querySelectorAll('.room-card').forEach(card => card.classList.remove('selected-room'));
        element.classList.add('selected-room');
    }
</script>

{{-- CSS PILIHAN --}}
<style>
    .room-card.selected-room {
        border: 3px solid #007bff;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
    }
</style>

@endsection
