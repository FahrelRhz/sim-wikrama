@extends('pages.components.app-admin')

@include('partials.datatable')

@include('pages.admin.permintaan-barang.edit')


<div class="row">
    <div class="col-md-2">
    </div>


    <div class="col-md-10">
        <div class="container">
            <div class="row">
                <div class="card mb-4 mt-4">
                    <div class="card-body">
                        <h5 class="mb-4">Permintaan</h5>

                        <div class="table-responsive">
                            <div class="">

                            </div>
                            <table class="table table-striped table-bordered" id="myTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Barang</th>
                                        <th>Nama Peminta</th>
                                        <th>Tanggal Permintaan</th>
                                        <th>Alasan Permintaan</th>
                                        <th>Status</th>
                                        <th></th>
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
    var table = initializeDataTable('#myTable', "{{ route('admin.permintaan-barang.index') }}", [{
            data: 'barang',
            name: 'barang'
        },
        {
            data: 'user',
            name: 'user'
        },
        {
            data: 'tanggal_permintaan',
            name: 'tanggal_permintaan'
        },
        {
            data: 'alasan_permintaan',
            name: 'alasan_permintaan'
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
                } else if (data === 'ACC') {
                    btnStyle = 'background-color: #d4edda; color: #155724;';
                    statusText = 'Selesai';
                } else {
                    btnStyle = 'background-color: #f1f1f1; color: #000;';
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
</script>
<script>
    $(document).on('click', '.edit-button', function() {
        var id = $(this).data('id');
        var barang = $(this).data('barang');
        var user_id = $(this).data('user-id');
        var tanggal_permintaan = $(this).data('tanggal-permintaan');
        var alasan_permintaan = $(this).data('alasan-permintaan');
        var status = $(this).data('status')

        $('#editPermintaanBarangForm').attr('action', "/admin/permintaan-barang/" + id);

        $('#edit_barang').val(barang);
        $('#edit_user_id').val(user_id);
        $('#edit_tanggal_permintaan').val(tanggal_permintaan);
        $('#edit_alasan_permintaan').val(alasan_permintaan);
        $('#status').val(status);


        $('#editPermintaanBarangModal').modal('show');
    });

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    function deletePermintaan(id) {
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
                    url: '{{ route('admin.permintaan-barang.destroy', ':id') }}'.replace(':id', id),
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
