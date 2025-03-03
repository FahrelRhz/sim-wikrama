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
                        <h5 class="card-title mb-1">Jumlah User</h5>
                        <p class="card-text me-2">
                            <span class="count">{{ $jml_users }}</span>
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
                    <i class="p-3 rounded bi bi-tools me-2 icon-background"></i>
                    <div>
                        <h5 class="card-title mb-1">Jumlah Perbaikan</h5>
                        <p class="card-text me-2">
                            <span class="count">{{ $jml_perbaikan }}</span>
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
                    <i class="p-3 rounded bi bi-box-arrow-in-up-left me-2 icon-background"></i>
                    <div>
                        <h5 class="card-title mb-1">Jumlah Permintaan</h5>
                        <p class="card-text me-2">
                            <span class="count">{{ $jml_permintaan }}</span>
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
                    <i class="p-3 rounded bi bi-1-circle-fill me-2 icon-background"></i>
                    <div>
                        <h5 class="card-title mb-1">Jumlah Barang Sekali Pakai</h5>
                        <p class="card-text me-2">
                            <span class="count">{{ $jml_sekali_pakai }}</span>
                            <span class="count-text">Barang</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Grafik --}}
<div class="chart-container" style="height: 300px">
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
        {{-- <h6>{{ $user_name->name }}</h6> --}}
    </div>

    <div class="sidebar-welcome">
        {{-- Welcome {{ $user_name->name }}! --}}
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
