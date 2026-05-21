@extends('adminlte::page')

@section('title', 'Tambah Galeri')

@section('content_header')
    <h1>Tambah Galeri Baru</h1>
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

@stop

@section('content')
    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">

                <div class="form-group">
                    <label for="title">Judul Galeri</label>
                    <input type="text" id="title" name="title" class="form-control" autocomplete="off" required value="{{ old('title') }}">
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi (Opsional)</label>
                    <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control" autocomplete="off">
                        <option value="1" selected>Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="images">Upload Foto <small class="text-muted">(bisa lebih dari satu, maks 5MB/foto)</small></label>
                    <input type="file" id="images" name="images[]" class="form-control" multiple accept="image/*">
                </div>

                <div class="form-group">
                    <label>Upload Video Lokal <small class="text-muted">(opsional, maks 100MB/video, format: mp4, mov, avi, webm)</small></label>
                    <div id="video-pairs-container"></div>
                    <button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="addVideoPair()">
                        <i class="fas fa-plus"></i> Tambah Video
                    </button>
                </div>

                <div class="form-group">
                    <label for="video_urls">Link Video YouTube <small class="text-muted">(opsional, satu link per baris)</small></label>
                    <textarea id="video_urls" name="video_urls" class="form-control" rows="4"
                        placeholder="https://www.youtube.com/watch?v=xxxxx&#10;https://youtu.be/xxxxx">{{ old('video_urls') }}</textarea>
                    <small class="text-muted">Masukkan URL YouTube, satu link per baris.</small>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Galeri</button>
                <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </form>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function addVideoPair() {
    const container = document.getElementById('video-pairs-container');
    const idx = container.querySelectorAll('.video-pair').length;
    const html = `
        <div class="video-pair border rounded p-2 mb-2 bg-light">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <strong class="small">Video ${idx + 1}</strong>
                <button type="button" class="btn btn-sm btn-outline-danger py-0" onclick="this.closest('.video-pair').remove()">
                    <i class="fas fa-times"></i> Hapus
                </button>
            </div>
            <div class="form-group mb-1">
                <label class="small mb-0">File Video <span class="text-danger">*</span></label>
                <input type="file" name="videos[]" class="form-control-file" accept="video/*" required>
            </div>
            <div class="form-group mb-0">
                <label class="small mb-0">Foto Cover <span class="text-muted">(opsional)</span></label>
                <input type="file" name="video_covers[]" class="form-control-file" accept="image/*">
                <small class="text-muted">Gambar yang tampil di galeri sebelum video diputar.</small>
            </div>
        </div>`;
    container.insertAdjacentHTML('beforeend', html);
    </script>

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
@stop
