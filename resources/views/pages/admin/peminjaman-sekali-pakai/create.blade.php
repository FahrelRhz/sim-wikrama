<div class="row">
    <div class="col-md-2">
        @extends('pages.components.app-admin')
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
                                <option value="{{ $barang->id }}" {{ old('barang_sekali_pakai_id') == $barang->id ? 'selected' : '' }}>
                                    {{ $barang->nama_barang }}
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
                        <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" 
                            placeholder="Masukkan Nama Peminjam" value="{{ old('nama_peminjam') }}" required>
                        @error('nama_peminjam')
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

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


