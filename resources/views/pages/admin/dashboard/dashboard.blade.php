@extends('pages.components.sidebar-admin')

@section('content')
    <style>
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 14px;
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
    </style>
    <div class="container">
        <div class="d-flex justify-content-start mt-4">
            <h4 class="fw-bold mb-4">DAFTAR BARANG - ADMIN</h4>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-fill p-3 rounded me-2 icon-background"></i>
                            <div>
                                <h6 class="card-title mb-1">Jumlah User</h6>
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
                                <h6 class="card-title mb-1">Jumlah Perbaikan</h6>
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
                                <h6 class="card-title mb-1">Jumlah Permintaan</h6>
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
                                <h6 class="card-title mb-1">Barang Sekali Pakai</h6>
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
        <div class="chart-container mt-5" style="height: 400px">
            <h6>Kategori Barang Pinjaman</h6>
            <canvas id="myBarChart" style="width: 100%; height: 100%;"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const dates = @json($dates);
        const perbaikan = @json($perbaikan);
        const permintaan = @json($permintaan);
        const barang_sekali_pakai = @json($barang_sekali_pakai);

        const ctx = document.getElementById('myBarChart').getContext('2d');
        const myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dates, // Tanggal sebagai sumbu X
                datasets: [{
                        label: 'Perbaikan',
                        data: perbaikan,
                        backgroundColor: '#0d6efd',
                        hoverOffset: 4
                    },
                    {
                        label: 'Permintaan',
                        data: permintaan,
                        backgroundColor: '#0dcaf0',
                        hoverOffset: 4
                    },
                    {
                        label: 'Barang Sekali Pakai',
                        data: barang_sekali_pakai,
                        backgroundColor: '#7CF5FF',
                        hoverOffset: 4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
