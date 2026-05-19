@extends('adminlte::page')

@section('title', 'Tambah Paket Laundry')

@section('content_header')
    <h1 class="m-0 text-dark">Tambah Paket Laundry</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-tshirt mr-2"></i>Form Tambah Paket Laundry</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.laundry.store') }}" method="POST" enctype="multipart/form-data" id="laundryForm">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="nama_paket" class="col-sm-4 col-form-label">Nama Paket <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nama_paket" name="nama_paket" placeholder="Contoh: Paket Kiloan" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="jenis" class="col-sm-4 col-form-label">Jenis</label>
                                    <div class="col-sm-8">
                                        <select name="jenis" id="jenis" class="form-control select2" style="width: 100%;">
                                            <option value="Kiloan">Kiloan</option>
                                            <option value="Satuan">Satuan</option>
                                            <option value="Express">Express</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="harga" class="col-sm-4 col-form-label">Harga <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" class="form-control" id="harga" name="harga" placeholder="0" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="periode" class="col-sm-4 col-form-label">Periode</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="periode" name="periode" placeholder="Contoh: 7 (hari)">
                                        <small class="form-text text-muted">Isi dengan angka hari/minggu jika ada</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="deskripsi" class="col-sm-4 col-form-label">Deskripsi</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Tuliskan detail paket laundry..."></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="thumbnail" class="col-sm-4 col-form-label">Thumbnail</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                                        <small class="text-muted">Upload gambar thumbnail (opsional)</small>
                                    </div>
                                </div>
                                

                                <div class="form-group row">
                                    <label for="status" class="col-sm-4 col-form-label">Status Paket <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="status" id="status" class="form-control select2" style="width: 100%;" required>
                                            <option value="aktif">Aktif</option>
                                            <option value="nonaktif">Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="form-group text-right mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css">
    <style>
        .col-form-label {
            font-weight: 500;
        }
        .card-outline {
            border-top: 3px solid #007bff;
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
    <script>
        $(function() {
            // Select2
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            // Currency Input Mask
            $('#harga').inputmask({
                'alias': 'numeric',
                'groupSeparator': '.',
                'autoGroup': true,
                'digits': 0,
                'digitsOptional': false,
                'prefix': '',
                'placeholder': '0'
            });

            // Convert harga sebelum submit
            $('#laundryForm').on('submit', function() {
                var harga = $('#harga').val().replace(/[^\d]/g, '');
                $('#harga').val(harga);
            });
        });
    </script>
@stop
