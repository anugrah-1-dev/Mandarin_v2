@extends('adminlte::page')

@section('title', 'Manajemen User')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Daftar User</h1>
        <x-adminlte-button label="Tambah User" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#createUserModal" />
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card theme="lightblue" theme-mode="outline" title="List User">

                <!-- Search and Filter Section -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan nama/email...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="roleFilter">
                            <option value="">Semua Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- User Table -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="usersTable">
                        <thead class="bg-lightblue">
                            <tr>
                                <th width="5%">ID</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th width="15%">Dibuat</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user mr-2 text-lightblue"></i>
                                        <strong>{{ $user->name }}</strong>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge badge-info">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ $user->created_at->format('d M Y') }}
                                    <br>
                                    <small class="text-muted">
                                        {{ $user->created_at->diffForHumans() }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <x-adminlte-button theme="info" icon="fas fa-eye"
                                            onclick="window.location='{{ route('admin.users.show', $user->id) }}'" title="Detail"/>
                                        <x-adminlte-button theme="warning" icon="fas fa-edit"
                                            onclick="window.location='{{ route('admin.users.edit', $user->id) }}'" title="Edit"/>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <x-adminlte-button theme="danger" icon="fas fa-trash"
                                                onclick="confirmDelete(event)" title="Hapus"/>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada user.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator && $users->hasPages())
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="dataTables_info">
                            Menampilkan {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari {{ $users->total() }} entri
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="float-right">
                            {{ $users->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                @endif
            </x-adminlte-card>
        </div>
    </div>

    <!-- Create User Modal -->
    <x-adminlte-modal id="createUserModal" title="Tambah User Baru" theme="lightblue" size="lg">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="name" label="Nama" placeholder="Masukkan nama user" required/>
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="email" label="Email" type="email" placeholder="Masukkan email user" required/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="password" label="Password" type="password" placeholder="Password" required/>
                </div>
                <div class="col-md-6">
                    <x-adminlte-select name="roles[]" label="Role" multiple>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button theme="secondary" label="Batal" data-dismiss="modal"/>
                <x-adminlte-button type="submit" theme="primary" label="Simpan" icon="fas fa-save"/>
            </x-slot>
        </form>
    </x-adminlte-modal>
@stop

@section('css')
    <style>
        .progress-group {
            display: flex;
            flex-direction: column;
        }
        .progress-number {
            font-size: 0.8rem;
            margin-top: 2px;
        }
        .table thead th {
            vertical-align: middle;
        }
        .badge {
            font-size: 90%;
            padding: 5px 8px;
        }
        .btn-group-sm .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.765625rem;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Confirm delete
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "User ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        // Search and filter functionality
        $(document).ready(function() {
            $('#searchInput, #roleFilter').on('keyup change', function() {
                const searchValue = $('#searchInput').val().toLowerCase();
                const roleValue = $('#roleFilter').val();
                $('#usersTable tbody tr').each(function() {
                    const rowText = $(this).text().toLowerCase();
                    let roleMatch = true;
                    if (roleValue) {
                        roleMatch = $(this).find('td:eq(3)').text().includes(roleValue);
                    }
                    const searchMatch = searchValue === '' || rowText.includes(searchValue);
                    $(this).toggle(searchMatch && roleMatch);
                });
            });
        });
    </script>
@stop
