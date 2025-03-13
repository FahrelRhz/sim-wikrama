<div class="modal fade" id="editRequestPerbaikanBarangModal" tabindex="-1"
    aria-labelledby="editRequestPerbaikanBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRequestPerbaikanBarangModalLabel">Edit Status Perbaikan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRequestPerbaikanBarangForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="pending">Pending</option>
                            <option value="dalam perbaikan">Dalam Perbaikan</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn text-white" style="background-color: #042456">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
