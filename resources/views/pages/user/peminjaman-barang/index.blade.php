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

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="flex-column">
                                    <a href="{{ route('user.peminjaman-barang.create') }}" class="btn text-white"
                                        style="background-color: #042456" data-bs-toggle="modal"
                                        data-bs-target="#tambahPeminjamModal">Tambah Peminjaman</a>

                                    <form action="{{ route('download.pdf') }}" method="GET" class="d-inline">
                                        <label for="date">Pilih Tanggal:</label>
                                        <input type="date" id="date" name="date"
                                            max="{{ now()->toDateString() }}" value="{{ now()->toDateString() }}">
                                        <button type="submit" class="btn text-white" style="background-color: #9d0000">
                                            Download <i class="bi bi-file-earmark-pdf-fill"></i>
                                        </button>
                                    </form>

                                </div>
                                @include('pages.user.peminjaman-barang.create')



                            </div>
                            <table class="table table-striped table-bordered" id="myTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Siswa</th>
                                        <th>Barang</th>
                                        <th>Ruangan Peminjam</th>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var table = initializeDataTable('#myTable', "{{ route('user.peminjaman-barang.index') }}", [{
            data: 'siswa',
            name: 'siswa'
        },
        {
            data: 'barang',
            name: 'barang'
        },
        {
            data: 'ruangan_peminjam',
            name: 'ruangan_peminjam'
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


    $(document).on('click', '.edit-button', function() {
        var id = $(this).data('id');
        var siswa = $(this).data('siswa');
        var barang = $(this).data('barang');
        var ruangan_peminjam = $(this).data('ruangan_peminjam');
        var tanggal_pinjam = $(this).data('tanggal_pinjam');
        var tanggal_kembali = $(this).data('tanggal_kembali');
        var status_pinjam = $(this).data('status_pinjam');

        $('#editPeminjamForm').attr('action', "{{ url('user/peminjaman-barang') }}/" + id);

        $('#edit_siswa').val(siswa);
        $('#edit_barang_id').val(barang);
        $('#edit_ruangan_peminjam').val(ruangan_peminjam);
        $('#edit_tanggal_pinjam').val(tanggal_pinjam);
        $('#edit_tanggal_kembali').val(tanggal_kembali);
        $('#edit_status_pinjam').val(status_pinjam);

        $('#editPeminjamModal').modal('show');
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tambahPeminjamModal').on('show.bs.modal', function() {
            $('#loading').removeClass('d-none');
            $('#siswa').empty();
            $('#siswa').append('<option value="">Pilih Nama Siswa</option>');

            $.ajax({
                url: '{{ route('peminjaman.fetch') }}',
                type: 'GET',
                success: function(response) {
                    $('#loading').addClass('d-none');
                    if (response.success) {
                        response.data.forEach(function(siswa) {
                            $('#siswa').append('<option value="' + siswa.name +
                                '">' +
                                siswa.name + '</option>');
                        });
                    } else {
                        $('#siswa').append(
                            '<option value="" disabled>Tidak ada siswa tersedia</option>'
                        );
                    }
                },
                error: function(xhr) {
                    console.error('Error fetching data:', xhr.responseText);
                    $('#loading').addClass('d-none');
                }
            });
        });

        $('#createPeminjamanForm').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('user.peminjaman-barang.store') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        localStorage.setItem('status', 'success');
                        localStorage.setItem('message', 'Peminjaman berhasil disimpan.');
                        window.location.reload();
                    } else {
                        localStorage.setItem('status', 'error');
                        localStorage.setItem('message', response.message);
                        window.location.reload();
                    }
                },
                error: function(xhr) {
                    localStorage.setItem('status', 'error');
                    localStorage.setItem('message',
                        'Barang sedang dipinjam.');
                    window.location.reload();
                },
            });
        });

        $(document).ready(function() {
            if (localStorage.getItem('status')) {
                var status = localStorage.getItem('status');
                var message = localStorage.getItem('message');

                if (status === 'success') {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: message,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else if (status === 'error') {
                    Swal.fire({
                        title: 'Gagal!',
                        text: message,
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }

                localStorage.removeItem('status');
                localStorage.removeItem('message');
            }
        });
    });
</script>
