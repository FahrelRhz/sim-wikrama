@extends('pages.components.sidebar-admin')

@include('partials.datatable')

@include('pages.admin.alat-barang.edit')

@section('content')
    <div class="row fs-6">
        <div class="col-md-1">
        </div>

        <div class="col-md-10">
            <div class="container">
                <div class="row">
                    <div class="card mb-4 mt-4">
                        <div class="card-body">
                            <h5 class="mb-4">Daftar Alat dan Barang</h5>

                            <div class="table-responsive">
                                <div class="">
                                    <a href="{{ route('admin.alat-barang.create') }}" class="btn text-white"
                                        style="background-color: #042456" >Tambah Alat/Barang
                                    </a>
                                   
                                </div>
                                <table class="table table-striped table-bordered" id="myTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Jenis</th>
                                            <th>Merk Barang</th>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah Harga</th>
                                            <th>Keterangan</th>
                                            <th>Link Siplah</th>
                                            <th>Aksi</th>
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
        var table = initializeDataTable('#myTable', "{{ route('admin.alat-barang.index') }}", [{
                data: 'jenis',
                name: 'jenis'
            },
            {
                data: 'barang_merk',
                name: 'barang_merk'
            },
            {
                data: 'volume',
                name: 'volume'
            },
            {
                data: 'satuan',
                name: 'satuan'
            },
            {
                data: 'harga_satuan',
                name: 'harga_satuan'
            },
            {
                data: 'jumlah_harga',
                name: 'jumlah_harga'
            },
            {
                data: 'keterangan',
                name: 'keterangan'
            },
            {
                data: 'link_siplah',
                name: 'link_siplah'
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]);

        window.deleteAlatBarang = function(id) {
            if (confirm('Apakah kamu yakin untuk menghapus Alat atau Barang?')) {
                $.ajax({
                    url: '{{ route('admin.alat-barang.destroy', ':id') }}'.replace(':id', id),
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
                        alert('Error deleting user: ' + xhr.responseText);
                    }
                });
            }
        }
    </script>
@endsection
