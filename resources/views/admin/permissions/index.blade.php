@extends('adminlte::page')

@section('title', 'Manajemen Permission')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Daftar Permission</h1>
        <x-adminlte-button label="Tambah Permission" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#createPermissionModal" />
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card theme="lightblue" theme-mode="outline" title="List Permission">

                <!-- Search and Filter Section -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="searchPermissionInput" class="form-control" placeholder="Cari permission...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="guardFilter">
                            <option value="">Semua Guard</option>
                            @foreach($permissions->pluck('guard_name')->unique() as $guard)
                                <option value="{{ $guard }}">{{ $guard }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Permission Table -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="permissionsTable">
                        <thead class="bg-lightblue">
                            <tr>
                                <th width="5%">#</th>
                                <th>Nama Permission</th>
                                <th>Guard</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permissions as $permission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->guard_name }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <x-adminlte-button theme="warning" icon="fas fa-edit"
                                            onclick="window.location='{{ route('permissions.edit', $permission->id) }}'" title="Edit"/>
                                        <form method="POST" action="{{ route('permissions.destroy', $permission->id) }}" class="d-inline">
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
                                <td colspan="4" class="text-center">Tidak ada data permission.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($permissions instanceof \Illuminate\Pagination\LengthAwarePaginator && $permissions->hasPages())
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="dataTables_info">
                            Menampilkan {{ $permissions->firstItem() }} sampai {{ $permissions->lastItem() }} dari {{ $permissions->total() }} entri
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="float-right">
                            {{ $permissions->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                @endif
            </x-adminlte-card>
        </div>
    </div>

    <!-- Create Permission Modal -->
    <x-adminlte-modal id="createPermissionModal" title="Tambah Permission Baru" theme="lightblue" size="md">
        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
            <x-adminlte-input name="name" label="Nama Permission" placeholder="Masukkan nama permission" required/>
            <x-adminlte-select name="guard_name" label="Guard" required>
                <option value="web">web</option>
                <option value="api">api</option>
            </x-adminlte-select>
            <x-slot name="footerSlot">
                <x-adminlte-button theme="secondary" label="Batal" data-dismiss="modal"/>
                <x-adminlte-button type="submit" theme="primary" label="Simpan" icon="fas fa-save"/>
            </x-slot>
        </form>
    </x-adminlte-modal>
@stop

@section('css')
    <style>
        .table thead th {
            vertical-align: middle;
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
                text: "Permission ini akan dihapus permanen!",
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
            $('#searchPermissionInput, #guardFilter').on('keyup change', function() {
                const searchValue = $('#searchPermissionInput').val().toLowerCase();
                const guardValue = $('#guardFilter').val();
                $('#permissionsTable tbody tr').each(function() {
                    const rowText = $(this).text().toLowerCase();
                    let guardMatch = true;
                    if (guardValue) {
                        guardMatch = $(this).find('td:eq(2)').text().includes(guardValue);
                    }
                    const searchMatch = searchValue === '' || rowText.includes(searchValue);
                    $(this).toggle(searchMatch && guardMatch);
                });
            });
        });
    </script>
@stop
