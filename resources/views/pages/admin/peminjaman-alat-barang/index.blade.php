@extends('pages.components.sidebar-admin')

@include('partials.datatable')

@include('pages.admin.peminjaman-alat-barang.edit')

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
                                        <a href="{{ route('admin.peminjaman-alat-barang.create') }}" class="btn text-white"
                                            style="background-color: #042456" data-bs-toggle="modal"
                                            data-bs-target="#tambahPeminjamanAlatBarangModal">Tambah
                                            Peminjaman</a>
                                        <form action="{{ route('admin.peminjaman-alat-barang.pdf') }}" method="GET"
                                            class="d-inline">
                                            <label for="month">Pilih Tanggal:</label>
                                            <input type="month" id="month" name="date"
                                                max="{{ now()->format('m-Y') }}" value="{{ now()->format('m-Y') }}">
                                            <button type="submit" class="btn text-white" style="background-color: #9d0000">
                                                Download <i class="bi bi-file-earmark-pdf-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                    @include('pages.admin.peminjaman-alat-barang.create')
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

        $(document).on('click', '.edit-button', function() {
            var id = $(this).data('id');
            // var namaPeminjam = $(this).data('nama_peminjam');
            // var alatBarangId = $(this).data('alat_barang_id');
            var tanggalPinjam = $(this).data('tanggal_pinjam');
            var tanggalKembali = $(this).data('tanggal_kembali');
            // var ruanganPeminjam = $(this).data('ruangan_peminjam');
            // var keperluan = $(this).data('keperluan');
            var statusPinjam = $(this).data('status_pinjam');

            // Set form action
            $('#editPeminjamanAlatBarangForm').attr('action', "{{ url('admin/peminjaman-alat-barang') }}/" + id);

            // Isi data ke input form
            // $('#edit_nama_peminjam').val(namaPeminjam);
            // $('#edit_alat_barang_id').val(alatBarangId);
            $('#edit_tanggal_pinjam').val(tanggalPinjam);
            $('#edit_tanggal_kembali').val(tanggalKembali);
            // $('#edit_ruangan_peminjam').val(ruanganPeminjam);
            // $('#edit_keperluan').val(keperluan);
            $('#edit_status_pinjam').val(statusPinjam);

            // Tampilkan modal
            $('#editPeminjamanAlatBarangModal').modal('show');
        });
    </script>
    <script>
        $(document).ready(function() {
            function fetchNamaPeminjam(target) {
                $(target).empty().append('<option value="">Pilih Nama Peminjam</option>');

                $.get('{{ route('admin.daftar-peminjam.fetch') }}', function(response) {
                    if (Array.isArray(response) && response.length) {
                        response.forEach(item => {
                            $(target).append(
                                `<option value="${item.nama_peminjam}">${item.nama_peminjam}</option>`
                            );
                        });
                    } else {
                        $(target).append('<option value="" disabled>Tidak ada nama peminjam</option>');
                    }
                }).fail(xhr => console.error('Error fetching data:', xhr.responseText));
            }

            $('#tambahPeminjamanAlatBarangModal').on('show.bs.modal', function() {
                fetchNamaPeminjam('#nama_peminjam_tambah');
            });

            $('#editPeminjamanAlatBarangModal').on('show.bs.modal', function() {
                fetchNamaPeminjam('#nama_peminjam_edit');
            });

            $('#createPeminjamanAlatBarangForm').submit(function(e) {
                e.preventDefault();

                $.post('{{ route('admin.peminjaman-alat-barang.store') }}', $(this).serialize())
                    .done(function(response) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.message,
                            icon: "success"
                        }).then(() => location.reload());
                    })
                    .fail(function(xhr) {
                        let errorMsg = "Terjadi kesalahan.";
                        if (xhr.status === 422) {
                            errorMsg = Object.values(xhr.responseJSON.errors).flat().join("\n");
                        } else if (xhr.responseJSON?.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            title: "Gagal!",
                            text: errorMsg,
                            icon: "error"
                        });
                    });
            });

            if (localStorage.getItem('status')) {
                Swal.fire({
                    title: localStorage.getItem('status') === 'success' ? 'Berhasil!' : 'Gagal!',
                    text: localStorage.getItem('message'),
                    icon: localStorage.getItem('status'),
                    showConfirmButton: false,
                    timer: 2000
                });
                localStorage.removeItem('status');
                localStorage.removeItem('message');
            }

            window.deletePeminjaman = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                    $.ajax({
                        url: `{{ route('admin.peminjaman-alat-barang.destroy', ':id') }}`.replace(':id',
                            id),
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            table.ajax.reload(null, false);
                            alert(response.success);
                        },
                        error: function(xhr) {
                            alert('Error menghapus item: ' + xhr.responseText);
                        }
                    });
                }
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
