@extends('adminlte::page')

@section('title', 'Logo Landing Page')

@section('content_header')
    <h1 class="m-0">Logo Landing Page</h1>
@stop

@section('content')
    <div class="row">
        {{-- Logo 1: Default --}}
        <div class="col-md-6">
            <x-adminlte-card title="Logo 1" theme="lightblue" theme-mode="outline">
                <div class="text-center mb-3">
                    @if ($logo1 && $logo1->image_path)
                        <img src="{{ asset('storage/' . $logo1->image_path) }}" alt="Logo Default"
                            class="img-fluid img-thumbnail" style="max-height: 200px;">
                    @else
                        <img src="{{ asset('asset/img/LogoWebBrillaintPare.png') }}" alt="Logo Default"
                            class="img-fluid img-thumbnail" style="max-height: 200px;">
                        <p class="text-muted mt-2"><small>Menggunakan gambar default.</small></p>
                    @endif
                </div>

                <form action="{{ route('admin.logos.update', 'logo1') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <x-adminlte-input-file name="image_path" label="Upload Logo 1" id="imageInput1"
                        placeholder="Pilih gambar..." />
                    <img id="imagePreview1" src="#" alt="Preview" class="mt-2 d-none img-thumbnail"
                        style="max-height: 150px;">

                    <div class="d-flex justify-content-end mt-3">
                        @if ($logo1 && $logo1->image_path)
                            <a href="#" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus logo ini?')) document.getElementById('delete-logo1-form').submit();" class="btn btn-danger mr-2">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        @endif
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Simpan
                        </button>
                    </div>
                </form>
                @if ($logo1 && $logo1->image_path)
                    <form id="delete-logo1-form" action="{{ route('admin.logos.destroy', 'logo1') }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
            </x-adminlte-card>
        </div>

        {{-- Logo 2: Scroll --}}
        <div class="col-md-6">
            <x-adminlte-card title="Logo 2" theme="success" theme-mode="outline">
                <div class="text-center mb-3">
                    @if ($logo2 && $logo2->image_path)
                        <img src="{{ asset('storage/' . $logo2->image_path) }}" alt="Logo Scroll"
                            class="img-fluid img-thumbnail" style="max-height: 200px;">
                    @else
                        <img src="{{ asset('asset/img/LogoWebBrillaintPare.png') }}" alt="Logo Scroll Default"
                            class="img-fluid img-thumbnail" style="max-height: 200px;">
                        <p class="text-muted mt-2"><small>Menggunakan gambar default.</small></p>
                    @endif
                </div>

                <form action="{{ route('admin.logos.update', 'logo2') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <x-adminlte-input-file name="image_path" label="Upload Logo 2" id="imageInput2"
                        placeholder="Pilih gambar..." />
                    <img id="imagePreview2" src="#" alt="Preview" class="mt-2 d-none img-thumbnail"
                        style="max-height: 150px;">

                    <div class="d-flex justify-content-end mt-3">
                        @if ($logo2 && $logo2->image_path)
                            <a href="#" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus logo ini?')) document.getElementById('delete-logo2-form').submit();" class="btn btn-danger mr-2">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        @endif
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Simpan
                        </button>
                    </div>
                </form>
                @if ($logo2 && $logo2->image_path)
                    <form id="delete-logo2-form" action="{{ route('admin.logos.destroy', 'logo2') }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
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
        document.getElementById('imageInput1').addEventListener('change', function (event) {
            const preview = document.getElementById('imagePreview1');
            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = e => { preview.src = e.target.result; preview.classList.remove('d-none'); };
                reader.readAsDataURL(event.target.files[0]);
            }
        });
        document.getElementById('imageInput2').addEventListener('change', function (event) {
            const preview = document.getElementById('imagePreview2');
            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = e => { preview.src = e.target.result; preview.classList.remove('d-none'); };
                reader.readAsDataURL(event.target.files[0]);
            }
        });
    </script>
@stop
