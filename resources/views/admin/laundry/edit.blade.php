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
                                <form action="{{ route('admin.laundry.update', $laundryPackage->id) }}" method="POST"
                                    enctype="multipart/form-data" id="laundryForm">

                            @csrf
                            @method('PUT')

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
                                            <input type="text" class="form-control" id="nama_paket" name="nama_paket" value="{{ old('nama_paket', $laundryPackage->nama_paket) }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="jenis" class="col-sm-4 col-form-label">Jenis</label>
                                        <div class="col-sm-8">
                                            <select name="jenis" id="jenis" class="form-control select2" style="width: 100%;">
                                                <option value="Kiloan" {{ old('jenis', $laundryPackage->jenis) == 'Kiloan' ? 'selected' : '' }}>Kiloan</option>
                                                <option value="Satuan" {{ old('jenis', $laundryPackage->jenis) == 'Satuan' ? 'selected' : '' }}>Satuan</option>
                                                <option value="Express" {{ old('jenis', $laundryPackage->jenis) == 'Express' ? 'selected' : '' }}>Express</option>
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
                                                <input type="number" class="form-control" id="harga" name="harga" min="0" step="1" value="{{ old('harga', $laundryPackage->harga) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="periode" class="col-sm-4 col-form-label">Periode (Hari)</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="periode" name="periode" value="{{ old('periode', $laundryPackage->periode) }}" placeholder="Contoh: 7">
                                            <small class="form-text text-muted">Isi dengan angka jumlah hari (contoh: 7 untuk seminggu)</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="deskripsi" class="col-sm-4 col-form-label">Deskripsi</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Tuliskan detail paket laundry...">{{ old('deskripsi', $laundryPackage->deskripsi) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="thumbnail" class="col-sm-4 col-form-label">Thumbnail</label>
                                        <div class="col-sm-8">
                                            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                                            @if ($laundryPackage->thumbnail)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $laundryPackage->thumbnail) }}" alt="Thumbnail" class="img-fluid rounded" style="max-height: 120px;">
                                                </div>
                                            @endif
                                            <small class="text-muted">Upload gambar thumbnail baru jika ingin mengganti</small>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="status" class="col-sm-4 col-form-label">Status Paket <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <select name="status" id="status" class="form-control select2" style="width: 100%;" required>
                                                <option value="aktif" {{ old('status', $laundryPackage->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="nonaktif" {{ old('status', $laundryPackage->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="form-group text-right mt-4">
                                <a href="{{ route('admin.laundry.index') }}" class="btn btn-secondary mr-2">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save mr-1"></i> Perbarui
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
    @stop

    @section('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    theme: 'bootstrap4'
                });


            });
        </script>
    @stop
