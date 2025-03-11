@section('content')
    <div class="row fs-6">
        <div class="col-md-1">
            @extends('pages.components.sidebar-admin')
        </div>

        <div class="col-md-10">
            <div class="card mb-4 mt-4">

                <div class="card-body">
                    <h5 class="mb-4">Edit Peminjaman</h5>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST"
                        action="{{ route('admin.peminjaman-sekali-pakai.update', $peminjaman_sekali_pakai->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Input Nama Peminjam -->
                        <div class="mb-3">
                            <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                            <select class="form-control" id="nama_peminjam" name="nama_peminjam" required>
                                <option value="">Pilih Nama Peminjam</option>
                                @foreach ($nama_peminjam as $peminjam)
                                    <option value="{{ $peminjam }}"
                                        {{ old('nama_peminjam', $peminjaman_sekali_pakai->nama_peminjam) == $peminjam ? 'selected' : '' }}>
                                        {{ $peminjam }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nama_peminjam')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dropdown Nama Barang -->
                        <div class="mb-3">
                            <label for="barang_sekali_pakai_id" class="form-label">Pilih Barang</label>
                            <select name="barang_sekali_pakai_id" id="barang_sekali_pakai_id" class="form-control">
                                <option value="">Pilih Barang</option>
                                @foreach ($barang_sekali_pakai as $barang)
                                    <option value="{{ $barang->id }}"
                                        {{ old('barang_sekali_pakai_id', $peminjaman_sekali_pakai->barang_sekali_pakai_id) == $barang->id ? 'selected' : '' }}>
                                        {{ $barang->nama_barang }} (Tersedia: {{ $barang->jml_barang }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jml_barang" class="form-label">Jumlah Barang</label>
                            <input type="number" name="jml_barang" id="jml_barang"
                                class="form-control @error('jml_barang') is-invalid @enderror"
                                value="{{ old('jml_barang', $peminjaman_sekali_pakai->jml_barang) }}">
                            @error('jml_barang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="keperluan" class="form-label">Keperluan</label>
                            <input type="text" name="keperluan" id="keperluan"
                                class="form-control @error('keperluan') is-invalid @enderror"
                                value="{{ old('keperluan', $peminjaman_sekali_pakai->keperluan) }}">
                            @error('keperluan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Input Tanggal Pinjam -->
                        <div class="mb-3">
                            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                                class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                                value="{{ old('tanggal_pinjam', $peminjaman_sekali_pakai->tanggal_pinjam) }}">
                            @error('tanggal_pinjam')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-3">
                            <button type="submit" class="btn text-white" style="background-color: #042456">Update</button>
                            <a href="{{ route('admin.peminjaman-sekali-pakai.index') }}"
                                class="btn btn-secondary text-white">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
