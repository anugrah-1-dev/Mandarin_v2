@extends('adminlte::page')

@section('title', 'Program Offline')

@section('content_header')
    <h1>Program Offline</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Program Offline</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.offline.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Program
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="program-offline-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Thumbnail</th>
                                    <th>Nama Program</th>
                                    <th>Harga</th>
                                    <th>Jadwal</th>
                                    <th>Kuota</th>
                                    <th>Status</th>
                                    <th style="width: 120px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($programs as $program)
                                    <tr>
                                        <td>{{ $loop->iteration + ($programs->currentPage() - 1) * $programs->perPage() }}</td>
                                        <td>
                                            @if ($program->thumbnail)
                                                <img src="{{ asset('storage/' . $program->thumbnail) }}" alt="{{ $program->nama }}" width="100">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ $program->nama }}</td>
                                        <td>Rp {{ number_format($program->harga, 0, ',', '.') }}</td>
                                        <td>
                                            {{ $program->jadwal_mulai->format('d M Y') }} -
                                            {{ $program->jadwal_selesai->format('d M Y') }}
                                        </td>
                                        <td>{{ $program->kuota }}</td>
                                        <td>
                                            @if ($program->is_active)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.offline.edit', $program->id) }}" class="btn btn-info btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.offline.destroy', $program->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Belum ada data program offline.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $programs->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@stop
