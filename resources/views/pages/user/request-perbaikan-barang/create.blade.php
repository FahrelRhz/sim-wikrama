<div class="modal fade" id="tambahRequestPerbaikanBarangModal" tabindex="-1"
    aria-labelledby="tambahRequestPerbaikanBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahRequestPerbaikanBarangModalLabel">Tambah Perbaikan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('user.request-perbaikan-barang.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="barang_id" class="form-label">Barang</label>
                        <select class="form-control @error('barang_id') is-invalid @enderror" name="barang_id" id="barang_id" required>
                            <option value="">Pilih Barang</option>
                            @foreach ($barangs as $barang)
                                <option value="{{ $barang->id }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                    {{ $barang->nama_barang }} - {{ $barang->kode_barang }}
                                </option>
                            @endforeach
                        </select>
                    
                        <!-- Menampilkan pesan error jika ada -->
                        @error('barang_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    

                    <div class="mb-3">
                        <label for="tanggal_request" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal_request" name="tanggal_request" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi_kerusakan" class="form-label">Deskripsi Kerusakan</label>
                        <textarea class="form-control" id="deskripsi_kerusakan" name="deskripsi_kerusakan" required>{{ old('deskripsi_kerusakan') }}</textarea>
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
