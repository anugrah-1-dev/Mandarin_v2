@extends('adminlte::page')

@section('title', 'Manajemen Kamar')

@section('content_header')
    <h1 class="text-center font-weight-bold">Manajemen Kamar</h1>
@stop

@section('content')
@php
    use App\Helpers\RoomDummy as RD;
@endphp

<style>
    :root {
        --primary-color: #3498db;
        --success-color: #28a745;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
        --barack-brown: #8B4513;
        --barack-purple: #800080;
        --barack-orange: #FFA500;
        --barack-blue: #007bff;
    }

    .main-container {
        width: 98%;
        max-width: 1600px;
        margin: 0 auto;
    }

    .dashboard-card {
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: none;
        overflow: hidden;
    }

    .card-header-custom {
        background: linear-gradient(135deg, #3498db, #2c3e50);
        color: white;
        border-radius: 20px 20px 0 0 !important;
        padding: 20px;
    }

    .room-section {
        background-color: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        border: 1px solid #e9ecef;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 25px;
        color: #2c3e50;
        text-align: center;
        position: relative;
        padding-bottom: 10px;
    }

    .section-title:after {
        content: "";
        display: block;
        width: 100px;
        height: 4px;
        background: var(--primary-color);
        margin: 15px auto 0;
        border-radius: 2px;
    }

    .gender-column {
        padding: 20px;
        background-color: #f8fafc;
        border-radius: 12px;
        margin-bottom: 20px;
        height: 100%;
    }

    .gender-title {
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: #34495e;
        text-align: center;
        padding: 10px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border-left: 5px solid var(--primary-color);
    }

    .room-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 15px;
        padding: 10px;
    }

    .room-card {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100px;
        color: white;
        border-radius: 12px;
        font-weight: bold;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        user-select: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .room-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .room-card.selected {
        border: 3px solid white;
        outline: 3px solid var(--primary-color);
        transform: scale(1.05);
        z-index: 10;
    }

    .room-number {
        font-size: 1.3rem;
        z-index: 2;
    }

    .room-status {
        font-size: 0.8rem;
        margin-top: 5px;
        z-index: 2;
        text-transform: capitalize;
    }

    .room-card:after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 100%);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .room-card:hover:after {
        opacity: 1;
    }

    /* Room Status Colors */
    .room-empty { background-color: var(--success-color); }
    .room-partial { background-color: var(--warning-color); }
    .room-full { background-color: var(--danger-color); }
    .room-barack-brown { background-color: var(--barack-brown); }
    .room-barack-purple { background-color: var(--barack-purple); }
    .room-barack-orange { background-color: var(--barack-orange); }
    .room-barack-blue { background-color: var(--barack-blue); }

    .legend-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        margin: 30px 0;
        gap: 15px;
        padding: 20px;
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .legend-item {
        display: flex;
        align-items: center;
        margin: 0 10px;
        font-size: 1rem;
        padding: 8px 15px;
        background-color: #f8f9fa;
        border-radius: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        margin-right: 10px;
        border: 2px solid white;
    }

    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 15px 20px;
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .search-box {
        width: 300px;
    }

    @media (max-width: 768px) {
        .room-grid {
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        }

        .room-card {
            height: 80px;
            font-size: 1rem;
        }

        .search-box {
            width: 100%;
            margin-bottom: 15px;
        }

        .action-bar {
            flex-direction: column;
        }
    }
</style>

