@extends('pages.components.sidebar')

@section('content')
    <div class="row fs-6">
        <div class="col-md-1">
        </div>

        <div class="col-md-10">
            <div class="card mb-4 mt-4">
                <div class="card-body">
                    <h5 class="mb-4">Tambah Barang</h5>
                    <form method="POST" action="{{ route('user.daftar-barang.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kode_barang" class="form-label">Kode Barang</label>
                                    <input type="text" class="form-control" id="kode_barang" name="kode_barang"
                                        value="{{ old('kode_barang') }}" required>
                                    @error('kode_barang')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_barang" class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                        value="{{ old('nama_barang') }}" required>
                                    @error('nama_barang')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="merk_barang" class="form-label">Merk Barang</label>
                                    <input type="text" class="form-control" id="merk_barang" name="merk_barang"
                                        value="{{ old('merk_barang') }}" required>
                                    @error('merk_barang')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_pengadaan" class="form-label">Tanggal Pengadaan</label>
                                    <input type="date" class="form-control" id="tanggal_pengadaan"
                                        name="tanggal_pengadaan" value="{{ old('tanggal_pengadaan') }}" required>
                                    @error('tanggal_pengadaan')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sumber_dana" class="form-label">Sumber Dana</label>
                                    <input type="text" class="form-control" id="sumber_dana" name="sumber_dana"
                                        value="{{ old('sumber_dana') }}" required>
                                    @error('sumber_dana')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="kondisi_barang" class="form-label">Kondisi Barang</label>
                                    <select class="form-control" id="kondisi_barang" name="kondisi_barang" required>
                                        <option value="Baik" {{ old('kondisi_barang') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Rusak" {{ old('kondisi_barang') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                    </select>
                                    @error('kondisi_barang')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="jurusan_id" class="form-label">Jurusan</label>
                                    <select class="form-control" id="jurusan_id" name="jurusan_id" disabled>
                                        <option value="">Pilih Jurusan</option>
                                        @foreach ($jurusans as $jurusan)
                                            <option value="{{ $jurusan->id }}"
                                                {{ (old('jurusan_id', $userJurusanId) == $jurusan->id) ? 'selected' : '' }}>
                                                {{ $jurusan->nama_jurusan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jurusan_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>                                
                                <div class="mb-3">
                                    <label for="deskripsi_barang" class="form-label">Deskripsi Barang</label>
                                    <textarea class="form-control" id="deskripsi_barang" name="deskripsi_barang" required>{{ old('deskripsi_barang') }}</textarea>
                                    @error('deskripsi_barang')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <button type="submit" class="btn mt-3 text-white"
                                style="background-color: #042456">Simpan</button>
                            <a href="{{ route('user.daftar-barang.index') }}"
                                class="btn btn-secondary mt-3 text-white">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
