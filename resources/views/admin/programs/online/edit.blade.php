@extends('adminlte::page')

@section('title', 'Edit Program Online')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Program Online: {{ $online->nama }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            <x-adminlte-card theme="lightblue" title="Form Edit Program Online">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Ups!</strong> Ada kesalahan dalam input:
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.online.update', $online) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <x-adminlte-input name="nama" label="Nama Program" placeholder="Contoh: Kelas Online Intensif"
                        value="{{ old('nama', $online->nama) }}" required />

                        <x-adminlte-select name="program_bahasa" label="Program Bahasa" required>
                            <option value="" disabled selected>-- Pilih Bahasa --</option>
                            <option value="inggris" {{ old('program_bahasa') == 'inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                            <option value="jerman" {{ old('program_bahasa') == 'jerman' ? 'selected' : '' }}>Bahasa Jerman</option>
                            <option value="mandarin" {{ old('program_bahasa') == 'mandarin' ? 'selected' : '' }}>Bahasa Mandarin</option>
                            <option value="arab" {{ old('program_bahasa') == 'arab' ? 'selected' : '' }}>Bahasa Arab</option>
                        </x-adminlte-select>

                    <x-adminlte-input name="slug" label="Slug" placeholder="contoh-program-online"
                        value="{{ old('slug', $online->slug) }}" required />

                    <x-adminlte-input name="lama_program" label="Durasi Program" placeholder="Contoh: 4 minggu"
                        value="{{ old('lama_program', $online->lama_program) }}" required />

                    <x-adminlte-input name="kategori" label="Kategori Program" placeholder="Contoh: Webinar / Intensif"
                        value="{{ old('kategori', $online->kategori) }}" required />

                    <x-adminlte-input name="harga" label="Harga (Rp)" type="number" placeholder="Contoh: 1000000"
                        value="{{ old('harga', $online->harga) }}" required />

                    <x-adminlte-textarea name="features_program" label="Fitur Program (Pisahkan dengan Enter)"
                        rows="4" placeholder="Contoh:\n✅ Live Zoom\n✅ Grup Telegram\n✅ Sertifikat"
                        required>{{ old('features_program', is_array($online->features_program) ? implode("\n", $online->features_program) : $online->features_program) }}</x-adminlte-textarea>

                    <x-adminlte-select name="is_active" label="Status Program" required>
                        <option value="1" {{ old('is_active', $online->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active', $online->is_active) == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </x-adminlte-select>

                    <x-adminlte-input name="thumbnail" label="Thumbnail Program (Gambar)" type="file"
                        accept="image/*" />

                    @if ($online->thumbnail)
                        <div class="mt-2">
                            <p>Thumbnail Saat Ini:</p>
                            <img src="{{ asset('uploads/thumbnails/' . $online->thumbnail) }}" class="img-thumbnail" width="200">
                            <div class="form-check mt-2">
                                <input type="checkbox" name="hapus_thumbnail" id="hapus_thumbnail" class="form-check-input">
                                <label for="hapus_thumbnail" class="form-check-label">Hapus thumbnail saat disimpan</label>
                            </div>
                        </div>
                    @endif

                    <div class="mt-3">
                        <x-adminlte-button type="submit" theme="primary" icon="fas fa-save" label="Perbarui Program" />
                        <a href="{{ route('admin.online.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-arrow-left"></i> Batal
                        </a>
                    </div>
                </form>

            </x-adminlte-card>
        </div>
    </div>
@stop

@section('css')
    <style>
        .img-thumbnail {
            max-height: 200px;
            object-fit: cover;
        }
    </style>
@stop

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
