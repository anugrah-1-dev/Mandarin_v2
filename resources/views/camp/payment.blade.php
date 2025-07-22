@extends('layouts.app') {{-- atau layoutmu --}}
@section('title', 'Pembayaran Camp')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Pembayaran Program Camp</h2>

    {{-- Informasi Pendaftaran --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5>Data Pendaftaran</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Nama:</strong> {{ $pendaftaran->nama_lengkap }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $pendaftaran->email }}</li>
                <li class="list-group-item"><strong>No HP:</strong> {{ $pendaftaran->no_hp }}</li>
                <li class="list-group-item"><strong>Asal Kota:</strong> {{ $pendaftaran->asal_kota }}</li>
                <li class="list-group-item"><strong>Durasi Paket:</strong> {{ $pendaftaran->durasi_paket }}</li>
                <li class="list-group-item"><strong>Nama Kamar:</strong> {{ $pendaftaran->nama_kamar }}</li>
            </ul>
        </div>
    </div>

    {{-- Form Upload Bukti Pembayaran --}}
    <div class="card">
        <div class="card-body">
            <h5>Upload Bukti Pembayaran</h5>
            <form action="{{ route('camp.pembayaran.submit', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <x-adminlte-select name="bank_id" label="Pilih Bank Tujuan" required>
                    <option value="">-- Pilih Bank --</option>
                    @foreach ($banks as $bank)
                        <option value="{{ $bank->id }}">
                            {{ $bank->name }} a.n {{ $bank->owner }} ({{ $bank->number }})
                        </option>
                    @endforeach
                </x-adminlte-select>
                @error('bank_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <div class="form-group mt-3">
                    <label for="bukti_pembayaran">Upload Bukti (JPG, PNG, PDF)</label>
                    <input type="file" class="form-control" name="bukti_pembayaran" required>
                    @error('bukti_pembayaran')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mt-3">Kirim Pembayaran</button>
            </form>
        </div>
    </div>
</div>
@endsection
