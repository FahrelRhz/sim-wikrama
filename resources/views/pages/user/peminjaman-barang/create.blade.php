
<div class="modal fade" id="tambahPeminjamModal" tabindex="-1" aria-labelledby="tambahPeminjamModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPeminjamModalLabel">Tambah Peminjam</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('user.peminjaman-barang.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="siswa_id" class="form-label">Nama Siswa</label>
                        <select class="form-control" id="siswa_id" name="siswa_id" required>
                            <option value="">Pilih Nama Siswa</option>
                            @foreach ($siswas as $siswa)
                                <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                    {{ $siswa->nama_siswa }}
                                </option>
                            @endforeach
                        </select>
                        @error('siswa_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="barang_id" class="form-label">Nama Barang</label>
                        <select class="form-control" id="barang_id" name="barang_id" required>
                            <option value="">Pilih Barang</option>
                            @foreach ($barangs as $barang)
                                <option value="{{ $barang->id }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                    {{ $barang->nama_barang }}
                                </option>
                            @endforeach
                        </select>
                        @error('barang_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" required>
                        @error('tanggal_pinjam')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status_pinjam" class="form-label">Status</label>
                        <select class="form-control" id="status_pinjam" name="status_pinjam" required>
                            <option value="">Pilih Status</option>
                            <option value="dipinjam" {{ old('status_pinjam') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="kembali" {{ old('status_pinjam') == 'kembali' ? 'selected' : '' }}>Kembali</option>
                        </select>
                        @error('status_pinjam')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn text-white" style="background-color: #042456">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
