@extends('pages.components.sidebar')

@include('partials.datatable')

{{-- @include('pages.admin.peminjaman-alat-barang.edit') --}}

@section('content')

    <div class="row fs-6">
        <div class="col-md-1">
        </div>

        <div class="col-md-10">
            <div class="container">
                <div class="row">
                    <div class="card mb-4 mt-4">
                        <div class="card-body">
                            <h5 class="mb-4">Daftar Peminjaman Alat dan Barang</h5>
                            <div class="table-responsive">
                                <div class="">

                                    @if ($errors->any())
                                        <div class="alert alert-danger">`
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="flex-column">
                                        <a href="" class="btn text-white"
                                            style="background-color: #042456" data-bs-toggle="modal"
                                            data-bs-target="#tambahPeminjamanAlatBarangModal">Tambah Peminjaman</a>
                                    </div>
                                    {{-- @include('pages.admin.peminjaman-alat-barang.create') --}}
                                </div>
                                <table class="table table-striped table-bordered" id="myTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Nama Peminjam</th>
                                            <th>Alat/Barang</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Tanggal Kembali</th>
                                            <th>Ruangan Peminjam</th>
                                            <th>Keperluan</th>
                                            <th>Status</th>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var table = initializeDataTable('#myTable', "{{ route('admin.peminjaman-alat-barang.index') }}", [{
                data: 'nama_peminjam',
                name: 'nama_peminjam'
            },
            {
                data: 'alat_barang_id',
                name: 'alat_barang_id'
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
                data: 'ruangan_peminjam',
                name: 'ruangan_peminjam'
            },
            {
                data: 'keperluan',
                name: 'keperluan'
            },
            {
                data: 'status_pinjam',
                name: 'status_pinjam',
                render: function(data, type, row) {
                    var btnStyle;
                    var statusText;

                    if (data === 'dipinjam') {
                        btnStyle = 'background-color: #f8d7da; color: #721c24;';
                        statusText = 'Dipinjam';
                    } else if (data === 'kembali') {
                        btnStyle = 'background-color: #d4edda; color: #155724;';
                        statusText = 'Kembali';
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

        // $(document).on('click', '.edit-button', function() {
        //     var id = $(this).data('id');
        //     var nama_peminjam = $(this).data('nama_peminjam');
        //     var alat_barang_id = $(this).data('alat_barang_id');
        //     var tanggal_pinjam = $(this).data('tanggal_pinjam');
        //     var tanggal_kembali = $(this).data('tanggal_kembali');
        //     var ruangan_peminjam = $(this).data('ruangan_peminjam');
        //     var keperluan = $(this).data('keperluan');
        //     var status_pinjam = $(this).data('status_pinjam');

        //     $('#editPeminjamanAlatBarangForm').attr('action', "{{ url('admin/peminjaman-alat-barang') }}/" + id);

        //     $('#edit_nama_peminjam').val(nama_peminjam);
        //     $('#edit_alat_barang_id').val(alat_barang_id);
        //     $('#edit_tanggal_pinjam').val(tanggal_pinjam);
        //     $('#edit_tanggal_kembali').val(tanggal_kembali);
        //     $('#edit_ruangan_peminjam').val(ruangan_peminjam);
        //     $('#edit_keperluan').val(keperluan);
        //     $('#edit_status_pinjam').val(status_pinjam);

        //     $('#editPeminjamAlatBarangModal').modal('show');
        // });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        
    </script>

@endsection
