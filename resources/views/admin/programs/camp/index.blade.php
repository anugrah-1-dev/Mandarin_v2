@extends('adminlte::page')

@section('title', 'Manajemen Program Camp')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Daftar Program Camp</h1>
        <x-adminlte-button label="Tambah Program" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#createProgramModal" />
    </div>
@stop

<style>
    /* Atur lebar minimum tiap kolom */
    #programTable th:nth-child(1), 
    #programTable td:nth-child(1) { min-width: 40px; }   /* No */
    
    #programTable th:nth-child(2), 
    #programTable td:nth-child(2) { min-width: 100px; }  /* Thumbnail */
    
    #programTable th:nth-child(3), 
    #programTable td:nth-child(3) { min-width: 180px; }  /* Nama */
    
    #programTable th:nth-child(4), 
    #programTable td:nth-child(4) { min-width: 120px; }  /* Slug */
    
    #programTable th:nth-child(5), 
    #programTable td:nth-child(5) { min-width: 120px; }  /* Kategori */
    
    #programTable th:nth-child(6), 
    #programTable td:nth-child(6) { min-width: 70px; }   /* Stok */
    
    #programTable th:nth-child(n+7):nth-child(-n+15),
    #programTable td:nth-child(n+7):nth-child(-n+15) { 
        min-width: 120px;
        white-space: nowrap;
    } /* Semua kolom harga */
    
    #programTable th:nth-child(16),
    #programTable td:nth-child(16) {
        min-width: 200px;
    } /* Fasilitas */

    #programTable th:nth-child(17),
    #programTable td:nth-child(17) {
        min-width: 110px;
    } /* Aksi */

    td .btn {
        margin-right: 5px;
    }

    td .btn:last-child {
        margin-right: 0;
    }

    .preview-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 200px;
        background-color: #f8f9fa;
        border: 1px dashed #ced4da;
        border-radius: 4px;
        overflow: hidden;
    }

    .preview-container img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    .pagination {
        list-style: none;
        padding-left: 0;
        display: flex;
        gap: 4px;
    }

    .pagination .page-item {
        display: inline-block;
    }

    .pagination .page-link {
        display: block;
        padding: 6px 12px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        color: #007bff;
        text-decoration: none;
        background-color: #fff;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #f8f9fa;
    }
</style>


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
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan nama program...">
                        </div>
                    </div>
                </div>

                <div class="table-responsive" style="max-height: 400px; overflow: auto;">

                    <table class="table table-hover table-bordered table-striped" id="programTable">
                        <thead class="bg-lightblue text-center">
    <tr>
        <th>No</th>
        <th>Thumbnail</th>
        <th>Nama</th>
        <th>Slug</th>
        <th>Kategori</th>
        <th>Stok</th>
        <th>Harga / Hari</th>
        <th>Harga 1 Minggu</th>
        <th>Harga 2 Minggu</th>
        <th>Harga 3 Minggu</th>
        <th>Harga 1 Bulan</th>
        <th>Harga 2 Bulan</th>
        <th>Harga 3 Bulan</th>
        <th>Harga 6 Bulan</th>
        <th>Harga 1 Tahun</th>
        <th>Fasilitas</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
    @forelse($programs as $index => $program)
    <tr class="text-center">
        <td>{{ ($programs->currentPage() - 1) * $programs->perPage() + $index + 1 }}</td>

        <td>
            @if($program->thumbnail && file_exists(public_path('upload/camp/' . $program->thumbnail)))
                <img src="{{ asset('upload/camp/' . $program->thumbnail) }}" alt="Thumbnail" style="width: 80px; height: 60px; object-fit: cover;">
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <td class="text-left"><strong>{{ $program->nama }}</strong></td>
        <td>{{ $program->slug ?? '-' }}</td>
        <td>{{ $program->kategori ?? '-' }}</td>
        <td>{{ $program->stok ?? 0 }}</td>
        <td>Rp {{ number_format($program->harga_perhari, 0, ',', '.') }}</td>
        <td>Rp {{ number_format($program->harga_satu_minggu, 0, ',', '.') }}</td>
        <td>Rp {{ number_format($program->harga_dua_minggu, 0, ',', '.') }}</td>
        <td>Rp {{ number_format($program->harga_tiga_minggu, 0, ',', '.') }}</td>
        <td>Rp {{ number_format($program->harga_satu_bulan, 0, ',', '.') }}</td>
        <td>Rp {{ number_format($program->harga_dua_bulan, 0, ',', '.') }}</td>
        <td>Rp {{ number_format($program->harga_tiga_bulan, 0, ',', '.') }}</td>
        <td>Rp {{ number_format($program->harga_enam_bulan, 0, ',', '.') }}</td>
        <td>Rp {{ number_format($program->harga_satu_tahun, 0, ',', '.') }}</td>
        <td class="text-left">{!! nl2br(e($program->fasilitas)) !!}</td>
        <td class="text-center">
    <button class="btn btn-warning btn-sm mr-1 btn-edit-program"
        data-id="{{ $program->id }}"
        data-nama="{{ $program->nama }}"
        data-slug="{{ $program->slug }}"
        data-kategori="{{ $program->kategori }}"
        data-stok="{{ $program->stok }}"
        data-harga_perhari="{{ $program->harga_perhari }}"
        data-harga_satu_minggu="{{ $program->harga_satu_minggu }}"
        data-harga_dua_minggu="{{ $program->harga_dua_minggu }}"
        data-harga_tiga_minggu="{{ $program->harga_tiga_minggu }}"
        data-harga_satu_bulan="{{ $program->harga_satu_bulan }}"
        data-harga_dua_bulan="{{ $program->harga_dua_bulan }}"
        data-harga_tiga_bulan="{{ $program->harga_tiga_bulan }}"
        data-harga_enam_bulan="{{ $program->harga_enam_bulan }}"
        data-harga_satu_tahun="{{ $program->harga_satu_tahun }}"
        data-fasilitas="{{ $program->fasilitas }}">
        <i class="fas fa-edit"></i>
    </button>

    <form action="{{ route('admin.programs.camp.destroy', $program->id) }}" method="POST" onsubmit="confirmDelete(event)" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
