@extends('components.app')

@section('content')
    <style>
        table {
            width: 100%;
            max-width: 720px;
            border-collapse: separate;
            border-spacing: 10px 15px;
        }

        th,
        td {
            padding: 15px;
            text-align: center;
        }

        td.bg-success-subtle {
            color: green;
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
            width: 300px;
            height: 300px;
        }

        .table-chart-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 20px;
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
                            <i class="bg-primary p-3 text-white rounded bi bi-gear-fill me-2 icon-background"></i>
                            <div>
                                <h5 class="card-title mb-1">Request Perbaikan</h5>
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
                            <i class="bg-primary p-3 text-white rounded bi bi-wrench me-2 icon-background"></i>
                            <div>
                                <h5 class="card-title mb-1">Sedang Diperbaiki</h5>
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
                            <i class="bg-primary p-3 text-white rounded bi bi-check-circle-fill me-2 icon-background"></i>
                            <div>
                                <h5 class="card-title mb-1">Selesai Perbaikan</h5>
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
                            <i class="bg-primary p-3 text-white rounded bi bi-check2-all me-2 icon-background"></i>
                            <div>
                                <h5 class="card-title mb-1">Selesai Diperbaiki</h5>
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

        <div class="table-chart-container mt-5">
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
                        <td>Daftar Barang</td>
                        <td class="bg-success-subtle fw-bold">Kembali</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane Smith</td>
                        <td>Daftar Barang</td>
                        <td class="bg-success-subtle fw-bold">Kembali</td>
                    </tr>
                </table>
            </div>

            <div class="chart-container">
                <canvas id="myPieChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('myPieChart').getContext('2d');
        const myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Barang Kembali', 'Barang Belum Kembali'],
                datasets: [{
                    data: [10, 1],
                    backgroundColor: ['#0d6efd', '#0dcaf0'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endsection
