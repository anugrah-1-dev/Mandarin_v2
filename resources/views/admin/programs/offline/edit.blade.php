        @extends('adminlte::page')

        @section('title', 'Edit Program Offline')


        @section('content')
            <div class="container mt-4">
                <h3>Edit Program Offline</h3>

                <form action="{{ route('admin.offline.update', $offline->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nama Program --}}
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Program</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                            value="{{ old('nama', $offline->nama) }}">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="program_bahasa">Program Bahasa</label>
                        <select name="program_bahasa" id="program_bahasa" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Bahasa --</option>
                            <option value="inggris" {{ old('program_bahasa', $offline->program_bahasa ?? '') == 'inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                            <option value="jerman" {{ old('program_bahasa', $offline->program_bahasa ?? '') == 'jerman' ? 'selected' : '' }}>Bahasa Jerman</option>
                            <option value="mandarin" {{ old('program_bahasa', $offline->program_bahasa ?? '') == 'mandarin' ? 'selected' : '' }}>Bahasa Mandarin</option>
                            <option value="arab" {{ old('program_bahasa', $offline->program_bahasa ?? '') == 'arab' ? 'selected' : '' }}>Bahasa Arab</option>
                        </select>
                    </div>

                    {{-- Slug --}}
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug"
                            value="{{ old('slug', $offline->slug) }}">
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Lama Program --}}
                    <div class="mb-3">
                        <label for="lama_program" class="form-label">Lama Program</label>
                        <input type="text" class="form-control @error('lama_program') is-invalid @enderror"
                            name="lama_program" value="{{ old('lama_program', $offline->lama_program) }}">
                        @error('lama_program')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <input type="text" class="form-control @error('kategori') is-invalid @enderror" name="kategori"
                            value="{{ old('kategori', $offline->kategori) }}">
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Harga --}}
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga"
                            value="{{ old('harga', $offline->harga) }}">
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Fitur Program --}}
                    <div class="mb-3">
                        <label for="features_program" class="form-label">Fitur Program</label>
                        <textarea class="form-control @error('features_program') is-invalid @enderror" name="features_program" rows="4">{{ old('features_program', $offline->features_program) }}</textarea>
                        @error('features_program')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Lokasi --}}
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi"
                            value="{{ old('lokasi', $offline->lokasi) }}">
                        @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jadwal Mulai --}}
                    <div class="mb-3">
                        <label for="jadwal_mulai" class="form-label">Jadwal Mulai</label>
                        <input type="date" class="form-control @error('jadwal_mulai') is-invalid @enderror"
                            name="jadwal_mulai" value="{{ old('jadwal_mulai', $offline->jadwal_mulai) }}">
                        @error('jadwal_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jadwal Selesai --}}
                    <div class="mb-3">
                        <label for="jadwal_selesai" class="form-label">Jadwal Selesai</label>
                        <input type="date" class="form-control @error('jadwal_selesai') is-invalid @enderror"
                            name="jadwal_selesai" value="{{ old('jadwal_selesai', $offline->jadwal_selesai) }}">
                        @error('jadwal_selesai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kuota --}}
                    <div class="mb-3">
                        <label for="kuota" class="form-label">Kuota</label>
                        <input type="number" class="form-control @error('kuota') is-invalid @enderror" name="kuota"
                            value="{{ old('kuota', $offline->kuota) }}">
                        @error('kuota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status Aktif --}}
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-select @error('is_active') is-invalid @enderror">
                            <option value="1" {{ old('is_active', $offline->is_active) == 1 ? 'selected' : '' }}>Aktif
                            </option>
                            <option value="0" {{ old('is_active', $offline->is_active) == 0 ? 'selected' : '' }}>
                                Nonaktif</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Thumbnail --}}
                    <div class="mb-3">
                        <label class="form-label">Thumbnail</label>
                        @if ($offline->thumbnail)
                            <div class="mb-2">
                                <img src="{{ asset('uploads/thumbnails/' . $offline->thumbnail) }}" alt="Thumbnail"
                                    style="max-width: 200px;">
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="hapus_thumbnail" value="1"
                                    id="hapus_thumbnail">
                                <label class="form-check-label" for="hapus_thumbnail">Hapus thumbnail</label>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                            name="thumbnail">
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.offline.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        @endsection

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
