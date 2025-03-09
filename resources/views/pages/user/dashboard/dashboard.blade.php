@extends('pages.components.sidebar')

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
            <h4 class="fw-bold mb-4">DAFTAR BARANG - {{ $user->name }}</h4>
        </div>

        <div class="row g-4 fs-5">
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
                                <h5 class="card-title mb-1">Sedang Dipinjam</h5>
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

        <h5 class="table-title mt-3">Status Terbaru</h5>
        <div class="table-chart-container fs-6 text-center">
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
                                <td
                                    class="{{ $status->status_pinjam == 'kembali' ? 'bg-success-subtle' : 'bg-danger-subtle' }} fw-bold">
                                    {{ $status->status_pinjam == 'kembali' ? 'Kembali' : 'Dipinjam' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Grafik --}}
        <div class="chart-container" style="height: 250px">
            <h5>Kategori Barang Pinjaman</h5>
            <canvas id="myBarChart" style="width: 100%; height: 100%;"></canvas>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const dates = @json($dates);
        // const barang = @json($barang);
        const dipinjam = @json($dipinjam);
        const kembali = @json($kembali);
        const rusak = @json($rusak);

        console.log(kembali);

        const ctx = document.getElementById('myBarChart').getContext('2d');
        const myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dates, // Tanggal sebagai sumbu X
                datasets: [
                    // {
                    //     label: 'Barang',
                    //     data: barang,
                    //     backgroundColor: '#042456',
                    //     hoverOffset: 4
                    // },
                    {
                        label: 'Dipinjam',
                        data: dipinjam,
                        backgroundColor: '#0d6efd',
                        hoverOffset: 4
                    },
                    {
                        label: 'Dikembalikan',
                        data: kembali,
                        backgroundColor: '#0dcaf0',
                        hoverOffset: 4
                    },
                    {
                        label: 'Barang Rusak',
                        data: rusak,
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
