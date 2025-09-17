@extends('adminlte::page')

@section('title', 'Tambah Paket Holiday')

@section('content_header')
    <h1 class="m-0 text-dark">Tambah Paket Holiday</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-success card-outline">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-plane-departure mr-2"></i>Form Tambah Paket Holiday</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.holiday.store') }}" method="POST" enctype="multipart/form-data"
                        id="holidayForm">
                        @csrf

                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="nama_paket" class="col-sm-4 col-form-label">Nama Paket <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nama_paket" name="nama_paket"
                                            placeholder="Masukkan nama paket" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="deskripsi" class="col-sm-4 col-form-label">Deskripsi</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi paket"></textarea>
                                    </div>
                                </div>

                                <div id="fasilitas-wrapper">
                                    <div class="input-group mb-2">
                                        <input type="text" name="fasilitas[]" class="form-control"
                                            placeholder="Masukkan fasilitas">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-success add-fasilitas"><i
                                                    class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Harga Biasa dan Harga Promo Berdampingan -->
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Harga Paket</label>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="harga">Harga Normal <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="harga" name="harga"
                                                        placeholder="0" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="harga_promo">Harga Promo</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="harga_promo"
                                                        name="harga_promo" placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="minimal_orang" class="col-sm-4 col-form-label">Minimal Orang</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="minimal_orang"
                                                name="minimal_orang" placeholder="Contoh: 2">
                                            <div class="input-group-append">
                                                <span class="input-group-text">orang</span>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">Minimal jumlah peserta untuk harga promo</small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="durasi_hari" class="col-sm-4 col-form-label">Durasi</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="durasi_hari" name="durasi_hari"
                                                placeholder="Contoh: 3">
                                            <div class="input-group-append">
                                                <span class="input-group-text">hari</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Gambar Cover -->
                                <div class="form-group row">
                                    <label for="gambar_cover" class="col-sm-4 col-form-label">Gambar Cover</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control" name="gambar_cover" id="gambar_cover"
                                            accept="image/*">
                                        <small class="form-text text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB.</small>
                                        <div id="cover-preview" class="mt-2 text-center"></div>
                                    </div>
                                </div>

                                <!-- Gambar Multiple -->
                                <div class="form-group row">
                                    <label for="images" class="col-sm-4 col-form-label">Gambar Lainnya</label>
                                    <div class="col-sm-8">
                                        <input type="file" name="images[]" id="images" class="form-control"
                                            accept="image/*" multiple>
                                        <small class="form-text text-muted">Bisa pilih lebih dari satu gambar.</small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="status" class="col-sm-4 col-form-label">Status Paket <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="status" id="status" class="form-control select2"
                                            style="width: 100%;" required>
                                            <option value="aktif">Aktif</option> <!-- ini otomatis jadi default -->
                                            <option value="nonaktif">Nonaktif</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save mr-1"></i> Simpan
                            </button>
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
        .col-form-label {
            font-weight: 500;
        }

        .card-outline {
            border-top: 3px solid #28a745;
        }

        .input-group-text {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
        }

        .form-text.text-muted {
            font-size: 0.8rem;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('vendor/inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        $(function() {
            // Select2
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            // Currency Input Mask
            $('#harga, #harga_promo').inputmask({
                'alias': 'numeric',
                'groupSeparator': '.',
                'autoGroup': true,
                'digits': 0,
                'digitsOptional': false,
                'prefix': '',
                'placeholder': '0'
            });

            // Preview cover
            $('#gambar_cover').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#cover-preview').html('<img src="' + e.target.result +
                            '" class="img-thumbnail" width="200">');
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Convert harga ke raw number sebelum submit
            $('#holidayForm').on('submit', function() {
                $('#harga').val($('#harga').inputmask('unmaskedvalue'));
                $('#harga_promo').val($('#harga_promo').inputmask('unmaskedvalue'));
            });
        });

        // Dynamic fasilitas
        $(document).on('click', '.add-fasilitas', function() {
            $('#fasilitas-wrapper').append(`
                <div class="input-group mb-2">
                    <input type="text" name="fasilitas[]" class="form-control" placeholder="Masukkan fasilitas">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger remove-fasilitas"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
            `);
        });

        $(document).on('click', '.remove-fasilitas', function() {
            $(this).closest('.input-group').remove();
        });
    </script>
@stop
