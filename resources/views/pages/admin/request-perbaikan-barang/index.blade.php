@extends('pages.components.app-admin')

@include('partials.datatable')

@include('pages.admin.request-perbaikan-barang.edit')

{{-- <style>
    .btn {
        background-color: #e0d100;
    }
</style> --}}


<div class="row">
    <div class="col-md-2">
    </div>


    <div class="col-md-10">
        <div class="container">
            <div class="row">
                <div class="card mb-4 mt-4">
                    <div class="card-body">
                        <h5 class="mb-4">Permintaan Perbaikan Barang</h5>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="myTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Barang</th>
                                        <th>Nama Peminta</th>
                                        <th>Tanggal Permintaan</th>
                                        <th>Deskripsi Kerusakan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var table = initializeDataTable('#myTable', "{{ route('admin.request-perbaikan-barang.index') }}", [{
            data: 'barang',
            name: 'barang'
        },
        {
            data: 'user',
            name: 'user'
        },
        {
            data: 'tanggal_request',
            name: 'tanggal_request'
        },
        {
            data: 'deskripsi_kerusakan',
            name: 'deskripsi_kerusakan'
        },
        {
            data: 'status',
            name: 'status',
            render: function(data, type, row) {
                var btnStyle;
                var statusText;

                if (data === 'Pending') {
                    btnStyle = 'background-color: #f8d7da; color: #721c24;';
                    statusText = 'Pending';
                } else if (data === 'Dalam Perbaikan') {
                    btnStyle = 'background-color: #fff4b1; color: #a67c00;';
                    statusText = 'Dalam Perbaikan';
                } else if (data === 'Selesai') {
                    btnStyle = 'background-color: #d4edda; color: #155724;';
                    statusText = 'Selesai';
                } else {
                    btnStyle = 'background-color: #e2e3e5; color: #383d41;';
                    statusText = 'Tidak Diketahui';
                }

                return '<button class="btn btn-sm" style="' + btnStyle + '">' + statusText + '</button>';
            }
        },


        {
            data: 'actions',
            name: 'actions',
            orderable: false,
            searchable: false
        }

    ]);


    $(document).on('click', '.edit-button', function() {
        var id = $(this).data('id');
        var barang_id = $(this).data('barang-id');
        var user_id = $(this).data('user-id');
        var status = $(this).data('status')
        var tanggal_request = $(this).data('tanggal-request');
        var deskripsi_kerusakan = $(this).data('deskripsi-kerusakan');

        $('#editRequestPerbaikanBarangForm').attr('action', "/admin/request-perbaikan-barang/" + id);

        $('#edit_barang_id').val(barang_id);
        $('#edit_user_id').val(user_id);
        $('#status').val(status);
        $('#edit_tanggal_request').val(tanggal_request);
        $('#edit_deskripsi_kerusakan').val(deskripsi_kerusakan);


        $('#editRequestPerbaikanBarangModal').modal('show');
    });
</script>
<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    function deleteRequestPerbaikanBarang(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang sudah dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('admin.request-perbaikan-barang.destroy', ':id') }}'.replace(':id',
                        id),
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#myTable').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal menghapus permintaan: ' + xhr.responseText,
                        });
                    }
                });
            }
        });
    }
</script>
