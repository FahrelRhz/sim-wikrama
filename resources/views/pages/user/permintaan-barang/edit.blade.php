<!-- Modal Edit Permintaan -->
<div class="modal fade" id="editPermintaanModal" tabindex="-1" aria-labelledby="editPermintaanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPermintaanModalLabel">Edit Permintaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPermintaanForm" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama Barang -->
                    <div class="mb-3">
                        <label for="edit_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="edit_barang" name="barang" required>
                        @error('barang')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Nama Peminta -->
                    <div class="mb-3">
                        <label for="edit_user_id" class="form-label">Nama Peminta</label>
                        <select class="form-control" id="edit_user_id" name="user_id" required>
                            <option value="">Pilih Nama Peminta</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Tanggal Permintaan -->
                    <div class="mb-3">
                        <label for="edit_tanggal_permintaan" class="form-label">Tanggal Permintaan</label>
                        <input type="date" class="form-control" id="edit_tanggal_permintaan" name="tanggal_permintaan" required>
                        @error('tanggal_permintaan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Alasan Permintaan -->
                    <div class="mb-3">
                        <label for="edit_alasan_permintaan" class="form-label">Alasan Permintaan</label>
                        <textarea class="form-control" id="edit_alasan_permintaan" name="alasan_permintaan" rows="3" required></textarea>
                        @error('alasan_permintaan')
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
