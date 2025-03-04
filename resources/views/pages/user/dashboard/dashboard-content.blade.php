<div class="d-flex justify-content-start mt-4">
    <h4 class="fw-bold mb-4">DAFTAR BARANG - {{ $user_name->name }}</h4>
</div>

<div class="row g-4">
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="p-3 rounded bi bi-arrow-down-left-circle-fill me-2 icon-background"></i>
                    <div>
                        <h5 class="card-title mb-1">Jumlah Barang</h5>
                        <p class="card-text me-2">
                            <span class="count">{{ $jml_barang }}</span>
                            <span class="count-text">Barang</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="p-3 rounded bi bi-hourglass-split me-2 icon-background"></i>
                    <div>
                        <h5 class="card-title mb-1">Dalam Peminjaman</h5>
                        <p class="card-text me-2">
                            <span class="count">{{ $jml_dipinjam }}</span>
                            <span class="count-text">Barang</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="p-3 rounded bi bi-check-circle-fill me-2 icon-background"></i>
                    <div>
                        <h5 class="card-title mb-1">Dikembalikan</h5>
                        <p class="card-text me-2">
                            <span class="count">{{ $jml_kembali }}</span>
                            <span class="count-text">Barang</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="p-3 rounded bi bi-shield-slash-fill me-2 icon-background"></i>
                    <div>
                        <h5 class="card-title mb-1">Barang Rusak</h5>
                        <p class="card-text me-2">
                            <span class="count">{{ $jml_rusak }}</span>
                            <span class="count-text">Barang</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<h5 class="table-title mt-5">Status Terbaru</h5>
<div class="table-chart-container">
    <div class="col">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Daftar Barang</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($status_terbaru as $index => $status)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $status->siswa ?? 'Tidak Diketahui' }}</td>
                        <td>{{ $status->barang->nama_barang ?? 'Tidak Diketahui' }}</td>
                        <td class="{{ $status->status == 'kembali' ? 'bg-success-subtle' : 'bg-danger-subtle' }} fw-bold">
                            {{ $status->status == 'kembali' ? 'Sudah Kembali' : 'Dipinjam' }}
                        </td>                        
                    </tr>
                @endforeach
            </tbody>            
        </table>
    </div>
</div>

{{-- Grafik --}}
<div class="chart-container" style="height: 175px">
    <h5>Kategori Barang Pinjaman</h5>
    <canvas id="myBarChart" style="width: 100%; height: 100%;"></canvas>
</div>

<div class="user-button" onclick="openSidebar()">
    <i class="bi bi-person-fill"></i>
</div>

<!-- Right Sidebar -->
<div class="right-sidebar" id="right-sidebar">
    <span class="close-sidebar" onclick="closeSidebar()">&times;</span>
    <div class="sidebar-date" id="sidebar-date"></div>

    <div class="sidebar-profile">
        <img src="https://via.placeholder.com/80" alt="Profile Picture" class="img-fluid rounded-circle">
        <h6>{{ $user_name->name }}</h6>
    </div>

    <div class="sidebar-welcome">
        Welcome {{ $user_name->name }}!
    </div>

    <div class="sidebar-icons">
        <div class="sidebar-icon">
            <i class="bi bi-gear-fill"></i>
        </div>
        <form action="{{ route('user.logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-link p-0" style="border: none; background: none;">
                <div class="sidebar-icon">
                    <i class="bi bi-box-arrow-right"></i>
                </div>
            </button>
        </form>
    </div>

    <div class="sidebar-bottom-text">
        Have a nice day!
    </div>
</div>
