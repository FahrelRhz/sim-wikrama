@extends('pages.components.sidebar-admin')

@section('content')
    <div class="row fs-6">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card mb-4 mt-4">
                <div class="card-body">
                    <h5 class="mb-4">Tambah Alat atau Barang</h5>
                    <form method="POST" action="{{ route('admin.alat-barang.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Jenis -->
                                <div class="mb-3">
                                    <label for="jenis" class="form-label">Jenis</label>
                                    <input type="text" class="form-control" id="jenis" name="jenis"
                                        value="{{ old('jenis') }}" required>
                                    @error('jenis')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Barang Merk -->
                                <div class="mb-3">
                                    <label for="barang_merk" class="form-label">Barang</label>
                                    <input type="text" class="form-control" id="barang_merk" name="barang_merk"
                                        value="{{ old('barang_merk') }}" required>
                                    @error('barang_merk')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Volume -->
                                <div class="mb-3">
                                    <label for="volume" class="form-label">Volume</label>
                                    <input type="number" class="form-control" id="volume" name="volume"
                                        value="{{ old('volume') }}" min="1" required>
                                    @error('volume')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Satuan -->
                                <div class="mb-3">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <input type="text" class="form-control" id="satuan" name="satuan"
                                        value="{{ old('satuan') }}" required>
                                    @error('satuan')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Harga Satuan -->
                                <div class="mb-3">
                                    <label for="harga_satuan" class="form-label">Harga Satuan</label>
                                    <input type="text" class="form-control" id="harga_satuan" name="harga_satuan"
                                        value="{{ old('harga_satuan') }}" required oninput="formatRupiah(this)">
                                    @error('harga_satuan')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Jumlah Harga -->
                                <div class="mb-3">
                                    <label for="jumlah_harga" class="form-label">Jumlah Harga</label>
                                    <input type="text" class="form-control" id="jumlah_harga" name="jumlah_harga"
                                        value="{{ old('jumlah_harga') }}" required oninput="formatRupiah(this)">
                                    @error('jumlah_harga')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Link SIPLah -->
                                <div class="mb-3">
                                    <label for="link_siplah" class="form-label">Link SIPLah</label>
                                    <input type="url" class="form-control" id="link_siplah" name="link_siplah"
                                        value="{{ old('link_siplah') }}">
                                    @error('link_siplah')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Keterangan -->
                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>


                        <!-- Tombol Simpan dan Kembali -->
                        <div>
                            <button type="submit" class="btn mt-3 text-white" style="background-color: #042456">
                                Simpan
                            </button>
                            <a href="{{ route('admin.alat-barang.index') }}" class="btn btn-secondary mt-3 text-white">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk memformat angka ke format Rupiah
        function formatRupiah(input) {
            let value = input.value.replace(/[^,\d]/g, ''); // Hanya angka yang diizinkan
            let split = value.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    
            // Tambahkan titik jika ada ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
    
            input.value = 'Rp.' + rupiah + (split[1] ? ',' + split[1] : '');
        }
    </script>
@endsection
