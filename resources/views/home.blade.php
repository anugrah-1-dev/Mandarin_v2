@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard Admin</h1>
@endsection

@section('content')
    <!-- Konten utama di sini -->
    <div class="row mt-4">
        <div class="col-md-3">
            <x-adminlte-info-box title="Total Pengguna" text="124" icon="fas fa-users" theme="info"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Pelatihan Aktif" text="12" icon="fas fa-box" theme="success"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Jadwal Hari Ini" text="3" icon="fas fa-calendar-day" theme="warning"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Pesan Masuk" text="7" icon="fas fa-envelope" theme="danger"/>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/custom.css">
@endsection

@section('js')
    <script>console.log('Halaman Dashboard dimuat.');</script>
@endsection
