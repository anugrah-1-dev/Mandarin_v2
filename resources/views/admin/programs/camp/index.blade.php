@extends('adminlte::page')

@section('title', 'Manajemen Program Camp')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Daftar Program Camp</h1>
    {{-- <a href="{{ route('admin.programs.camp.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Program
    </a> --}}
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <x-adminlte-card theme="lightblue" theme-mode="outline" title="List Program Camp">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="Cari berdasarkan nama program...">
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <span class="text-muted">
                        Menampilkan {{ $programs->firstItem() }} - {{ $programs->lastItem() }} dari
                        {{ $programs->total() }} program
                    </span>
                </div>
            </div>

            <div class="table-responsive limited-scroll">

                <table class="table table-hover table-bordered table-striped" id="programTable">
                    <thead class="bg-lightblue">
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Thumbnail</th>
                            <th width="15%">Nama Program</th>
                            <th width="10%">Kategori</th>
                            <th width="5%">Stok</th>
                            <th width="15%">Harga</th>
                            <th width="25%">Fasilitas</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programs as $index => $program)
                            <tr>
                                <td class="text-center">
                                    {{ ($programs->currentPage() - 1) * $programs->perPage() + $index + 1 }}
                                </td>
                                <td class="text-center">
                                    @if ($program->thumbnail && file_exists(public_path('upload/camp/' . $program->thumbnail)))
                                        <img src="{{ asset('upload/camp/' . $program->thumbnail) }}" alt="Thumbnail"
                                            class="img-thumbnail" style="max-width: 80px; max-height: 60px;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $program->nama }}</strong><br>
                                    <small class="text-muted">Slug: {{ $program->slug ?? '-' }}</small>
                                </td>
                                <td>{{ $program->kategori ?? '-' }}</td>
                                <td class="text-center">{{ $program->stok ?? 0 }}</td>
                                <td>
                                    <div class="price-info">
                                        <small>Per Hari: Rp
                                            {{ number_format($program->harga_perhari, 0, ',', '.') }}</small><br>
                                        <small>1 Minggu: Rp
                                            {{ number_format($program->harga_satu_minggu, 0, ',', '.') }}</small><br>
                                        <small>1 Bulan: Rp
                                            {{ number_format($program->harga_satu_bulan, 0, ',', '.') }}</small>
                                        <a href="#" class="show-more-prices" data-program-id="{{ $program->id }}">Lihat
                                            lebih banyak...</a>
                                        <div class="more-prices" id="more-prices-{{ $program->id }}" style="display:none;">
                                            <small>2 Minggu: Rp
                                                {{ number_format($program->harga_dua_minggu, 0, ',', '.') }}</small><br>
                                            <small>3 Minggu: Rp
                                                {{ number_format($program->harga_tiga_minggu, 0, ',', '.') }}</small><br>
                                            <small>2 Bulan: Rp
                                                {{ number_format($program->harga_dua_bulan, 0, ',', '.') }}</small><br>
                                            <small>3 Bulan: Rp
                                                {{ number_format($program->harga_tiga_bulan, 0, ',', '.') }}</small><br>
                                            <small>6 Bulan: Rp
                                                {{ number_format($program->harga_enam_bulan, 0, ',', '.') }}</small><br>
                                            <small>1 Tahun: Rp
                                                {{ number_format($program->harga_satu_tahun, 0, ',', '.') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="facilities-container" style="max-height: 100px; overflow: hidden;">
                                        {!! nl2br(e($program->fasilitas)) !!}
                                    </div>
                                    @if (strlen($program->fasilitas) > 100)
                                        <a href="#" class="show-more-facilities" data-program-id="{{ $program->id }}">Lihat
                                            selengkapnya</a>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start gap-2 px-1">

                                        <a href="{{ route('admin.programs.camp.edit', $program->id) }}"
                                            class="btn btn-warning btn-icon-only" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.programs.camp.destroy', $program->id) }}"
                                            method="POST" onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-icon-only" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data program camp.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($programs->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <select class="form-control form-control-sm" id="perPageSelect" style="width: 80px;">
                            <option value="10" {{ $programs->perPage() == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $programs->perPage() == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $programs->perPage() == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $programs->perPage() == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <div>
                        {{ $programs->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            @endif
        </x-adminlte-card>
    </div>
</div>
@stop

@section('css')
<style>
    .limited-scroll {
        max-height: 350px;
        overflow-y: auto;
    }

    /* Scrollbar lebih cantik */
    .limited-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .limited-scroll::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 6px;
    }

    .price-info small {
        display: block;
        line-height: 1.3;
    }

    .show-more-prices,
    .show-more-facilities {
        font-size: 0.8rem;
        color: #007bff;
        cursor: pointer;
    }

    .table th {
        white-space: nowrap;
    }

    .facilities-container {
        font-size: 0.9rem;
    }

    .img-thumbnail {
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
    }

    .pagination {
        margin: 0;
    }

    .page-item.active .page-link {
        background-color: #3c8dbc;
        border-color: #367fa9;
    }

    .page-link {
        color: #3c8dbc;
    }

    .page-link:hover {
        color: #2a6496;
    }

    .btn-sm {
        min-width: 70px;
    }

    .btn-icon-only {
        width: 40px;
        height: 40px;
        font-size: 1rem;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }


    td .d-flex {
        padding-left: 0.25rem;
        padding-right: 0.25rem;
    }
</style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target.closest('form');

            Swal.fire({
                title: 'Yakin ingin menghapus data ini?',
                text: "Data akan dihapus secara permanen dari database.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else {
                    Swal.fire({
                        title: 'Dibatalkan',
                        text: 'Data tidak jadi dihapus.',
                        icon: 'info',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        }

        $(document).ready(function () {
            // Search functionality
            $('#searchInput').on('keyup', function () {
                const searchValue = $(this).val().toLowerCase();
                $('#programTable tbody tr').each(function () {
                    const rowText = $(this).text().toLowerCase();
                    $(this).toggle(rowText.includes(searchValue));
                });
            });

            // Toggle more prices
            $(document).on('click', '.show-more-prices', function (e) {
                e.preventDefault();
                const programId = $(this).data('program-id');
                $(this).hide();
                $('#more-prices-' + programId).show();
            });

            // Toggle more facilities
            $(document).on('click', '.show-more-facilities', function (e) {
                e.preventDefault();
                const programId = $(this).data('program-id');
                $(this).closest('td').find('.facilities-container').css('max-height', 'none');
                $(this).remove();
            });

            // Per page selection
            $('#perPageSelect').change(function () {
                const perPage = $(this).val();
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', perPage);
                window.location.href = url.toString();
            });
        });

        @if (session('alert'))
            Swal.fire(@json(session('alert')));
        @endif
    </script>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif