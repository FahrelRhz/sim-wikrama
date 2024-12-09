<div class="modal fade" id="editRequestPerbaikanBarangModal" tabindex="-1"
    aria-labelledby="editRequestPerbaikanBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRequestPerbaikanBarangModalLabel">Edit Perbaikan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="editRequestPerbaikanBarangForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label for="barang_id" class="form-label">Barang</label>
                        <select class="form-control" name="barang_id" id="edit_barang_id" required>
                            <option value="">Pilih Barang</option>
                            @foreach ($barangs as $barang)
                                <option value="{{ $barang->id }}">{{ $barang->nama_barang }} -
                                    {{ $barang->kode_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_request" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="edit_tanggal_request" name="tanggal_request"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi_kerusakan" class="form-label">Deskripsi Kerusakan</label>
                        <textarea class="form-control" name="deskripsi_kerusakan" id="edit_deskripsi_kerusakan"required></textarea>
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
