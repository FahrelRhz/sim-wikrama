@extends('pages.components.sidebar-admin')

@section('content')

<div class="row fs-6">
    <div class="col-md-1">
    </div>
    
    <div class="col-md-10">
        <div class="card mb-4 mt-4">
            
            <div class="card-body">
                <h5 class="mb-4">Edit User</h5>
                <form method="POST" action="{{ route('admin.daftar-user.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $user->name) }}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                        value="{{ old('email', $user->email) }}" required>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="jurusan_id" class="form-label">Jurusan</label>
                        <select class="form-control" id="jurusan_id" name="jurusan_id" required>
                            <option value="">Pilih Jurusan</option>
                            @foreach ($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}"
                                {{ old('jurusan_id', $user->jurusan_id) == $jurusan->id ? 'selected' : '' }}>
                                {{ $jurusan->nama_jurusan }}
                            </option>
                            @endforeach
                        </select>
                        @error('jurusan')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="">
                        <button type="submit" class="btn mt-3 text-white"
                        style="background-color: #042456">Update</button>
                        <a href="{{ route('admin.daftar-user.index') }}"
                        class="btn btn-secondary mt-3 text-white">Kembali</a"></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection