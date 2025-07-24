    @extends('adminlte::page')

    @section('title', 'Manajemen Kamar')

    @section('content_header')
        <h1 class="text-center font-weight-bold">Manajemen Kamar</h1>
    @stop

    @section('content')
        @php
            use App\Helpers\RoomDummy as RD;
        @endphp

        @push('css')
            <link rel="stylesheet" href="{{ asset('css/room.css') }}">
        @endpush

    @section('meta')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endsection


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

                    <x-adminlte-input name="search" placeholder="Cari kamar..." class="search-box">
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="outline-primary" icon="fas fa-search" />
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

                </div>

                {{-- ================= VVIP SECTION ================= --}}
                <div class="room-section">
                    <h3 class="section-title">Kamar VVIP</h3>

                    <div class="row">
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
                                                data-penghuni="{{ $kamar->penghuni }}" onclick="openEditModal(this)">
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
                                    @foreach (RD::filter($rooms, 'A', 24, 28) as $kamar)
                                        <div class="room-card {{ RD::getStatusClass($kamar) }}"
                                            data-id="{{ $kamar->id }}" data-nama="{{ $kamar->nomor_kamar }}"
                                            data-kamar="{{ $kamar->nomor_kamar }}" data-gender="{{ $kamar->gender }}"
                                            data-kategori="{{ $kamar->kategori }}"
                                            data-kapasitas="{{ $kamar->kapasitas }}"
                                            data-penghuni="{{ $kamar->penghuni }}" onclick="openEditModal(this)">
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
                                            ->reject(function ($kamar) {
                                                return $kamar->nomor_kamar === 'A-12A' ||
                                                    strtoupper($kamar->kategori) !== 'VIP';
                                            });
                                    @endphp

                                    @foreach ($vipPutri->unique('nomor_kamar') as $kamar)
                                        <div class="room-card {{ RD::getStatusClass($kamar) }}"
                                            data-id="{{ $kamar->id }}" data-nama="{{ $kamar->nomor_kamar }}"
                                            data-kamar="{{ $kamar->nomor_kamar }}" data-gender="{{ $kamar->gender }}"
                                            data-kategori="{{ $kamar->kategori }}"
                                            data-kapasitas="{{ $kamar->kapasitas }}"
                                            data-penghuni="{{ $kamar->penghuni }}" onclick="openEditModal(this)">
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
                                            ->merge(
                                                RD::filter($rooms, 'A', 29, 46, 'putra')->reject(function ($k) {
                                                    return $k->nomor_kamar === 'A-35' ||
                                                        ($k->nomor_kamar >= 'A-24' && $k->nomor_kamar <= 'A-28') ||
                                                        strtoupper($k->kategori) !== 'VIP';
                                                }),
                                            )
                                            ->merge(
                                                RD::filter($rooms, 'B', 26, 50, 'putra')->reject(
                                                    fn($k) => strtoupper($k->kategori) !== 'VIP',
                                                ),
                                            )
                                            ->merge(
                                                RD::filter($rooms, 'C', 26, 50, 'putra')->reject(
                                                    fn($k) => strtoupper($k->kategori) !== 'VIP',
                                                ),
                                            );
                                    @endphp

                                    @foreach ($vipPutra->unique('nomor_kamar') as $kamar)
                                        <div class="room-card {{ RD::getStatusClass($kamar) }}"
                                            data-id="{{ $kamar->id }}" data-nama="{{ $kamar->nomor_kamar }}"
                                            data-kamar="{{ $kamar->nomor_kamar }}"
                                            data-gender="{{ $kamar->gender }}"
                                            data-kategori="{{ $kamar->kategori }}"
                                            data-kapasitas="{{ $kamar->kapasitas }}"
                                            data-penghuni="{{ $kamar->penghuni }}" onclick="openEditModal(this)">
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
                                    @if ($kamarPutriBarack)
                                        <div class="room-card {{ RD::getStatusClass($kamarPutriBarack) }}"
                                            data-id="{{ $kamarPutriBarack->id }}"
                                            data-nama="{{ $kamarPutriBarack->nomor_kamar }}"
                                            data-kamar="{{ $kamarPutriBarack->nomor_kamar }}"
                                            data-gender="{{ $kamarPutriBarack->gender }}"
                                            data-kategori="{{ $kamarPutriBarack->kategori }}"
                                            data-kapasitas="{{ $kamarPutriBarack->kapasitas }}"
                                            data-penghuni="{{ $kamarPutriBarack->penghuni }}"
                                            onclick="openEditModal(this)">

                                            <span class="room-number">{{ $kamarPutriBarack->nomor_kamar }}</span>
                                            <span
                                                class="room-status">{{ RD::getStatusText($kamarPutriBarack) }}</span>
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
                                    @if ($kamarPutraBarack)
                                        <div class="room-card {{ RD::getStatusClass($kamarPutraBarack) }}"
                                            data-id="{{ $kamarPutraBarack->id }}"
                                            data-nama="{{ $kamarPutraBarack->nomor_kamar }}"
                                            data-kamar="{{ $kamarPutraBarack->nomor_kamar }}"
                                            data-gender="{{ $kamarPutraBarack->gender }}"
                                            data-kategori="{{ $kamarPutraBarack->kategori }}"
                                            data-kapasitas="{{ $kamarPutraBarack->kapasitas }}"
                                            data-penghuni="{{ $kamarPutraBarack->penghuni }}"
                                            onclick="openEditModal(this)">
                                            <span class="room-number">{{ $kamarPutraBarack->nomor_kamar }}</span>
                                            <span
                                                class="room-status">{{ RD::getStatusText($kamarPutraBarack) }}</span>
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

    <!-- Modal Edit Room -->
    <div class="modal fade" id="roomModal" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomModalLabel">Edit Kamar</h5>
                </div>
                <div class="modal-body">
                    <form id="roomEditForm">
                        <input type="hidden" id="modalRoomId" name="id">

                        <div class="mb-3">
                            <label for="modalRoomNama" class="form-label">Nomor Kamar</label>
                            <input type="text" class="form-control" id="modalRoomNama" name="nomor_kamar"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label for="modalRoomGender" class="form-label">Gender</label>
                            <select class="form-select" id="modalRoomGender" name="gender">
                                <option value="putra">PUTRA</option>
                                <option value="putri">PUTRI</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="modalRoomKategori" class="form-label">Kategori</label>
                            <select class="form-select" id="modalRoomKategori" name="kategori">
                                <option value="vvip">VVIP</option>
                                <option value="vip">VIP</option>
                                <option value="barack">BARACK</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="modalRoomKapasitas" class="form-label">Kapasitas</label>
                            <input type="number" class="form-control" id="modalRoomKapasitas" name="kapasitas"
                                min="1">
                        </div>

                        <div class="mb-3">
                            <label for="modalRoomPenghuni" class="form-label">Penghuni</label>
                            <input type="number" class="form-control" id="modalRoomPenghuni" name="penghuni"
                                min="0">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="saveRoomChanges()">Simpan
                        Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


    {{-- Interaksi JS --}}
    <script>
        document.querySelectorAll('.room-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.room-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');

                const roomNumber = this.getAttribute('data-kamar');
                console.log('Kamar dipilih:', roomNumber);

                // 🔥 Tambahkan ini agar modal terbuka
                openEditModal(this);
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
                    room.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
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
    </script>

    <script>
        function openEditModal(el) {
            const id = el.dataset.id;
            const nama = el.dataset.nama;
            const gender = el.dataset.gender;
            const kategori = el.dataset.kategori;
            const kapasitas = el.dataset.kapasitas;
            const penghuni = el.dataset.penghuni;
            document.getElementById('modalRoomId').value = id;
            document.getElementById('modalRoomNama').value = nama;
            document.getElementById('modalRoomGender').value = gender;
            document.getElementById('modalRoomKategori').value = kategori;
            document.getElementById('modalRoomKapasitas').value = kapasitas;
            document.getElementById('modalRoomPenghuni').value = penghuni;

            const modal = new bootstrap.Modal(document.getElementById('roomModal'));
            modal.show();


        }

        function saveRoomChanges() {
            const id = $('#modalRoomId').val();
            const formData = $('#roomEditForm').serialize() + '&_method=PUT';

            $.ajax({
                url: `/admin/rooms/${id}`, // Sesuai route kamu
                type: 'POST', // tetap POST, Laravel paham lewat _method
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success) {
                        alert('Perubahan berhasil disimpan');
                        location.reload();
                    } else {
                        alert('Gagal menyimpan perubahan: ' + (data.message || 'Tidak ada pesan error'));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan perubahan: ' + error);
                }
            });
        }
    </script>
@stop
