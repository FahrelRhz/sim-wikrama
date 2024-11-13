<div class="d-flex justify-content-start mt-4">
    <h4 class="fw-bold mb-4">DAFTAR BARANG - ADMIN</h4>
</div>

<div class="row g-4">
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="p-3 rounded bi bi-arrow-down-left-circle-fill me-2 icon-background"></i>
                    <div>
                        <h5 class="card-title mb-1">Request Perbaikan</h5>
                        <p class="card-text me-2">
                            <span class="count">12</span>
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
                        <h5 class="card-title mb-1">Sedang Diperbaiki</h5>
                        <p class="card-text me-2">
                            <span class="count">5</span>
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
                        <h5 class="card-title mb-1">Selesai Perbaikan</h5>
                        <p class="card-text me-2">
                            <span class="count">10</span>
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
                        <h5 class="card-title mb-1">Dikembalikan</h5>
                        <p class="card-text me-2">
                            <span class="count">5</span>
                            <span class="count-text">Barang</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<h5 class="table-title mt-5">Request Perbaikan Barang</h5>
<div class="table-chart-container">
    <div class="col">
        <table>
            <tr>
                <th>No</th>
                <th>Daftar Barang</th>
                <th>Kerusakan</th>
                <th>Status</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Laptop</td>
                <td>Tidak Nyala</td>
                <td class="bg-primary-subtle fw-bold text-primary" style="border-radius: 10px">Permintaan</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Handphone</td>
                <td>Mati Total</td>
                <td class="bg-secondary-subtle fw-bold text-secondary" style="border-radius: 10px">Diperbaiki</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Kamera</td>
                <td>Kamera Mati</td>
                <td class="bg-success-subtle fw-bold">Selesai</td>
            </tr>
        </table>
    </div>
</div>

{{-- grafik --}}
<div class="chart-container" style="height: 200px;">
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
        <h6>Kaprog</h6>
    </div>

    <div class="sidebar-welcome">
        Welcome Kaprog!
    </div>

    <div class="sidebar-icons">
        <div class="sidebar-icon">
            <i class="bi bi-gear-fill"></i>
        </div>
        <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
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
