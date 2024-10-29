
@extends('pages.components.app')

@include('partials.datatable')

@include('pages.user.peminjaman-barang.edit')


<div class="row">
    <div class="col-md-2">
    </div>
    
    <div class="col-md-10">
        <div class="container">
            <div class="row">
                <div class="card mb-4 mt-4">
                    <div class="card-body">
                        <h5 class="mb-4">History Pinjaman</h5>
                        
                        <div class="table-responsive">
                            <div class="">
                                
                                <a href="{{ route('user.peminjaman-barang.create') }}" class="btn text-white" style="background-color: #042456"  data-bs-toggle="modal" data-bs-target="#tambahPeminjamModal">Tambah Peminjaman</a>
                                @include('pages.user.peminjaman-barang.create')
                            

                            </div>
                            <table class="table table-striped table-bordered" id="myTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Siswa</th>
                                        <th>Barang</th> 
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
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

<script>
    var table = initializeDataTable('#myTable', "{{ route('user.peminjaman-barang.index') }}", [
        {
            data: 'siswa',
            name: 'siswa'
        },
        {
            data: 'barang',
            name: 'barang'
        },
        {
            data: 'tanggal_pinjam',
            name: 'tanggal_pinjam'
        },
        {
            data: 'tanggal_kembali',
            name: 'tanggal_kembali'
        },
        {
            data: 'status_pinjam',
            name: 'status_pinjam',
            render: function(data, type, row) {
                var btnClass = data === 'kembali' ? 'btn btn-success' : 'btn btn-primary';
                var statusText = data === 'kembali' ? 'kembali' : 'dipinjam';
                return '<button class="btn ' + btnClass + ' btn-sm">' + statusText + '</button>';
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
        var siswa = $(this).data('siswa');
        var barang = $(this).data('barang');
        var tanggal_pinjam = $(this).data('tanggal_pinjam');
        var tanggal_kembali = $(this).data('tanggal_kembali');
        var status_pinjam = $(this).data('status_pinjam');

        $('#editPeminjamForm').attr('action', "{{ url('user/peminjaman-barang') }}/" + id);

        $('#edit_siswa_id').val(siswa);
        $('#edit_barang_id').val(barang);
        $('#edit_tanggal_pinjam').val(tanggal_pinjam);
        $('#edit_tanggal_kembali').val(tanggal_kembali);
        $('#edit_status_pinjam').val(status_pinjam);

        $('#editPeminjamModal').modal('show');
    });



   

</script>
