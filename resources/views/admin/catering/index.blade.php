@extends('adminlte::page')

@section('title', 'Catering Packages')

@section('content_header')
    <h1 class="m-0 text-dark">Catering Packages Management</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                    <h3 class="m-0">Daftar Catering Packages</h3>
                    <a href="{{ route('admin.catering.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah catering
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
                                    {{-- <th>Jam Pengantaran</th> --}}
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="cateringTable">
                                @foreach ($caterings as $catering)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $catering->nama_paket }}</td>
                                        <td>Rp {{ number_format($catering->harga, 0, ',', '.') }}</td>
                                        <td>{{ $catering->periode }} Hari</td>
                                        {{-- <td>{{ $catering->jam_pengantaran ?? '-' }}</td> --}}
                                        <td>
                                            <span
                                                class="badge badge-{{ $catering->status === 'aktif' ? 'success' : 'secondary' }}">
                                                {{ $catering->status === 'aktif' ? 'Aktif' : 'Non-Aktif' }}
                                            </span>

                                        </td>
                                        <td class="text-center">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.catering.edit', $catering->id) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('admin.catering.destroy', $catering->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus paket catering ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                                @if ($caterings->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data paket catering</td>
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
        function deleteCatering(id) {
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
                    $.ajax({
                        url: `/admin/services/catering/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function(err) {
                            Swal.fire('Error', 'Gagal menghapus data', 'error');
                        }
                    });
                }
            });
        }

        $('#cateringModal').on('hidden.bs.modal', function() {
            $('#cateringForm')[0].reset();
        });
    </script>
@stop
