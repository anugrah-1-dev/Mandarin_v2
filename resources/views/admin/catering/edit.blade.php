@extends('adminlte::page')

@section('title', 'Edit Paket Catering')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Paket Catering</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-edit mr-2"></i>Form Edit Paket Catering</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.catering.update', $cateringPackage->id) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      id="cateringForm">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-warning card-outline">
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
                                            @if($cateringPackage->thumbnail)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $cateringPackage->thumbnail) }}"
                                                         alt="Thumbnail"
                                                         class="img-thumbnail"
                                                         width="150">
                                                </div>
                                            @endif
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="thumbnail" id="thumbnail" accept="image/*">
                                                <label class="custom-file-label" for="thumbnail">Pilih file gambar</label>
                                            </div>
                                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti thumbnail.</small>
                                            <div id="thumbnail-preview" class="mt-2 text-center"></div>
                                        </div>
                                    </div>

                                    <!-- Nama Paket -->
                                    <div class="form-group row">
                                        <label for="nama_paket" class="col-sm-3 col-form-label">Nama Paket <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="nama_paket" name="nama_paket"
                                                   value="{{ old('nama_paket', $cateringPackage->nama_paket) }}" required>
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
                                                <input type="text" class="form-control" id="harga" name="harga"
                                                       value="{{ old('harga', $cateringPackage->harga) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Periode -->
                                    <div class="form-group row">
                                        <label for="periode" class="col-sm-3 col-form-label">Periode <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" id="periode" name="periode" required style="width: 100%;">
                                                <option value="1" {{ old('periode', $cateringPackage->periode) == 1 ? 'selected' : '' }}>Harian</option>
                                                <option value="2" {{ old('periode', $cateringPackage->periode) == 2 ? 'selected' : '' }}>Mingguan</option>
                                                <option value="3" {{ old('periode', $cateringPackage->periode) == 3 ? 'selected' : '' }}>Bulanan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Jam Pengantaran -->
                                    {{-- <div class="form-group row">
                                        <label for="jam_pengantaran" class="col-sm-3 col-form-label">Jam Pengantaran</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input type="time" class="form-control" id="jam_pengantaran" name="jam_pengantaran"
                                                       value="{{ old('jam_pengantaran', $cateringPackage->jam_pengantaran) }}">
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
                                                <option value="aktif" {{ old('status', $cateringPackage->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="nonaktif" {{ old('status', $cateringPackage->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Deskripsi -->
                                    <div class="form-group row">
                                        <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                                        <div class="col-sm-9">
                                            <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control">{{ old('deskripsi', $cateringPackage->deskripsi) }}</textarea>
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
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save mr-1"></i> Perbarui
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
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
