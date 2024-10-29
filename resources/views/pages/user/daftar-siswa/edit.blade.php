@extends('pages.components.app')

@section('content')
<div class="row">
    <div class="">
        <div class="card mb-4 mt-4">
            <div class="card-body">
                <h5 class="mb-4">Edit Siswa</h5>
                <form method="POST" action="{{ route('user.daftar-siswa.update', $siswa->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3">
                            <label for="nis" class="form-label">NIS </label>
                            <input type="text" class="form-control" id="nis" name="nis"
                                value="{{ old('nis', $siswa->nis) }}" required>
                            @error('nis')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_siswa" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa"
                                value="{{ old('nama_siswa', $siswa->nama_siswa) }}" required>
                            @error('nama_siswa')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rombel" class="form-label">Rombel</label>
                            <input type="text" class="form-control" id="rombel" name="rombel"
                                value="{{ old('rombel', $siswa->rombel) }}" required>
                            @error('rombel')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rayon" class="form-label">Rayon</label>
                            <input type="text" class="form-control" id="rayon" name="rayon"
                                value="{{ old('rayon', $siswa->rayon) }}" required>
                            @error('rayon')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jurusan_id" class="form-label">Jurusan</label>
                            <select class="form-control" id="jurusan_id" name="jurusan_id" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}"
                                        {{ (old('jurusan_id', $siswa->jurusan_id) == $jurusan->id) ? 'selected' : '' }}>
                                        {{ $jurusan->nama_jurusan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jurusan_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="">
                        <button type="submit" class="btn mt-3 text-white"
                            style="background-color: #042456">Simpan</button>
                        <a href="{{ route('user.daftar-siswa.index') }}"
                            class="btn btn-secondary mt-3 text-white">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
