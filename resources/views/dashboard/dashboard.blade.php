@extends('components.app')

@section('content')
    <style>
        table {
            width: 100%;
            /* max-width: 720px; */
            border-collapse: separate;
            border-spacing: 10px 15px;
        }

        th,
        td {
            text-align: center;
        }

        td.bg-success-subtle {
            color: green;
            border-radius: 10px;
        }

        td.bg-danger-subtle {
            color: rgb(255, 0, 0);
            border-radius: 10px;
        }

        .count {
            font-size: 26px;
            font-weight: bold;
        }

        .count-text {
            font-size: 14px;
            margin-left: 5px;
        }

        .chart-container {
            margin-top: 25px;
        }

        .table-chart-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .card {
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.1), 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .icon-background {
            background-color: #042456;
            color: #fff;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .card:hover {
            background-color: #042456;
            color: #fff;
        }

        .card:hover .icon-background {
            background-color: #fff;
            color: #042456;
        }

        .right-sidebar {
            width: 250px;
            position: fixed;
            top: 20px;
            right: -300px;
            bottom: 20px;
            background-color: rgb(255, 255, 255);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2), 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            z-index: 1000;
            transition: right 0.5s ease;
            border-radius: 20px;
        }

        .sidebar-open {
            right: 0;
        }

        .sidebar-date {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #042456;
        }

        .sidebar-profile {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar-profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .sidebar-profile h6 {
            margin-bottom: 5px;
        }

        .sidebar-welcome {
            font-weight: bold;
            margin-bottom: 40px;
            color: #042456;
        }

        .sidebar-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 10px;
        }

        .sidebar-icon {
            background-color: #042456;
            color: white;
            padding: 15px;
            font-size: 18px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .sidebar-icon:hover {
            background-color: rgb(255, 255, 255);
            cursor: pointer;
            color: #042456;
        }

        .sidebar-bottom-text {
            margin-top: auto;
            font-size: 18px;
            color: gray;
        }

        .close-sidebar {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 24px;
            color: #042456;
        }

        .user-button {
            position: fixed;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            background-color: #042456;
            color: white;
            padding: 10px;
            font-size: 20px;
            cursor: pointer;
        }

        @media (max-width: 750px) {
            .table-chart-container {
                flex-direction: column;
            }

            h5.table-title {
                text-align: center;
            }

            th,
            td {
                font-size: 15px;
            }

            table {
                width: 100%;
                max-width: 100%;
                overflow-x: auto;
            }

            td.bg-danger-subtle,
            td.bg-success-subtle {
                font-size: 10px;
            }

            .chart-container {
                margin-top: -55px;
                width: 100%;
                max-width: 400px;
                justify-content: center;
                align-items: center;
                display: flex;
                flex-direction: column;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="container-fluid">
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

    </div>

    <script>
        const ctx = document.getElementById('myBarChart').getContext('2d');
        const myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Dipinjamkan',
                    data: [10, 12, 15, 8, 12, 10, 8],
                    backgroundColor: '#042456',
                    hoverOffset: 4
                }, {
                    label: 'Dalam Peminjaman',
                    data: [8, 10, 12, 15, 8, 12, 10],
                    backgroundColor: '#0d6efd',
                    hoverOffset: 4
                }, {
                    label: 'Dikembalikan',
                    data: [8, 10, 12, 15, 8, 12, 10],
                    backgroundColor: '#0dcaf0',
                    hoverOffset: 4
                
                }, {
                    label: 'Barang Rusak',
                    data: [8, 10, 12, 15, 8, 12, 10],
                    backgroundColor: '#7CF5FF',
                    hoverOffset: 4
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });
    </script>

    <script>
        function openSidebar() {
            document.getElementById('right-sidebar').classList.add('sidebar-open');
        }

        function closeSidebar() {
            document.getElementById('right-sidebar').classList.remove('sidebar-open');
        }

        function displayDate() {
            const dateElement = document.getElementById('sidebar-date');
            const now = new Date();

            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const formattedDate = now.toLocaleDateString('en-US', options);

            dateElement.innerHTML = formattedDate;
        }

        displayDate();
    </script>
@endsection