<div class="main-container">
    <div class="dashboard-card">
        <div class="card-header-custom">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Dashboard Kamar</h3>
                <div class="card-tools">
                    <span class="badge badge-light">Total Kamar: {{ $rooms->count() }}</span>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="action-bar">
                <x-adminlte-button label="Tambah Kamar" theme="primary" icon="fas fa-plus"
                    data-toggle="modal" data-target="#createRoomModal" class="btn-lg font-weight-bold" />

                <x-adminlte-input name="search" placeholder="Cari kamar..." class="search-box">
                    <x-slot name="appendSlot">
                        <x-adminlte-button theme="outline-primary" icon="fas fa-search"/>
                    </x-slot>
                </x-adminlte-input>
            </div>

            <div class="legend-container">
                <div class="legend-item">
                    <div class="legend-color" style="background-color: var(--success-color);"></div>
                    <span>Kosong</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: var(--warning-color);"></div>
                    <span>Sebagian Terisi</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: var(--danger-color);"></div>
                    <span>Penuh</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: var(--barack-brown);"></div>
                    <span>Barack Coklat</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: var(--barack-purple);"></div>
                    <span>Barack Ungu</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: var(--barack-orange);"></div>
                    <span>Barack Orange</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: var(--barack-blue);"></div>
                    <span>Barack Biru</span>
                </div>
            </div>

            {{-- ================= VVIP SECTION ================= --}}
            <div class="room-section">
                <h3 class="section-title">Kamar VVIP</h3>

                <div class="row">
                    <div class="col-md-6">
                        <div class="gender-column">
                            <div class="gender-title">Putri</div>
                            <div class="room-grid">
                                @foreach(RD::filter($rooms, 'A', 19, 23) as $kamar)
                                    @if($kamar->nomor_kamar != 'A-12A')
                                        <div class="room-card {{ RD::getStatusClass($kamar) }}"
                                             data-kamar="{{ $kamar->nomor_kamar }}">
                                            <span class="room-number">{{ $kamar->nomor_kamar }}</span>
                                            <span class="room-status">{{ RD::getStatusText($kamar) }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="gender-column">
                            <div class="gender-title">Putra</div>
                            <div class="room-grid">
                                @foreach(RD::filter($rooms, 'A', 24, 28) as $kamar)
                                    <div class="room-card {{ RD::getStatusClass($kamar) }}"
                                         data-kamar="{{ $kamar->nomor_kamar }}">
                                        <span class="room-number">{{ $kamar->nomor_kamar }}</span>
                                        <span class="room-status">{{ RD::getStatusText($kamar) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= VIP SECTION ================= --}}
            <div class="room-section">
                <h3 class="section-title">Kamar VIP</h3>

                <div class="row">
                    <div class="col-md-6">
                        <div class="gender-column">
                            <div class="gender-title">Putri</div>
                            <div class="room-grid">
                                @php
                                    $vipPutri = collect()
                                    ->merge(RD::filter($rooms, 'A', 1, 18))
                                    ->merge(RD::filter($rooms, 'B', 1, 25))
                                    ->merge(RD::filter($rooms, 'C', 1, 25))
                                    ->reject(function($kamar) {
                                        return $kamar->nomor_kamar == 'A-12A';
                                    });
                                @endphp
                                @foreach($vipPutri->unique('nomor_kamar') as $kamar)
                                    <div class="room-card {{ RD::getStatusClass($kamar) }}"
                                         data-kamar="{{ $kamar->nomor_kamar }}">
                                        <span class="room-number">{{ $kamar->nomor_kamar }}</span>
                                        <span class="room-status">{{ RD::getStatusText($kamar) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="gender-column">
                            <div class="gender-title">Putra</div>
                            <div class="room-grid">
                                @php
                                    $vipPutra = collect()
                                    ->merge(RD::filter($rooms, 'A', 29, 46, 'putra')->reject(fn($k) => $k->nomor_kamar == 'A-35' || ($k->nomor_kamar >= 'A-24' && $k->nomor_kamar <= 'A-28')))
                                    ->merge(RD::filter($rooms, 'B', 26, 50, 'putra'))
                                    ->merge(RD::filter($rooms, 'C', 26, 50, 'putra'));
                                @endphp
                                @foreach($vipPutra->unique('nomor_kamar') as $kamar)
                                    <div class="room-card {{ RD::getStatusClass($kamar) }}"
                                         data-kamar="{{ $kamar->nomor_kamar }}">
                                        <span class="room-number">{{ $kamar->nomor_kamar }}</span>
                                        <span class="room-status">{{ RD::getStatusText($kamar) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= BARACK SECTION ================= --}}
            <div class="room-section">
                <h3 class="section-title">Kamar Barack</h3>

                <div class="row">
                    <div class="col-md-6">
                        <div class="gender-column">
                            <div class="gender-title">Putri</div>
                            <div class="room-grid">
                                @php $kamarPutriBarack = $rooms->firstWhere('nomor_kamar', 'A-12A'); @endphp
                                @if($kamarPutriBarack)
                                    <div class="room-card {{ RD::getStatusClass($kamarPutriBarack) }}"
                                         data-kamar="{{ $kamarPutriBarack->nomor_kamar }}">
                                        <span class="room-number">{{ $kamarPutriBarack->nomor_kamar }}</span>
                                        <span class="room-status">{{ RD::getStatusText($kamarPutriBarack) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="gender-column">
                            <div class="gender-title">Putra</div>
                            <div class="room-grid">
                                @php $kamarPutraBarack = $rooms->firstWhere('nomor_kamar', 'A-35'); @endphp
                                @if($kamarPutraBarack)
                                    <div class="room-card {{ RD::getStatusClass($kamarPutraBarack) }}"
                                         data-kamar="{{ $kamarPutraBarack->nomor_kamar }}">
                                        <span class="room-number">{{ $kamarPutraBarack->nomor_kamar }}</span>
                                        <span class="room-status">{{ RD::getStatusText($kamarPutraBarack) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Kamar --}}
<x-adminlte-modal id="createRoomModal" title="Tambah Kamar Baru" theme="primary" icon="fas fa-bed" size="lg">
    <form action="{{ route('admin.rooms.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-select name="program_camp_id" label="Program Camp" required>
                    @foreach($programCamps as $program)
                        <option value="{{ $program->id }}">{{ $program->nama }}</option>
                    @endforeach
                </x-adminlte-select>
                <x-adminlte-input name="nama" label="Nama Kamar" placeholder="Contoh: Kamar A1" required />
                <x-adminlte-input name="nomor_kamar" label="Nomor Kamar" placeholder="Contoh: A1" required />
            </div>
            <div class="col-md-6">
                <x-adminlte-select name="gender" label="Gender" required>
                    <option value="putra">Putra</option>
                    <option value="putri">Putri</option>
                </x-adminlte-select>
                <x-adminlte-select name="kategori" label="Kategori" required>
                    <option value="VVIP">VVIP</option>
                    <option value="VIP">VIP</option>
                    <option value="Barack">Barack</option>
                </x-adminlte-select>
                <x-adminlte-input name="kapasitas" label="Kapasitas (1 - 6)" type="number" min="1" max="6" required />
            </div>
        </div>

        <x-slot name="footerSlot">
            <x-adminlte-button theme="secondary" label="Batal" data-dismiss="modal" class="btn-lg" />
            <x-adminlte-button theme="primary" label="Simpan" type="submit" class="btn-lg" />
        </x-slot>
    </form>
</x-adminlte-modal>

{{-- Interaksi JS --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Room selection
        document.querySelectorAll('.room-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.room-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');

                // You can add room details display logic here
                const roomNumber = this.getAttribute('data-kamar');
                console.log('Kamar dipilih:', roomNumber);
            });
        });

        // Search functionality
        const searchInput = document.querySelector('input[name="search"]');
        const searchButton = searchInput.nextElementSibling.querySelector('button');

        searchButton.addEventListener('click', function() {
            const searchTerm = searchInput.value.toLowerCase();
            const rooms = document.querySelectorAll('.room-card');

            rooms.forEach(room => {
                const roomNumber = room.getAttribute('data-kamar').toLowerCase();
                if (roomNumber.includes(searchTerm)) {
                    room.style.display = 'flex';
                    room.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    room.classList.add('selected');
                    setTimeout(() => room.classList.remove('selected'), 2000);
                } else {
                    room.style.display = 'none';
                }
            });
        });

        // Press Enter to search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchButton.click();
            }
        });
    });
</script>
@stop
