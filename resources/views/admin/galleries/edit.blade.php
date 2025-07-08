@extends('adminlte::page')

@section('title', 'Edit Galeri')

@section('content_header')
    <h1>Edit Galeri: {{ $gallery->title }}</h1>
@stop

@section('content')
<form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-body">

            <div class="form-group">
                <label for="title">Judul Galeri</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $gallery->title) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" class="form-control">{{ old('description', $gallery->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control">
                    <option value="1" {{ $gallery->status ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$gallery->status ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="form-group">
                <label>Gambar Saat Ini</label>
                <div class="row">
                    @forelse ($gallery->images as $image)
                        <div class="col-md-3 mb-3">
                            <div class="card shadow-sm">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top rounded" alt="Gambar Galeri">
                                <div class="card-body p-2">
                                    <form action="{{ route('admin.galleries.images.destroy', $image->id) }}" method="POST" class="form-delete-image">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger btn-block"><i class="fas fa-trash"></i> Hapus</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted">Belum ada gambar yang ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="form-group">
                <label for="images">Upload Gambar Baru (Opsional)</label>
                <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin menambah gambar baru.</small>
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">Update Galeri</button>
            <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</form>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('submit', function(e) {
        const form = e.target;
        if (form.classList.contains('form-delete-image')) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin hapus gambar ini?',
                text: "Gambar akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    });
</script>
@stop
