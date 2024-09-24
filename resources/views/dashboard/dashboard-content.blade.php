<div class="d-flex justify-content-start mb-4">
    <a class="text-decoration-none" href="/dashboard">
        <h6 class="text-secondary">
            <i class="bi bi-house"></i>
            Dashboard /
        </h6>
    </a>
</div>

<div class="row g-4">
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="p-3 rounded bi bi-arrow-down-left-circle-fill me-2 icon-background"></i>
                    <div>
                        <h5 class="card-title mb-1">Dipinjamkan</h5>
                        <p class="card-text me-2">
                            <span class="count">4</span>
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
                            <span class="count">24</span>
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
                            <span class="count">15</span>
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
                            <span class="count">80</span>
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
        <table>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Daftar Barang</th>
                <th>Status</th>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>Handphone</td>
                <td class="bg-success-subtle fw-bold">Kembali</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Jane Smith</td>
                <td>Laptop</td>
                <td class="bg-danger-subtle fw-bold">Belum Kembali</td>
            </tr>
        </table>
    </div>
</div>

{{-- grafik --}}
<div class="chart-container" style="height: 250px;">
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
        <img src="https://via.placeholder.com/80" alt="Profile Picture">
        <h6>Admin</h6>
    </div>

    <div class="sidebar-welcome">
        Welcome Admin!
    </div>

    <div class="sidebar-icons">
        <div class="sidebar-icon">
            <i class="bi bi-gear-fill"></i>
        </div>
        <div class="sidebar-icon">
            <i class="bi bi-box-arrow-right"></i>
        </div>
    </div>

    <div class="sidebar-bottom-text">
        Have a nice day!
    </div>
</div>
