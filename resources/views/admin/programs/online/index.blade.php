@extends('adminlte::page')

@section('title', 'Program Online')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Program Online</h1>
    <a href="{{ route('admin.online.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Program
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Program Online</h3>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="icon fas fa-check mr-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive table-container">
                        <table id="program-online-table" class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Thumbnail</th>
                                    <th>Nama Program</th>
                                    <th width="15%">Kategori</th>
                                    <th width="12%">Harga</th>
                                    <th width="10%">Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($programs as $program)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration + ($programs->currentPage() - 1) * $programs->perPage() }}</td>
                                        <td class="text-center">
                                            @if ($program->thumbnail)
                                                <img src="{{ asset('storage/' . $program->thumbnail) }}" alt="{{ $program->nama }}" class="img-thumbnail" style="max-height: 60px;">
                                            @else
                                                <span class="text-muted"><i class="fas fa-image fa-2x"></i></span>
                                            @endif
                                        </td>
                                        <td>{{ $program->nama }}</td>
                                        <td>{{ $program->kategori ?? '-' }}</td>
                                        <td class="text-right">Rp {{ number_format($program->harga, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            @if ($program->is_active)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.online.edit', $program->id) }}" class="btn btn-info" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.online.destroy', $program->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-database mr-2"></i> Belum ada data program online.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $programs->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        .img-thumbnail {
            padding: 0.25rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            max-width: 100%;
            height: auto;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }
        .btn-group-sm > .btn, .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }
        .table-container {
            max-height: 400px; /* Adjust this value to set the desired maximum height */
            overflow-y: auto; /* Enable vertical scrolling */
            overflow-x: auto; /* Enable horizontal scrolling for responsiveness */
        }
        .table-container table {
            width: 100%; /* Ensure table takes full width */
            min-width: 600px; /* Prevent table from shrinking too much */
        }
        .table-container thead {
            position: sticky; /* Keep the header fixed while scrolling */
            top: 0;
            z-index: 1;
            background-color: #f8f9fa; /* Match thead-light background */
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Tambahkan efek hover pada tombol aksi
            $('.btn-group .btn').hover(
                function() {
                    $(this).addClass('shadow-sm');
                },
                function() {
                    $(this).removeClass('shadow-sm');
                }
            );

            // Auto-hide alert setelah 5 detik
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        });
    </script>
@stop
