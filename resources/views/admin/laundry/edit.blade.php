@extends('adminlte::page')

@section('title', 'Edit Paket Laundry')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Paket Laundry</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-soap mr-2"></i>Form Edit Paket Laundry</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.laundry.update', $laundryPackage->id) }}"
                      method="POST"
                      id="laundryForm">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-warning card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-tshirt mr-2"></i>
                                        Data Paket Laundry
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <!-- Nama Paket -->
                                    <div class="form-group row">
                                        <label for="nama_paket" class="col-sm-3 col-form-label">Nama Paket <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="nama_paket" name="nama_paket"
                                                   value="{{ old('nama_paket', $laundryPackage->nama_paket) }}" required>
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
                                                       value="{{ old('harga', $laundryPackage->harga) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Jenis -->
                                    <div class="form-group row">
                                        <label for="jenis" class="col-sm-3 col-form-label">Jenis</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="jenis" name="jenis"
                                                   value="{{ old('jenis', $laundryPackage->jenis) }}"
                                                   placeholder="Contoh: Kiloan, Satuan">
                                        </div>
                                    </div>

                                    <!-- Periode -->
                                    <div class="form-group row">
                                        <label for="periode" class="col-sm-3 col-form-label">Periode</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" id="periode" name="periode" style="width: 100%;">
                                                <option value="">-- Pilih Periode --</option>
                                                <option value="1" {{ old('periode', $laundryPackage->periode) == 1 ? 'selected' : '' }}>Harian</option>
                                                <option value="2" {{ old('periode', $laundryPackage->periode) == 2 ? 'selected' : '' }}>Mingguan</option>
                                                <option value="3" {{ old('periode', $laundryPackage->periode) == 3 ? 'selected' : '' }}>Bulanan</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- <!-- Tanggal Penjemputan -->
                                    <div class="form-group row">
                                        <label for="tanggal_penjemputan" class="col-sm-3 col-form-label">Tanggal Penjemputan</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" id="tanggal_penjemputan" name="tanggal_penjemputan"
                                                   value="{{ old('tanggal_penjemputan', $laundryPackage->tanggal_penjemputan) }}">
                                        </div>
                                    </div> --}}

                                    <!-- Status -->
                                    <div class="form-group row">
                                        <label for="status" class="col-sm-3 col-form-label">Status <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select name="status" id="status" class="form-control select2" style="width: 100%;" required>
                                                <option value="aktif" {{ old('status', $laundryPackage->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="nonaktif" {{ old('status', $laundryPackage->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Deskripsi -->
                                    <div class="form-group row">
                                        <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                                        <div class="col-sm-9">
                                            <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control"
                                                      placeholder="Tuliskan deskripsi paket">{{ old('deskripsi', $laundryPackage->deskripsi) }}</textarea>
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
                                <a href="{{ route('admin.laundry.index') }}" class="btn btn-secondary mr-2">
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
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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

            // Convert currency ke angka sebelum submit
            $('#laundryForm').on('submit', function() {
                var harga = $('#harga').inputmask('unmaskedvalue');
                $('#harga').val(harga);
            });
        });
    </script>
@stop
