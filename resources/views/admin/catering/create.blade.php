@extends('adminlte::page')

@section('title', 'Tambah Paket Catering')

@section('content_header')
    <h1 class="m-0 text-dark">Tambah Paket Catering</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-utensils mr-2"></i>Form Tambah Paket Catering</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.catering.store') }}" method="POST" enctype="multipart/form-data" id="cateringForm">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-success card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-box-open mr-2"></i>
                                        Data Paket Catering
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <!-- Thumbnail -->
                                    <div class="form-group row">
                                        <label for="thumbnail" class="col-sm-3 col-form-label">Thumbnail</label>
                                        <div class="col-sm-9">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="thumbnail" id="thumbnail" accept="image/*">
                                                <label class="custom-file-label" for="thumbnail">Pilih file gambar</label>
                                            </div>
                                            <small class="form-text text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB.</small>
                                            <div id="thumbnail-preview" class="mt-2 text-center"></div>
                                        </div>
                                    </div>

                                    <!-- Nama Paket -->
                                    <div class="form-group row">
                                        <label for="nama_paket" class="col-sm-3 col-form-label">Nama Paket <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="nama_paket" name="nama_paket" placeholder="Masukkan nama paket" required>
                                        </div>
                                    </div>

                                    <!-- Harga -->
                                    <div class="form-group row">
                                        <label for="harga" class="col-sm-3 col-form-label">Harga <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input type="text" class="form-control" id="harga" name="harga" placeholder="0" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Periode -->
                                    <div class="form-group row">
                                        <label for="periode" class="col-sm-3 col-form-label">Periode <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" id="periode" name="periode" required style="width: 100%;">
                                                <option value="1">Harian</option>
                                                <option value="2">Mingguan</option>
                                                <option value="3">Bulanan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Jam Pengantaran -->
                                    {{-- <div class="form-group row">
                                        <label for="jam_pengantaran" class="col-sm-3 col-form-label">Jam Pengantaran</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input type="time" class="form-control" id="jam_pengantaran" name="jam_pengantaran">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <!-- Status -->
                                    <div class="form-group row">
                                        <label for="status" class="col-sm-3 col-form-label">Status <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select name="status" id="status" class="form-control select2" style="width: 100%;">
                                                <option value="aktif">Aktif</option>
                                                <option value="nonaktif">Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Deskripsi -->
                                    <div class="form-group row">
                                        <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                                        <div class="col-sm-9">
                                            <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control" placeholder="Tuliskan deskripsi paket"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card-footer bg-white text-right">
                                <a href="{{ route('admin.catering.index') }}" class="btn btn-secondary mr-2">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        .card-outline {
            border-top: 3px solid;
        }
        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(2.25rem + 2px);
        }
        .col-form-label {
            font-weight: 500;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('vendor/inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({ theme: 'bootstrap4' });

            // Inputmask untuk harga
            $('#harga').inputmask({
                'alias': 'numeric',
                'groupSeparator': '.',
                'autoGroup': true,
                'digits': 0,
                'digitsOptional': false,
                'prefix': '',
                'placeholder': '0'
            });

            // Preview image sebelum upload
            $('#thumbnail').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#thumbnail-preview').html(
                            '<img src="' + e.target.result + '" class="img-thumbnail" width="150">'
                        );
                    }
                    reader.readAsDataURL(file);
                    $(this).next('.custom-file-label').html(file.name);
                }
            });

            // Convert currency ke angka sebelum submit
            $('#cateringForm').on('submit', function() {
                var harga = $('#harga').inputmask('unmaskedvalue');
                $('#harga').val(harga);
            });
        });
    </script>
@stop
