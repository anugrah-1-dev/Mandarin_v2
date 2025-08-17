@extends('adminlte::page')

@section('title', 'Tambah Program Online')

@section('content_header')
    <h1 class="m-0 text-dark">Tambah Program Online Baru</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            <x-adminlte-card theme="lightblue" title="Form Tambah Program Online">

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

                <form action="{{ route('admin.online.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <x-adminlte-input name="nama" label="Nama Program" placeholder="Contoh: Kelas Online Intensif"
                        value="{{ old('nama') }}" required />
                    
                        <x-adminlte-select name="program_bahasa" label="Program Bahasa" required>
                            <option value="" disabled selected>-- Pilih Bahasa --</option>
                            <option value="inggris" {{ old('program_bahasa') == 'inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                            <option value="jerman" {{ old('program_bahasa') == 'jerman' ? 'selected' : '' }}>Bahasa Jerman</option>
                            <option value="mandarin" {{ old('program_bahasa') == 'mandarin' ? 'selected' : '' }}>Bahasa Mandarin</option>
                            <option value="arab" {{ old('program_bahasa') == 'arab' ? 'selected' : '' }}>Bahasa Arab</option>
                        </x-adminlte-select>

                    <x-adminlte-input name="slug" label="Slug" placeholder="contoh-program-online"
                        value="{{ old('slug') }}" required />

                    <x-adminlte-input name="lama_program" label="Durasi Program" placeholder="Contoh: 4 minggu"
                        value="{{ old('lama_program') }}" required />

                    <x-adminlte-input name="kategori" label="Kategori Program" placeholder="Contoh: Webinar / Intensif"
                        value="{{ old('kategori') }}" required />

                    <x-adminlte-input name="harga" label="Harga (Rp)" type="number" placeholder="Contoh: 1000000"
                        value="{{ old('harga') }}" required />

                    <x-adminlte-textarea name="features_program" label="Fitur Program (Pisahkan dengan Enter)"
                        rows="4" placeholder="Contoh:\n✅ Live Zoom\n✅ Grup Telegram\n✅ Sertifikat"
                        required>{{ old('features_program') }}</x-adminlte-textarea>

                    <x-adminlte-select name="is_active" label="Status Program" required>
                        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </x-adminlte-select>

                    <x-adminlte-input name="thumbnail" label="Thumbnail Program (Gambar)" type="file" accept="image/*"
                        required />

                    <div class="mt-3">
                        <x-adminlte-button type="submit" theme="primary" icon="fas fa-save" label="Simpan Program" />
                        <a href="{{ route('admin.online.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-arrow-left"></i> Batal
                        </a>
                    </div>
                </form>

            </x-adminlte-card>
        </div>
    </div>
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
