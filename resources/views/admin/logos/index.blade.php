@extends('adminlte::page')

@section('title', 'Logo Landing Page')

@section('content_header')
    <h1 class="m-0">Logo Landing Page</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <x-adminlte-card title="Logo Saat Ini" theme="lightblue" theme-mode="outline">
                <div class="text-center mb-3">
                    @if ($logo && $logo->image_path)
                        <img src="{{ asset('storage/logos/' . $logo->image_path) }}" alt="Logo"
                            class="img-fluid img-thumbnail" style="max-height: 200px;">
                    @else
                        <img src="{{ asset('asset/img/LogoWebBrillaintPare.png') }}" alt="Logo Default"
                            class="img-fluid img-thumbnail" style="max-height: 200px;">
                        <p class="text-muted mt-2"><small>Menggunakan gambar default. Upload logo baru untuk menggantinya.</small></p>
                    @endif
                </div>

                <form action="{{ route('admin.logos.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <x-adminlte-input-file name="image_path" label="Upload Logo Baru" id="imageInput"
                        placeholder="Pilih gambar..." />
                    <img id="imagePreview" src="#" alt="Preview" class="mt-2 d-none img-thumbnail"
                        style="max-height: 150px;">

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Simpan Logo
                        </button>
                    </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('js')
    @if (session('alert'))
        <script>
            Swal.fire({
                icon: '{{ session('alert')['icon'] }}',
                title: '{{ session('alert')['title'] }}',
                text: '{{ session('alert')['text'] }}',
                timer: 2500,
                showConfirmButton: false,
            });
        </script>
    @endif
    <script>
        document.getElementById('imageInput').addEventListener('change', function (event) {
            const preview = document.getElementById('imagePreview');
            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        });
    </script>
@stop
