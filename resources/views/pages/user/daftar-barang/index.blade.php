
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    function deleteBarang(id) {
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
                    url: '{{ route('user.daftar-barang.destroy', ':id') }}'.replace(':id', id),
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
                            text: 'Gagal menghapus barang: ' + xhr.responseText,
                        });
                    }
                });
            }
        });
    }
</script>

