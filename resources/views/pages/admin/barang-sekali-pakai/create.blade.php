<div class="row">
    <div class="col-md-2">
        @extends('pages.components.app-admin')
    </div>
    
    <div class="col-md-10">
        <div class="card mb-4 mt-4">
            <div class="card-body">
                <h5 class="mb-4">Tambah Barang</h5>
                <form method="POST" action="{{ route('admin.barang-sekali-pakai.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                               value="{{ old('nama_barang') }}" required>
                        @error('nama_barang')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jml_barang" class="form-label">Jumlah Barang</label>
                        <input type="number" class="form-control" id="jml_barang" name="jml_barang"
                               value="{{ old('jml_barang') }}" required>
                        @error('jml_barang')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="">
                        <button type="submit" class="btn mt-3 text-white" style="background-color: #042456">Simpan</button>
                        <a href="{{ route('admin.barang-sekali-pakai.index') }}" class="btn btn-secondary mt-3 text-white">Kembali</a"></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
