<div class="modal fade" id="tambahPeminjamModal" tabindex="-1" aria-labelledby="tambahPeminjamModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPeminjamModalLabel">Tambah Peminjam</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createPeminjamanForm">
                    @csrf
                    <div class="mb-3">
                        <label for="siswa" class="form-label">Nama Siswa</label>
                        <select class="form-control" id="siswa" name="siswa" required>
                            <option value="">Pilih Siswa</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="barang_id" class="form-label">Nama Barang</label>
                        <select class="form-control" id="barang_id" name="barang_id" required>
                            <option value="">Pilih Barang</option>
                            @foreach ($alat_barangs as $barang)
                                <option value="{{ $barang->id }}">
                                    {{ $barang->nama_barang }} - {{ $barang->kode_barang }}
                                </option>
                            @endforeach
                        </select>
                        
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required>
                    </div>
                    <div class="mb-3">
                        <label for="ruangan_peminjam" class="form-label">Ruangan Peminjam</label>
                        <input type="text" class="form-control" id="ruangan_peminjam" name="ruangan_peminjam"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="status_pinjam" class="form-label">Status</label>
                        <select class="form-control" id="status_pinjam" name="status_pinjam" required>
                            <option value="dipinjam">Dipinjam</option>
                            <option value="kembali">Kembali</option>
                        </select>
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