</td>


    </tr>
    @empty
    <tr>
        <td colspan="17" class="text-center">Tidak ada data program camp.</td>
    </tr>
    @endforelse
</tbody>

                    </table>

                </div>
            </x-adminlte-card>
            @if ($programs->total() > $programs->perPage())
    {{-- tampilkan pagination --}}
<div class="d-flex justify-content-center mt-3">
    <ul class="pagination">
        {{-- Tombol Sebelumnya --}}
        <li class="page-item {{ $programs->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $programs->onFirstPage() ? '#' : $programs->previousPageUrl() }}">«</a>
        </li>

        {{-- Nomor Halaman --}}
        @foreach ($programs->getUrlRange(1, $programs->lastPage()) as $page => $url)
            <li class="page-item {{ $programs->currentPage() == $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach

        {{-- Tombol Berikutnya --}}
        <li class="page-item {{ !$programs->hasMorePages() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $programs->hasMorePages() ? $programs->nextPageUrl() : '#' }}">»</a>
        </li>
    </ul>
</div>
@endif

        </div>
    </div>

    {{-- Modal Create --}}
    <x-adminlte-modal id="createProgramModal" title="Tambah Program Camp Baru" theme="lightblue" size="lg" static-backdrop>
        <form action="{{ route('admin.programs.camp.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <x-adminlte-input name="nama" label="Nama Program" placeholder="Contoh: Camp Satu" required />
        </div>
        <div class="col-md-6">
            <x-adminlte-input name="slug" label="Slug (URL)" placeholder="contoh-camp-satu" />
        </div>
        <div class="col-md-4">
            <x-adminlte-input name="kategori" label="Kategori" placeholder="Contoh: Edukasi" />
        </div>
        <div class="col-md-4">
            <x-adminlte-input name="stok" label="Stok" type="number" placeholder="Contoh: 20" />
        </div>
        <div class="col-md-4">
            <x-adminlte-input name="harga_perhari" label="Harga / Hari" type="number" placeholder="Contoh: 100000" />
        </div>

        @php
            $durasi = ['satu_minggu', 'dua_minggu', 'tiga_minggu', 'satu_bulan', 'dua_bulan', 'tiga_bulan', 'enam_bulan', 'satu_tahun'];
        @endphp
        @foreach($durasi as $d)
            <div class="col-md-4">
                <x-adminlte-input name="harga_{{ $d }}" label="Harga {{ str_replace('_', ' ', ucfirst($d)) }}" type="number" />
            </div>
        @endforeach

        <div class="col-md-12">
            <x-adminlte-textarea name="fasilitas" label="Fasilitas" rows=4 placeholder="Contoh: Makan 3x, WiFi, Modul,..." />
        </div>
       <div class="form-group col-md-12">
    <label for="thumbnailCreate">Thumbnail Program (gambar)</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="thumbnailCreate" name="thumbnail" required>
        <label id="labelCreate" class="custom-file-label" for="thumbnailCreate">Pilih file</label>

    </div>
    <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB</small>
    <div class="mt-2 preview-container">
    <img id="preview-create" src="" alt="Preview Thumbnail" style="display: none;">
</div>

</div>

</div>

    </div>
    <div class="d-flex justify-content-end mt-3 px-3 pb-3">
        <button type="button" class="btn btn-secondary btn-sm mr-2" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
    </div>
