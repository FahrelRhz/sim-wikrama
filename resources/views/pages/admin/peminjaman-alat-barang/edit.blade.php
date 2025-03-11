<div class="modal fade" id="editPeminjamanAlatBarangModal" tabindex="-1"
    aria-labelledby="editPeminjamanAlatBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPeminjamanAlatBarangModalLabel">Edit Peminjaman Alat dan Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPeminjamanAlatBarangForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                        <select class="form-control" id="nama_peminjam_edit" name="nama_peminjam" required>
                            <option value="">Pilih Nama Peminjam</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_alat_barang_id" class="form-label">Nama Barang</label>
                        <select class="form-control" id="edit_alat_barang_id" name="alat_barang_id" required>
                            <option value="">Pilih Barang</option>
                            @foreach ($alat_barangs as $barang)
                                <option value="{{ $barang->id }}">
                                    {{ $barang->barang_merk }}
                                </option>
                            @endforeach
                        </select>                                               
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" class="form-control" id="edit_tanggal_pinjam" name="tanggal_pinjam" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_ruangan_peminjam" class="form-label">Ruangan Peminjam</label>
                        <input type="text" class="form-control" id="edit_ruangan_peminjam" name="ruangan_peminjam" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_keperluan" class="form-label">Keperluan</label>
                        <input type="text" class="form-control" id="edit_keperluan" name="keperluan" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_status_pinjam" class="form-label">Status</label>
                        <select class="form-control" id="edit_status_pinjam" name="status_pinjam" required>
                            <option value="dipinjam">Dipinjam</option>
                            <option value="kembali">Kembali</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn text-white" style="background-color: #042456">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
