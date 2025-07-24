@extends('adminlte::page')

@section('title', 'Pendaftar Program Online')

@section('content_header')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
    <h1 class="m-0">Daftar Pendaftar Program Online</h1>
    <div class="d-flex flex-column flex-md-row gap-2 align-items-center">
        <div class="input-group input-group-sm" style="width: 250px;">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari...">
            <span class="input-group-append">
                <button type="button" class="btn btn-default btn-flat">
                    <i class="fas fa-search"></i>
                </button>
            </span>
        </div>
        <a href="{{ route('admin.pendaftaran.online.export') }}" class="btn btn-success btn-sm ml-md-2">
            <i class="fas fa-file-csv mr-1"></i> Export CSV
        </a>
    </div>
</div>
@stop

@section('content')
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Data Pendaftar</h3>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="pendaftarTable" class="table table-hover table-bordered mb-0">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>TRX ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Kota</th>
                        <th>Program</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Bukti Pembayaran</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendaftar as $index => $data)
                    <tr>
                        <td>{{ $pendaftar->firstItem() + $index }}</td>
                        <td>{{ $data->trx_id }}</td>
                        <td>{{ $data->nama_lengkap }}</td>
                        <td>{{ $data->email ?? '-' }}</td>
                        <td>{{ $data->no_hp ?? '-' }}</td>
                        <td>{{ $data->asal_kota ?? '-' }}</td>
                        <td>{{ $data->program->nama ?? '-' }}</td>
                        {{-- KODE DIPERBAIKI DI SINI --}}
                        <td>{{ $data->period ? optional($data->period->date)->translatedFormat('d F Y') : '-' }}</td>
                        <td>
                            @php
                            $statusClass = 'secondary';
                            if ($data->status === 'pending') $statusClass = 'warning';
                            if ($data->status === 'approved') $statusClass = 'success';
                            if ($data->status === 'rejected') $statusClass = 'danger';
                            @endphp
                            <span class="badge badge-{{ $statusClass }}">{{ ucfirst($data->status) }}</span>
                        </td>
                        <td>
                            @if($data->bukti_pembayaran)
                            <a href="{{ asset('storage/' . $data->bukti_pembayaran) }}" target="_blank" title="Lihat Bukti">
                                <img src="{{ asset('storage/' . $data->bukti_pembayaran) }}" alt="Bukti" class="img-thumbnail" style="max-width: 60px; height: auto;">
                            </a>
                            @else
                            <span class="text-muted" style="font-size: 0.85em;">Belum ada</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.pendaftaran.online.edit', $data->id) }}" class="btn btn-primary" title="Edit Status">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('admin.pendaftaran.online.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus pendaftaran ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center py-4">Belum ada pendaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($pendaftar->hasPages())
    <div class="card-footer bg-light">
        {{ $pendaftar->links('vendor.pagination.bootstrap-4') }}
    </div>
    @endif
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<style>
    .dataTables_filter {
        display: none;
    }

    .table-responsive {
        max-height: 500px;
    }

    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background-color: #aaa;
        border-radius: 10px;
    }
</style>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#pendaftarTable').DataTable({
            paging: false,
            ordering: true,
            searching: true,
            info: false,
            responsive: true,
            columnDefs: [{
                orderable: false,
                targets: [0, 9, 10]
            }],
            language: {
                search: "Cari:",
                emptyTable: "Belum ada data yang tersedia.",
                zeroRecords: "Tidak ditemukan data yang cocok."
            }
        });

        $('#searchInput').on('keyup', function() {
            $('#pendaftarTable').DataTable().search(this.value).draw();
        });
    });
</script>
@stop