</form>

        <x-slot name="footerSlot">
            <style>#createProgramModal .modal-footer { display: none; }</style>
        </x-slot>
    </x-adminlte-modal>

    {{-- Modal Edit --}}
    <x-adminlte-modal id="editProgramModal" title="Edit Program Camp" theme="lightblue" size="lg" static-backdrop>
        <form id="editProgramForm" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" id="editId">
    <div class="row">
        <div class="col-md-6">
            <x-adminlte-input name="nama" label="Nama Program" id="editNama" required />
        </div>
        <div class="col-md-6">
            <x-adminlte-input name="slug" label="Slug (URL)" id="editSlug" />
        </div>
        <div class="col-md-4">
            <x-adminlte-input name="kategori" label="Kategori" id="editKategori" />
        </div>
        <div class="col-md-4">
            <x-adminlte-input name="stok" label="Stok" id="editStok" type="number" />
        </div>
        <div class="col-md-4">
            <x-adminlte-input name="harga_perhari" label="Harga / Hari" id="editHargaPerhari" type="number" />
        </div>

        @foreach($durasi as $d)
            <div class="col-md-4">
                <x-adminlte-input name="harga_{{ $d }}" label="Harga {{ str_replace('_', ' ', ucfirst($d)) }}" id="editHarga_{{ $d }}" type="number" />
            </div>
        @endforeach

        <div class="col-md-12">
            <x-adminlte-textarea name="fasilitas" label="Fasilitas" id="editFasilitas" rows=4 />
        </div>
        <div class="form-group col-md-12">
    <label for="thumbnailEdit">Thumbnail (biarkan kosong jika tidak diganti)</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="thumbnailEdit" name="thumbnail">
        <label id="labelEdit" class="custom-file-label" for="thumbnailEdit">Pilih file</label>

    </div>
    <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB</small>
    <div class="mt-2 preview-container">
    <img id="preview-edit" src="" alt="Preview Thumbnail" style="display: none;">
</div>

</div>

</div>

    </div>
    <div class="d-flex justify-content-end mt-3 px-3 pb-3">
        <button type="button" class="btn btn-secondary btn-sm mr-2" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
    </div>
</form>

        <x-slot name="footerSlot">
            <style>#editProgramModal .modal-footer { display: none; }</style>
        </x-slot>
    </x-adminlte-modal>
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
        confirmButtonColor: '#e3342f', // Merah
        cancelButtonColor: '#6c757d',  // Abu
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit(); // Hapus data dari database
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
        // Fitur pencarian
        $('#searchInput').on('keyup', function () {
            const searchValue = $(this).val().toLowerCase();
            $('#programTable tbody tr').each(function () {
                const rowText = $(this).text().toLowerCase();
                $(this).toggle(rowText.includes(searchValue));
            });
        });

        // Tombol edit
        $('.btn-edit-program').on('click', function () {
            const data = $(this).data();

            $('#editId').val(data.id);
            $('#editNama').val(data.nama);
            $('#editSlug').val(data.slug);
            $('#editKategori').val(data.kategori);
            $('#editStok').val(data.stok);
            $('#editHargaPerhari').val(data.harga_perhari);
            $('#editFasilitas').val(data.fasilitas);

            // Set semua harga durasi
            const durasi = [
                'satu_minggu', 'dua_minggu', 'tiga_minggu',
                'satu_bulan', 'dua_bulan', 'tiga_bulan',
                'enam_bulan', 'satu_tahun'
            ];
            durasi.forEach(d => {
                $('#editHarga_' + d).val(data['harga_' + d]);
            });

            // Perbaikan utama: action form update
            const actionUrl = `{{ url('admin/programs/camp') }}/${data.id}`;
            $('#editProgramForm').attr('action', actionUrl);

            // Tampilkan modal
            $('#editProgramModal').modal('show');
        });
    });
</script>

@if(session('alert'))
<script>
    Swal.fire(@json(session('alert')));
</script>
@endif

<script>
    function showThumbnailPreview(inputId, previewId, labelId) {
    const input = document.getElementById(inputId);
    const file = input.files[0];
    const preview = document.getElementById(previewId);
    const label = document.getElementById(labelId);

    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'Ukuran file terlalu besar',
                text: 'Ukuran gambar tidak boleh melebihi 2MB.',
            });
            input.value = '';
            preview.src = '';
            preview.style.display = 'none';
            label.textContent = 'Pilih file';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            const img = new Image();
            img.onload = function () {
                if (img.width > 2000 || img.height > 2000) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Dimensi gambar terlalu besar',
                        text: 'Maksimal lebar 1000px dan tinggi 800px.',
                    });
                    input.value = '';
                    preview.src = '';
                    preview.style.display = 'none';
                    label.textContent = 'Pilih file';
                    return;
                }

                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            img.src = e.target.result;

            label.textContent = file.name;
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = '';
        preview.style.display = 'none';
        label.textContent = 'Pilih file';
    }

        
    }

    document.getElementById('thumbnailCreate').addEventListener('change', function () {
        showThumbnailPreview('thumbnailCreate', 'preview-create', 'labelCreate');
    });

    document.getElementById('thumbnailEdit').addEventListener('change', function () {
        showThumbnailPreview('thumbnailEdit', 'preview-edit', 'labelEdit');
    });

    
</script>

@endsection
