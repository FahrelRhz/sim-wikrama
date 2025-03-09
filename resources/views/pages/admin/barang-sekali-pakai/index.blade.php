@extends('pages.components.sidebar-admin')

@include('partials.datatable')

@include('pages.admin.barang-sekali-pakai.edit')

@section('content')
    <div class="row fs-6">
        <div class="col-md-1">
        </div>

        <div class="col-md-10">
            <div class="container">
                <div class="row">
                    <div class="card mb-4 mt-4">
                        <div class="card-body">
                            <h5 class="mb-4">Daftar Barang Habis Pakai</h5>

                            <div class="table-responsive">
                                <div class="">
                                    <a href="{{ route('admin.barang-sekali-pakai.create') }}" class="btn text-white"
                                        style="background-color: #042456" data-bs-toggle="modal"
                                        data-bs-target="#tambahBarangModal">Tambah Barang
                                    </a>
                                    @include('pages.admin.barang-sekali-pakai.create')
                                </div>
                                <table class="table table-striped table-bordered" id="myTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Jumlah Barang</th>
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

    <script>
        var table = initializeDataTable('#myTable', "{{ route('admin.barang-sekali-pakai.index') }}", [{
                data: 'nama_barang',
                name: 'nama_barang'
            },
            {
                data: 'jml_barang',
                name: 'jml_barang'
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: true,
                searchable: true
            }
        ]);

        $(document).on('click', '.edit-button', function() {
            var id = $(this).data('id');
            var nama_barang = $(this).data('nama_barang');
            var jml_barang = $(this).data('jml_barang');

            $('#editBarangForm').attr('action', "/admin/barang-sekali-pakai/" + id);
            $('#edit_nama_barang').val(nama_barang);
            $('#edit_jml_barang').val(jml_barang);
            $('#editBarangModal').modal('show');
        });

        window.deleteBarang = function(id) {
            if (confirm('Are you sure you want to delete this items?')) {
                $.ajax({
                    url: '{{ route('admin.barang-sekali-pakai.destroy', ':id') }}'.replace(':id', id),
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                        table.ajax.reload(null, false);
                        alert(response.success);
                    },
                    error: function(xhr) {
                        alert('Error deleting item: ' + xhr.responseText);
                    }
                });
            }
        }
    </script>
@endsection
