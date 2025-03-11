@extends('pages.components.sidebar-admin')

@section('content')
    <div class="row fs-6">
        <div class="col-md-1">
        </div>

        <div class="col-md-10">
            <div class="card mb-4 mt-4">
                <div class="card-body">
                    <h5 class="mb-4">Edit Alat atau Barang</h5>
                    <form method="POST" action="{{ route('admin.alat-barang.update', $alat_barang->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis</label>
                            <input type="text" class="form-control @error('jenis') is-invalid @enderror" id="jenis"
                                name="jenis" value="{{ old('jenis', $alat_barang->jenis) }}" required>
                            @error('jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="barang_merk" class="form-label">Merk Barang</label>
                            <input type="text" class="form-control @error('barang_merk') is-invalid @enderror"
                                id="barang_merk" name="barang_merk"
                                value="{{ old('barang_merk', $alat_barang->barang_merk) }}" required>
                            @error('barang_merk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="volume" class="form-label">Volume</label>
                            <input type="number" class="form-control @error('volume') is-invalid @enderror" id="volume"
                                name="volume" value="{{ old('volume', $alat_barang->volume) }}" required>
                            @error('volume')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="satuan"
                                name="satuan" value="{{ old('satuan', $alat_barang->satuan) }}" required>
                            @error('satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga_satuan" class="form-label">Harga Satuan</label>
                            <input type="number" step="0.01"
                                class="form-control @error('harga_satuan') is-invalid @enderror" id="harga_satuan"
                                name="harga_satuan" value="{{ old('harga_satuan', $alat_barang->harga_satuan) }}" required>
                            @error('harga_satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_harga" class="form-label">Jumlah Harga</label>
                            <input type="number" step="0.01"
                                class="form-control @error('jumlah_harga') is-invalid @enderror" id="jumlah_harga"
                                name="jumlah_harga" value="{{ old('jumlah_harga', $alat_barang->jumlah_harga) }}" required>
                            @error('jumlah_harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan">{{ old('keterangan', $alat_barang->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="link_siplah" class="form-label">Link Siplah</label>
                            <input type="url" class="form-control @error('link_siplah') is-invalid @enderror"
                                id="link_siplah" name="link_siplah"
                                value="{{ old('link_siplah', $alat_barang->link_siplah) }}">
                            @error('link_siplah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn text-white" style="background-color: #042456">Update</button>
                            <a href="{{ route('admin.alat-barang.index') }}"
                                class="btn btn-secondary text-white">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
