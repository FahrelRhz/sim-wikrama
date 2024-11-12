@extends('pages.components.app')

@include('partials.datatable')

<div class="row">
    <div class="col-md-2"></div>

    <div class="col-md-10">
        <div class="container">
            <div class="row">
                <div class="card mb-4 mt-4">
                    <div class="card-body">
                        <h5 class="mb-4">Daftar Siswa</h5>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="myTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Rombel</th>
                                        <th>Rayon</th>
                                        <th>Jurusan</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('user.fetch') }}",
                type: 'GET',
                cache: false,
                error: function(xhr, error, code) {
                    console.log("Error fetching data:", xhr.responseText);
                }
            },
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            deferRender: true,
            stateSave: true,
            columns: [{
                    data: 'nis',
                    name: 'nis'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'nama_rombel',
                    name: 'nama_rombel'
                },
                {
                    data: 'rayon',
                    name: 'rayon'
                },
                {
                    data: 'jurusan',
                    name: 'jurusan'
                }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                loadingRecords: "Memuat data, harap tunggu...", 
                processing: "Memproses data, harap tunggu..."
            },
            preDrawCallback: function(settings) {
                $('#myTable').hide();
            },
            drawCallback: function(settings) {
                $('#myTable').show();
            }
        });
    });
</script>
