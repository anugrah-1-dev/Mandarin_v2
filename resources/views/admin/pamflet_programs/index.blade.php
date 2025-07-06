@extends('adminlte::page')

@section('title', 'Pamflet Program')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Pamflet Program</h1>
        <a href="{{ route('admin.pamflet_programs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Program
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            <div class="mb-4">
                <form action="{{ route('admin.pamflet_programs.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan judul program..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-custom-header">
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Keunggulan</th>
                            <th style="width: 150px;">Gambar</th>
                            <th>Status</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programs as $program)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $program->judul }}</td>
                                <td>{{ Str::limit($program->deskripsi, 50, '...') }}</td>
                                <td>{{ Str::limit($program->keunggulan, 50, '...') }}</td>
                                <td>
                                    <img src="{{ asset('uploads/programs/' . $program->gambar) }}" alt="{{ $program->judul }}" class="img-thumbnail" width="100">
                                </td>
                                <td>
                                    @if($program->status === 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.pamflet_programs.edit', $program->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.pamflet_programs.destroy', $program->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus program ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data program.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@stop

@push('css')
    <style>
        .table-custom-header {
            background-color: #3c8dbc;
            color: white;
        }
    </style>
@endpush
