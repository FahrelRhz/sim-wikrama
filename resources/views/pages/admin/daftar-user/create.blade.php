<div class="row">
    <div class="col-md-2">
        @extends('pages.components.app-admin')
    </div>
    
    <div class="col-md-10">
        <div class="card mb-4 mt-4">
            <div class="card-body">
                <h5 class="mb-4">Tambah User</h5>
                <form method="POST" action="{{ route('admin.daftar-user.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ old('name') }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                               value="{{ old('password') }}" required>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jurusan_id" class="form-label">Jurusan</label>
                        <select class="form-control" id="jurusan_id" name="jurusan_id" required>
                            <option value="">Pilih Jurusan</option>
                            @foreach($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                        @error('jurusan_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="">
                        <button type="submit" class="btn mt-3 text-white" style="background-color: #042456">Simpan</button>
                        <a href="{{ route('admin.daftar-user.index') }}" class="btn btn-secondary mt-3 text-white">Kembali</a"></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
