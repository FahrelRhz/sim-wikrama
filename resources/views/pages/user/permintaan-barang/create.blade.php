<div class="modal fade" id="tambahPermintaanModal" tabindex="-1" aria-labelledby="tambahPermintaanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPermintaanModalLabel">Tambah Permintaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('user.permintaan-barang.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="barang" class="form-label">Barang</label>
                        <input type="text" class="form-control" id="barang" name="barang" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggalPermintaan" class="form-label">Tanggal Permintaan</label>
                        <input type="date" class="form-control" id="tanggalPermintaan" name="tanggal_permintaan"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="alasanPermintaan" class="form-label">Alasan Permintaan</label>
                        <textarea class="form-control" id="alasanPermintaan" name="alasan_permintaan" rows="3" required></textarea>
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
