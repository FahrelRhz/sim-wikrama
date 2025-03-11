@extends('pages.components.sidebar-admin')

@section('content')
    <div class="row fs-6">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <div class="card mb-4 mt-4">
                <div class="card-body">
                    <h5 class="mb-4">Tambah Peminjaman Barang</h5>
                    <form method="POST" action="{{ route('admin.peminjaman-sekali-pakai.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="barang_sekali_pakai_id" class="form-label">Nama Barang</label>
                            <select class="form-control" id="barang_sekali_pakai_id" name="barang_sekali_pakai_id" required>
                                <option value="" disabled selected>Pilih Barang</option>
                                @foreach ($barang_sekali_pakai as $barang)
                                    <option value="{{ $barang->id }}"
                                        {{ old('barang_sekali_pakai_id') == $barang->id ? 'selected' : '' }}>
                                        {{ $barang->nama_barang }} (Tersedia: {{ $barang->jml_barang }})
                                    </option>
                                @endforeach
                            </select>
                            @error('barang_sekali_pakai_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Nama Peminjam -->
                        <div class="mb-3">
                            <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                            <select class="form-control" id="nama_peminjam" name="nama_peminjam" required>
                                <option value="">Pilih Nama Peminjam</option>
                                @foreach ($nama_peminjam as $peminjam)
                                    <option value="{{ $peminjam }}"
                                        {{ old('nama_peminjam') == $peminjam ? 'selected' : '' }}>
                                        {{ $peminjam }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nama_peminjam')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jml_barang" class="form-label">Jumlah Barang</label>
                            <input type="number" class="form-control" id="jml_barang" name="jml_barang"
                                value="{{ old('jml_barang') }}" required>
                            @error('jml_barang')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="keperluan" class="form-label">Keperluan</label>
                            <input type="text" class="form-control" id="keperluan" name="keperluan"
                                value="{{ old('keperluan') }}" required>
                            @error('keperluan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam"
                                value="{{ old('tanggal_pinjam') }}" required>
                            @error('tanggal_pinjam')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="modal-footer">
                            <a href="{{ route('admin.peminjaman-sekali-pakai.index') }}" class="btn btn-secondary mx-2">Batal</a>
                            <button type="submit" class="btn text-white" style="background-color: #042456">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
