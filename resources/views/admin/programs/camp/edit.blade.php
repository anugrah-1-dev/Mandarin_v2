@extends('adminlte::page')

@section('title', 'Edit Program Camp')

@section('content_header')
    <h1>Edit Program Camp</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Program Camp</h3>
                </div>
                <form action="{{ route('admin.programs.camp.update', $program->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <!-- Informasi Dasar -->
                        <h4 class="mt-3">Informasi Dasar</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input name="nama" label="Nama Program" placeholder="Masukkan nama program" value="{{ old('nama', $program->nama) }}" />
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-input name="slug" label="Slug" placeholder="program-camp-slug" value="{{ old('slug', $program->slug) }}" />
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-select name="kategori" label="Kategori">
                                    <option value="" {{ old('kategori', $program->kategori) ? '' : 'selected' }} disabled>Pilih Kategori</option>
                                    <option value="Putra" {{ old('kategori', $program->kategori) == 'Putra' ? 'selected' : '' }}>Putra</option>
                                    <option value="Putri" {{ old('kategori', $program->kategori) == 'Putri' ? 'selected' : '' }}>Putri</option>
                                    <option value="Campuran" {{ old('kategori', $program->kategori) == 'Campuran' ? 'selected' : '' }}>Campuran</option>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-input name="stok" label="Stok" type="number" min="0" placeholder="Jumlah kuota" value="{{ old('stok', $program->stok) }}" />
                            </div>
                        </div>

                        <!-- Harga -->
                        <h4 class="mt-4">Harga</h4>
                        <div class="row">
                            @foreach ([
                                'harga_perhari' => 'Per Hari',
                                'harga_satu_minggu' => '1 Minggu',
                                'harga_dua_minggu' => '2 Minggu',
                                'harga_tiga_minggu' => '3 Minggu',
                                'harga_satu_bulan' => '1 Bulan',
                                'harga_dua_bulan' => '2 Bulan',
                                'harga_tiga_bulan' => '3 Bulan',
                                'harga_enam_bulan' => '6 Bulan',
                                'harga_satu_tahun' => '1 Tahun'
                            ] as $field => $label)
                                <div class="col-md-4 col-sm-6">
                                    <x-adminlte-input name="{{ $field }}" label="Harga {{ $label }}" type="number" min="0" placeholder="0" value="{{ old($field, $program->$field) }}" />
                                </div>
                            @endforeach
                        </div>

                        <!-- Fasilitas -->
                        <h4 class="mt-4">Fasilitas</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <x-adminlte-textarea name="fasilitas" label="Fasilitas" placeholder="Pisahkan dengan koma (contoh: WiFi, Makan 3x, Transportasi)" rows="4">
                                    {{ old('fasilitas', $program->fasilitas) }}
                                </x-adminlte-textarea>
                            </div>
                        </div>

                        <!-- Thumbnail -->
                        <h4 class="mt-4">Thumbnail</h4>
                        <div class="row">
                            <div class="col-md-6">
                                @if ($program->thumbnail)
                                    <p>Thumbnail Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $program->thumbnail) }}" class="img-fluid mb-2" style="max-height: 200px;" alt="Current Thumbnail">
                                @endif
                                <x-adminlte-input-file name="thumbnail" label="Ganti Thumbnail (opsional)" accept="image/*" />
                                <div class="mt-2">
                                    <img id="preview-thumbnail" class="img-fluid d-none" style="max-height: 200px;" alt="Thumbnail Preview">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <x-adminlte-button label="Perbarui" theme="primary" icon="fas fa-save" type="submit" />
                        <x-adminlte-button label="Batal" theme="secondary" icon="fas fa-times" onclick="window.history.back()" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Preview thumbnail sebelum upload
        document.querySelector('input[name="thumbnail"]').addEventListener('change', function (e) {
            const file = e.target.files[0];
            const preview = document.getElementById('preview-thumbnail');
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
            } else {
                preview.src = '';
                preview.classList.add('d-none');
            }
        });
    </script>
@stop
