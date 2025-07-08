@extends('adminlte::page')

@section('title', 'Tambah Galeri')

@section('content_header')
    <h1>Tambah Galeri Baru</h1>
@stop

@section('content')
    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">

                <div class="form-group">
                    <label for="title">Judul Galeri</label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi (Opsional)</label>
                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" selected>Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="images">Upload Gambar (Bisa lebih dari satu)</label>
                    <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Galeri</button>
                <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </form>
@stop
