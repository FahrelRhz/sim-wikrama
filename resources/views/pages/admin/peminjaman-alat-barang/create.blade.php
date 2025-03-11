<div class="modal fade" id="tambahPeminjamanAlatBarangModal" tabindex="-1" aria-labelledby="tambahPeminjamanAlatModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPeminjamanAlatModalLabel">Tambah Peminjam Alat dan Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createPeminjamanAlatBarangForm">
                    @csrf
                    <div class="mb-3">
                        <label for="siswa" class="form-label">Nama Peminjam</label>
                        <input type="date" class="form-control" id="nama_peminjam" name="nama_peminjam" required>
                    </div>
                    <div class="mb-3">
                        <label for="alat_barang_id" class="form-label">Nama Barang</label>
                        <select class="form-control" id="alat_barang_id" name="alat_barang_id" required>
                            <option value="">Pilih Barang</option>
                            @foreach ($alatBarangs as $barang)
                                <option value="{{ $barang->id }}">
                                    {{ $barang->barang_merk }}
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
                        <label for="ruangan_peminjam" class="form-label">Keperluan</label>
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
