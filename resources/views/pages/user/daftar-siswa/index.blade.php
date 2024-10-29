
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
                        <h5 class="mb-4">Daftar Siswa</h5>
                        
                        <div class="table-responsive">
                            <div class="">
                                <a href="{{ route('user.daftar-siswa.create') }}" class="btn text-white" style="background-color: #042456">Tambah Siswa</a>
                            </div>
                            <table class="table table-striped table-bordered" id="myTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Rombel</th>
                                        <th>Rayon</th>
                                        <th>Jurusan</th>
                                        <th>Actions</th>
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
    var table = initializeDataTable('#myTable', "{{ route('user.daftar-siswa.index') }}", [
        {
            data: 'nis',
            name: 'nis'
        },
        {
            data: 'nama_siswa',
            name: 'nama_siswa'
        },
        {
            data: 'rombel',
            name: 'rombel'
        },
        {
            data: 'rayon',
            name: 'rayon'
        },
        {
            data: 'jurusan',
            name: 'jurusan'
        },
        {
            data: 'actions',
            name: 'actions',
            orderable: false,
            searchable: false
        }

    ]);

    window.deleteSiswa = function(id) {
        if (confirm('Are you sure you want to delete this siswa?')) {
            $.ajax({
                url: '{{ route('user.daftar-siswa.destroy', ':id') }}'.replace(':id', id),
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
                    alert('Error deleting siswa: ' + xhr.responseText); 
                }
            });
        }
    }

</script>
