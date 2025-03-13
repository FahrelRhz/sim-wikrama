<div class="modal fade" id="editPeminjamanAlatBarangModal" tabindex="-1" aria-labelledby="editPeminjamanAlatBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPeminjamanAlatBarangModalLabel">Edit Peminjaman Alat dan Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPeminjamanAlatBarangForm" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Tanggal Pinjam -->
                    <div class="mb-3">
                        <label for="edit_tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" class="form-control" id="edit_tanggal_pinjam" name="tanggal_pinjam" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control" id="edit_tanggal_kembali" name="tanggal_kembali" required>
                    </div>

                    {{-- <!-- Ruangan Peminjam -->
                    <div class="mb-3">
                        <label for="edit_ruangan_peminjam" class="form-label">Ruangan Peminjam</label>
                        <input type="text" class="form-control" id="edit_ruangan_peminjam" name="ruangan_peminjam" required>
                    </div>

                    <!-- Keperluan -->
                    <div class="mb-3">
                        <label for="edit_keperluan" class="form-label">Keperluan</label>
                        <input type="text" class="form-control" id="edit_keperluan" name="keperluan" required>
                    </div> --}}

                    <!-- Status Pinjam -->
                    <div class="mb-3">
                        <label for="edit_status_pinjam" class="form-label">Status</label>
                        <select class="form-control" id="edit_status_pinjam" name="status_pinjam" required>
                            <option value="dipinjam">Dipinjam</option>
                            <option value="kembali">Kembali</option>
                        </select>
                    </div>

                    <!-- Tombol Modal -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn text-white" style="background-color: #042456">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
