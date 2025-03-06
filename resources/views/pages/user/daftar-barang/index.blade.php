@extends('pages.components.sidebar')

@include('partials.datatable')

@section('content')

    <div class="row fs-6">
        <div class="col-md-1">
        </div>

        <div class="col-md-10">
            <div class="container">
                <div class="row">
                    <div class="card mb-4 mt-4">
                        <div class="card-body">
                            <h5 class="mb-4">Daftar Barang</h5>

                            <div class="table-responsive">
                                <div class="">
                                    <a href="{{ route('user.daftar-barang.create') }}" class="btn text-white"
                                        style="background-color: #042456">Tambah Barang</a>
                                </div>
                                <table class="table table-striped table-bordered" id="myTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Kondisi Barang</th>
                                            <th>Merk Barang</th>
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

    @include('pages.user.daftar-barang.show')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var table = initializeDataTable('#myTable', "{{ route('user.daftar-barang.index') }}", [{
                data: 'kode_barang',
                name: 'kode_barang'
            },
            {
                data: 'nama_barang',
                name: 'nama_barang'
            },
            {
                data: 'kondisi_barang',
                name: 'kondisi_barang'
            },
            {
                data: 'merk_barang',
                name: 'merk_barang'
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

        function showBarangDetail(id) {
            $.ajax({
                url: `/daftar-barang/${id}`,
                type: 'GET',
                success: function(data) {
                    $('#kodeBarang').text(data.kode_barang);
                    $('#namaBarang').text(data.nama_barang);
                    $('#merkBarang').text(data.merk_barang);
                    $('#sumberDana').text(data.sumber_dana);
                    $('#kondisiBarang').text(data.kondisi_barang);
                    $('#deskripsiBarang').text(data.deskripsi_barang);
                    $('#tanggalPengadaan').text(data.tanggal_pengadaan);
                    $('#showBarangModal').modal('show');
                },
                error: function(xhr) {
                    alert('Gagal memuat data barang');
                }
            });
        }

        $(document).on('click', '.show-barang', function() {
            // Ambil ID dan data lainnya dari atribut data
            var id = $(this).data('id');
            var kode_barang = $(this).data('kode_barang');
            var nama_barang = $(this).data('nama_barang');
            var merk_barang = $(this).data('merk_barang');
            var sumber_dana = $(this).data('sumber_dana');
            var kondisi_barang = $(this).data('kondisi_barang');
            var deskripsi_barang = $(this).data('deskripsi_barang');
            var tanggal_pengadaan = $(this).data('tanggal_pengadaan');

            // Kirim data ke modal
            $('#show_kode_barang').text(kode_barang);
            $('#show_nama_barang').text(nama_barang);
            $('#show_merk_barang').text(merk_barang);
            $('#show_sumber_dana').text(sumber_dana);
            $('#show_kondisi_barang').text(kondisi_barang);
            $('#show_deskripsi_barang').text(deskripsi_barang);
            $('#show_tanggal_pengadaan').text(tanggal_pengadaan);

            // Menampilkan modal
            $('#showBarangModal').modal('show');
        });
    </script>

@endsection