
@extends('pages.components.app')

@include('partials.datatable')

<div class="row">
    <div class="col-md-2">
    </div>
    
    <div class="col-md-10">
        <div class="container">
            <div class="row">
                <div class="card mb-4 mt-4">
                    <div class="card-body">
                        <h5 class="mb-4">Daftar Barang</h5>
                        
                        <div class="table-responsive">
                            <div class="">
                                <a href="{{ route('user.daftar-barang.create') }}" class="btn text-white" style="background-color: #042456">Tambah Barang</a>
                            </div>
                            <table class="table table-striped table-bordered" id="myTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Merk Barang</th>
                                        <th>Kategori Barang</th>
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
    var table = initializeDataTable('#myTable', "{{ route('user.daftar-barang.index') }}", [
        {
            data: 'kode_barang',
            name: 'kode_barang'
        },
        {
            data: 'nama_barang',
            name: 'nama_barang'
        },
        {
            data: 'merk_barang',
            name: 'merk_barang'
        },
        {
            data: 'kategori_barang',
            name: 'kategori_barang'
        },
        {
            data: 'jumlah_barang',
            name: 'jumlah_barang'
        },
        {
            data: 'actions',
            name: 'actions',
            orderable: false,
            searchable: false
        }

    ]);

    window.deleteBarang = function(id) {
        if (confirm('Are you sure you want to delete this barang?')) {
            $.ajax({
                url: '{{ route('user.daftar-barang.destroy', ':id') }}'.replace(':id', id),
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
