@extends('adminlte::page')

@section('title', 'Manajemen Customer Service')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

{{-- 3. Menggunakan content_header untuk judul yang konsisten --}}
@section('content_header')
<a href="{{ route('admin.customer_services.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Tambah Rekening
</a>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Customer Service</h3>
                <div class="card-tools">
                    {{-- 4. Mengaktifkan kembali tombol Tambah Data dengan ikon --}}
                    {{-- <a href="{{ route('admin.customer_service.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Baru
                    </a> --}}
                </div>
            </div>
            <div class="card-body">
                {{-- 5. Menambahkan ID pada tabel untuk inisialisasi DataTables --}}
                <table id="table_customer_service" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customerServices as $cs)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cs->nama }}</td>
                            <td>{{ $cs->nomor }}</td>
                            <td>
                                <form id="delete-form-{{ $cs->id }}" action="{{ route('admin.customer_services.destroy', $cs->id) }}" method="POST">
                                    {{-- <a href="{{ route('admin.customer_service.edit', $cs->id) }}" class="btn btn-xs btn-warning text-white">
                                        <i class="fas fa-edit"></i> Edit
                                    </a> --}}
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete({{ $cs->id }})">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    // 7. Inisialisasi DataTables
    $(document).ready(function() {
        $('#table_customer_service').DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });

    // 8. Fungsi untuk konfirmasi hapus menggunakan SweetAlert2
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika dikonfirmasi, kirimkan form penghapusan
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endpush
