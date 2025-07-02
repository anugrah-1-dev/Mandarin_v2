@extends('adminlte::page')

@section('title', 'Manajemen Role')

@section('content_header')
    <h1>Daftar Role</h1>
@endsection

@section('content')
    <x-adminlte-button label="Tambah Role" theme="primary" class="mb-3" icon="fas fa-plus" />

    <x-adminlte-card title="List Role" theme="lightblue">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Role</th>
                    <th>Guard</th>
                    <th>Jumlah Permission</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->guard_name }}</td>
                    <td>{{ $role->permissions->count() }}</td>
                    <td>{{ $role->created_at->format('d M Y') }}</td>
                    <td>
                        <x-adminlte-button theme="warning" icon="fas fa-edit" size="sm" />
                        <x-adminlte-button theme="danger" icon="fas fa-trash" size="sm" />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </x-adminlte-card>
@endsection
