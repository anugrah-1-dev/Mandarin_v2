@extends('adminlte::page')

@section('title', 'Laundry Packages')

@section('content_header')
    <h1 class="m-0 text-dark">Laundry Packages Management</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                    <h3 class="m-0">Daftar Laundry Packages</h3>
                    <a href="{{ route('admin.laundry.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Laundry
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead class="bg-lightblue text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Paket</th>
                                    <th>Harga</th>
                                    <th>Periode</th>
                                    {{-- <th>Tanggal Penjemputan</th> --}}
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="laundryTable">
                                @foreach ($laundries as $laundry)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $laundry->nama_paket }}</td>
                                        <td>Rp {{ number_format($laundry->harga, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ ucfirst($laundry->periode) }}
                                            </span>
                                        </td>
                                        {{-- <td>
                                            @if ($laundry->tanggal_penjemputan)
                                                {{ date('d M Y', strtotime($laundry->tanggal_penjemputan)) }}
                                            @else
                                                <span class="text-muted">Belum diatur</span>
                                            @endif
                                        </td> --}}
                                        <td>
                                            <span
                                                class="badge badge-{{ $laundry->status === 'aktif' ? 'success' : 'secondary' }}">
                                                {{ $laundry->status === 'aktif' ? 'Aktif' : 'Non-Aktif' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.laundry.edit', $laundry->id) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('admin.laundry.destroy', $laundry->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus paket laundry ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <!-- Tombol Hapus -->
                                                <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                                    onclick="deleteLaundry({{ $laundry->id }}, '{{ route('admin.laundry.destroy', $laundry->id) }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                                @if ($laundries->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data paket laundry</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('css')
    <style>
        .table th,
        .table td {
            vertical-align: middle;
        }

        .badge {
            font-size: 0.85em;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function deleteLaundry(id, url) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus data',
                        text: 'Mohon tunggu...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.ajax({
                        url: url, // gunakan URL yang di-pass dari Blade
                        type: 'POST', // pakai POST karena method spoofing
                        data: {
                            _method: 'DELETE', // spoofing DELETE method
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            Swal.fire('Terhapus!', res.message, 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire('Error', 'Gagal menghapus data', 'error');
                        }
                    });
                }
            });
        }


        // Reset form saat modal ditutup
        $('#laundryModal').on('hidden.bs.modal', function() {
            $('#laundryForm')[0].reset();
        });

        // Set tanggal minimal ke hari ini
        var tglEl = document.getElementById('tanggal_penjemputan');
        if (tglEl) tglEl.min = new Date().toISOString().split("T")[0];
    </script>
@stop
