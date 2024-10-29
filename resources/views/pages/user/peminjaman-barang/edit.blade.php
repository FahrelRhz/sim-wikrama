<!-- edit.blade.php -->
<div class="modal fade" id="editPeminjamModal" tabindex="-1" aria-labelledby="editPeminjamModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPeminjamModalLabel">Edit Peminjam</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPeminjamForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" class="form-control" id="edit_tanggal_pinjam" name="tanggal_pinjam" required>
                        @error('tanggal_pinjam')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control" id="edit_tanggal_kembali" name="tanggal_kembali" required>
                        @error('tanggal_kembali')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status_pinjam" class="form-label">Status</label>
                        <select class="form-control" id="edit_status_pinjam" name="status_pinjam" required>
                            <option value="dipinjam">Dipinjam</option>
                            <option value="kembali">Kembali</option>
                        </select>
                        @error('status_pinjam')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn text-white" style="background-color: #042456">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
