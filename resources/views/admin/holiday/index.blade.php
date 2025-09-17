@extends('adminlte::page')

@section('title', 'Holiday Packages')

@section('content_header')
    <h1 class="m-0 text-dark">Holiday Packages Management</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                    <h3 class="m-0">Daftar Holiday Packages</h3>
                    <a href="{{ route('admin.holiday.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Paket
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead class="bg-lightblue text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Paket</th>
                                    <th>Harga Normal</th>
                                    <th>Harga Promo</th>
                                    <th>Minimal Orang</th>
                                    <th>Durasi</th>
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($holidays as $holiday)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $holiday->nama_paket }}</td>
                                        <td>Rp {{ number_format($holiday->harga, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($holiday->harga_promo)
                                                Rp {{ number_format($holiday->harga_promo, 0, ',', '.') }}
                                            @else
                                                <span class="text-muted">Tidak ada promo</span>
                                            @endif
                                        </td>
                                        <td>{{ $holiday->minimal_orang }} Orang</td>
                                        <td>{{ $holiday->durasi_hari }} Hari</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $holiday->status === 'aktif' ? 'success' : 'secondary' }}">
                                                {{ $holiday->status === 'aktif' ? 'Aktif' : 'Non-Aktif' }}
                                            </span>

                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.holiday.edit', $holiday) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            

                                            <form action="{{ route('admin.holiday.destroy', $holiday->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data paket holiday</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                    <div class="mt-3">
                        {{ $holidays->links() }}
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
