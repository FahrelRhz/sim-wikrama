@extends('pages.components.app')

@section('content')
    <style>
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 14px;
        }

        th, td {
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
            background-color: #fff;
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
            background-color: #fff;
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

            th, td {
                font-size: 15px;
            }

            td.bg-danger-subtle,
            td.bg-success-subtle {
                font-size: 10px;
            }

            .chart-container {
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

    @include('pages.user.dashboard.dashboard-content')
    
    <div class="container-fluid">
        @yield('content')
    </div>

    <script>
        const ctx = document.getElementById('myBarChart').getContext('2d');
        const myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [
                    {
                        label: 'Dipinjamkan',
                        data: [10, 12, 15, 8, 12, 10, 8],
                        backgroundColor: '#042456',
                        hoverOffset: 4
                    },
                    {
                        label: 'Dalam Peminjaman',
                        data: [8, 10, 12, 15, 8, 12, 10],
                        backgroundColor: '#0d6efd',
                        hoverOffset: 4
                    },
                    {
                        label: 'Dikembalikan',
                        data: [8, 10, 12, 15, 8, 12, 10],
                        backgroundColor: '#0dcaf0',
                        hoverOffset: 4
                    },
                    {
                        label: 'Barang Rusak',
                        data: [8, 10, 12, 15, 8, 12, 10],
                        backgroundColor: '#7CF5FF',
                        hoverOffset: 4
                    }
                ]
            },
            options: {
                plugins: {
                    legend: {
                        display: true
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
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const formattedDate = now.toLocaleDateString('en-US', options);
            dateElement.innerHTML = formattedDate;
        }

        displayDate();
    </script>
@endsection
