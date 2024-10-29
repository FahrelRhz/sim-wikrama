@extends('pages.components.app')

<div class="row">
    <div class="col-md-2">
        {{-- Jika ada elemen lain di sini, Anda dapat menambahkannya --}}
    </div>

    <div class="col-md-10">
        <div class="card mb-4 mt-4">
            <div class="card-body">
                <h5 class="mb-4">Edit Barang</h5>
                <form method="POST" action="{{ route('user.daftar-barang.update', $barang->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kode_barang" class="form-label">Kode Barang</label>
                                <input type="text" class="form-control" id="kode_barang" name="kode_barang"
                                    value="{{ old('kode_barang', $barang->kode_barang) }}" required>
                                @error('kode_barang')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                    value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                                @error('nama_barang')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="merk_barang" class="form-label">Merk Barang</label>
                                <input type="text" class="form-control" id="merk_barang" name="merk_barang"
                                    value="{{ old('merk_barang', $barang->merk_barang) }}" required>
                                @error('merk_barang')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_pengadaan" class="form-label">Tanggal Pengadaan</label>
                                <input type="date" class="form-control" id="tanggal_pengadaan" name="tanggal_pengadaan"
                                    value="{{ old('tanggal_pengadaan', \Carbon\Carbon::parse($barang->tanggal_pengadaan)->format('Y-m-d')) }}" required>
                                @error('tanggal_pengadaan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="sumber_dana" class="form-label">Sumber Dana</label>
                                <input type="text" class="form-control" id="sumber_dana" name="sumber_dana"
                                    value="{{ old('sumber_dana', $barang->sumber_dana) }}" required>
                                @error('sumber_dana')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                                <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang"
                                    value="{{ old('jumlah_barang', $barang->jumlah_barang) }}" required>
                                @error('jumlah_barang')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="kategori_barang" class="form-label">Kategori Barang</label>
                                <input type="text" class="form-control" id="kategori_barang" name="kategori_barang"
                                    value="{{ old('kategori_barang', $barang->kategori_barang) }}" required>
                                @error('kategori_barang')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="kondisi_barang" class="form-label">Kondisi Barang</label>
                                <input type="text" class="form-control" id="kondisi_barang" name="kondisi_barang"
                                    value="{{ old('kondisi_barang', $barang->kondisi_barang) }}" required>
                                @error('kondisi_barang')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jurusan_id" class="form-label">Jurusan</label>
                                <select class="form-control" id="jurusan_id" name="jurusan_id" required>
                                    <option value="">Pilih Jurusan</option>
                                    @foreach ($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id }}"
                                            {{ old('jurusan_id', $barang->jurusan_id) == $jurusan->id ? 'selected' : '' }}>
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
                                <textarea class="form-control" id="deskripsi_barang" name="deskripsi_barang" required>{{ old('deskripsi_barang', $barang->deskripsi_barang) }}</textarea>
                                @error('deskripsi_barang')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <button type="submit" class="btn mt-3 text-white" style="background-color: #042456">Update</button>
                        <a href="{{ route('user.daftar-barang.index') }}" class="btn btn-secondary mt-3 text-white">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
