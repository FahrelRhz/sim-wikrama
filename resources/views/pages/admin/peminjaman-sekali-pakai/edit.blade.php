<div class="row">
    <div class="col-md-2">
        @extends('pages.components.app-admin')
    </div>

    <div class="col-md-10">
        <div class="card mb-4 mt-4">

            <div class="card-body">
                <h5 class="mb-4">Edit Peminjaman</h5>
                <form method="POST" action="{{ route('admin.peminjaman-sekali-pakai.update', $peminjaman_sekali_pakai->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Input Nama Peminjam -->
                    <div class="mb-3">
                        <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                        <input type="text" name="nama_peminjam" id="nama_peminjam" class="form-control @error('nama_peminjam') is-invalid @enderror" value="{{ old('nama_peminjam', $peminjaman_sekali_pakai->nama_peminjam) }}">
                        @error('nama_peminjam')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Dropdown Nama Barang -->
                    <div class="mb-3">
                        <label for="barang_sekali_pakai_id" class="form-label">Nama Barang</label>
                        <select name="barang_sekali_pakai_id" id="barang_sekali_pakai_id" class="form-control @error('barang_sekali_pakai_id') is-invalid @enderror">
                            <option value="">Pilih Barang</option>
                            @foreach ($barang_sekali_pakai as $barang)
                                <option value="{{ $barang->id }}" {{ old('barang_sekali_pakai_id', $peminjaman_sekali_pakai->barang_sekali_pakai_id) == $barang->id ? 'selected' : '' }}>
                                    {{ $barang->nama_barang }}
                                </option>
                            @endforeach
                        </select>
                        @error('barang_sekali_pakai_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Input Tanggal Pinjam -->
                    <div class="mb-3">
                        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control @error('tanggal_pinjam') is-invalid @enderror" value="{{ old('tanggal_pinjam', $peminjaman_sekali_pakai->tanggal_pinjam) }}">
                        @error('tanggal_pinjam')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-3">
                        <button type="submit" class="btn text-white" style="background-color: #042456">Update</button>
                        <a href="{{ route('admin.peminjaman-sekali-pakai.index') }}" class="btn btn-secondary text-white">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
