@extends('pages.components.sidebar-admin')

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
                            <h5 class="mb-4">Daftar User</h5>

                            <div class="table-responsive">
                                <div class="">
                                    <a href="{{ route('admin.daftar-user.create') }}" class="btn text-white"
                                        style="background-color: #042456">Tambah User</a>
                                </div>
                                <table class="table table-striped table-bordered" id="myTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
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
        var table = initializeDataTable('#myTable', "{{ route('admin.daftar-user.index') }}", [{
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
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

        window.deleteUser = function(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: '{{ route('admin.daftar-user.destroy', ':id') }}'.replace(':id', id),
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
@endsection
