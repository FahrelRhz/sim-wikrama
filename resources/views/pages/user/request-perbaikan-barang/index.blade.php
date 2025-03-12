@extends('pages.components.sidebar')

@include('partials.datatable')

@include('pages.user.request-perbaikan-barang.edit')

@section('content')

    <div class="row fs-6">
        <div class="col-md-1">
        </div>

        <div class="col-md-10">
            <div class="container">
                <div class="row">
                    <div class="card mb-4 mt-4">
                        <div class="card-body">
                            <h5 class="mb-4">Permintaan Perbaikan Barang</h5>

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

                                    <a href="{{ route('user.request-perbaikan-barang.create') }}" class="btn text-white"
                                        style="background-color: #042456" data-bs-toggle="modal"
                                        data-bs-target="#tambahRequestPerbaikanBarangModal">Tambah Perbaikan</a>
                                    @include('pages.user.request-perbaikan-barang.create')

                                </div>
                                <table class="table table-striped table-bordered" id="myTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Barang</th>
                                            <th>Nama Peminta</th>
                                            <th>Tanggal Permintaan</th>
                                            <th>Deskripsi Kerusakan</th>
                                            <th>Bukti Kerusakan</th>
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
        var table = initializeDataTable('#myTable', "{{ route('user.request-perbaikan-barang.index') }}", [{
                data: 'barang',
                name: 'barang'
            },
            {
                data: 'user',
                name: 'user'
            },
            {
                data: 'tanggal_request',
                name: 'tanggal_request'
            },
            {
                data: 'deskripsi_kerusakan',
                name: 'deskripsi_kerusakan'
            },
            {
                data: 'gambar',
                name: 'gambar',
                render: function(data, type, row) {
                    if (data) {
                        return `<img src="/storage/${data}" width="100" height="100" style="object-fit: cover; border-radius: 5px;">`;
                    } else {
                        return 'Tidak ada gambar';
                    }
                }
            },
            {
                data: 'status',
                name: 'status',
                render: function(data, type, row) {
                    var btnStyle;
                    var statusText;

                    if (data === 'pending') {
                        btnStyle = 'background-color: #f8d7da; color: #721c24;';
                        statusText = 'Pending';
                    } else if (data === 'dalam perbaikan') {
                        btnStyle = 'background-color: #fff4b1; color: #a67c00;';
                        statusText = 'Dalam Perbaikan';
                    } else if (data === 'selesai') {
                        btnStyle = 'background-color: #d4edda; color: #155724;';
                        statusText = 'Selesai';
                    } else {
                        btnStyle = 'background-color: #e2e3e5; color: #383d41;';
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


        $(document).on("click", ".edit-button", function() {
            let id = $(this).data("id");
            let barang = $(this).data("barang-id");
            let tanggal = $(this).data("tanggal-request");
            let deskripsi = $(this).data("deskripsi-kerusakan");
            let buktiKerusakan = $(this).data("bukti-kerusakan");

            $("#edit_id").val(id);
            $("#edit_barang").val(barang);
            $("#edit_tanggal_request").val(tanggal);
            $("#edit_deskripsi_kerusakan").val(deskripsi);

            if (buktiKerusakan) {
                $("#preview_edit_bukti_kerusakan").attr("src", "/storage/" + buktiKerusakan).show();
            } else {
                $("#preview_edit_bukti_kerusakan").hide();
            }
        });
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

        @if (session('error'))

            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                showConfirmButton: true
            });
        @endif

        function deleteRequestPerbaikanBarang(id) {
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
                        url: '{{ route('user.request-perbaikan-barang.delete', ':id') }}'.replace(':id',
                            id),
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
                                text: 'Gagal menghapus permintaan: ' + xhr.responseText,
                            });
                        }
                    });
                }
            });
        }
    </script>
    <script>
        @if (session('validation_errors'))
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                html: '<ul>@foreach (session('validation_errors') as $error) <li>{{ $error }}</li> @endforeach</ul>',
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                confirmButtonText: 'OK'
            });
        @endif
    </script>

@endsection
