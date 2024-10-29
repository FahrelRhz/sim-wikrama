<div class="sidebar">
    <div class="d-flex align-items-center px-3 py-4 logo-container">
        <img class="logo" src="{{ asset('login/wikrama-logo.png') }}" alt="Logo">
        <div class="title">
            <p class="text-white ms-2 mb-0 logo-text">Inventaris <br> SMK Wikrama Bogor</p>
        </div>
    </div>
    <hr class="text-white">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="/user/dashboard" class="nav-link">
                <i class="bi bi-house me-2"></i>
                <span class="d-sm-inline nav-text">Dashboard</span>
            </a>
        </li>
        <li class="nav-item position-relative">
            <a href="{{ route('user.daftar-barang.index') }}" class="nav-link">
                
                <i class="bi bi-archive-fill me-2"></i>
                <span class="d-sm-inline nav-text">Daftar Barang</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="/user/peminjaman-barang" class="nav-link">
                <i class="bi bi-clock-history me-2"></i>
                <span class="d-sm-inline nav-text">Peminjaman</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="" class="nav-link">
                <i class="bi bi-laptop me-2"></i>
                <span class="d-sm-inline nav-text">Permintaan</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('user.daftar-siswa.index') }}" class="nav-link">
                <i class="bi bi-person-fill me-2"></i>
                <span class="d-sm-inline nav-text">Daftar Siswa</span>
            </a>
        </li>
    </ul>
</div>
