
@extends('pages.components.app-admin')

@include('partials.datatable')

<div class="row">
    <div class="col-md-2">
    </div>

    <div class="col-md-10">
        <div class="container">
            <div class="row">
                <div class="card mb-4 mt-4">
                    <div class="card-body">
                        <h5 class="mb-4">Daftar Peminjam Barang Habis Pakai</h5>

                        <div class="table-responsive">
                            <div class="">
                                <a href="{{ route('admin.peminjaman-sekali-pakai.create') }}" class="btn text-white"
                                    style="background-color: #042456">Tambah Barang
                                </a>
                            </div>
                            <table class="table table-striped table-bordered" id="myTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Nama Peminjam</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Barang</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Action</th>
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
   var table = initializeDataTable('#myTable', "{{ route('admin.peminjaman-sekali-pakai.index') }}", [
    {
        data: 'nama_peminjam',
        name: 'nama_peminjam'
    }, 
    {
        data: 'nama_barang',
        name: 'nama_barang'
    },
    {
        data: 'jml_barang',
        name: 'jml_barang'
    },
    {
        data: 'tanggal_pinjam',
        name: 'tanggal_pinjam'
    },
    {
        data: 'actions',
        name: 'actions',
        orderable: false,
        searchable: false
    }
]);


    window.deletePeminjaman = function(id) {
        if (confirm('Are you sure you want to delete this items?')) {
            $.ajax({
                url: '{{ route('admin.peminjaman-sekali-pakai.destroy', ':id') }}'.replace(':id', id),
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
