<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventaris</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Lexend Deca', sans-serif;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            position: fixed;
            width: 250px;
            height: 100%;
            background-color: #343a40;
            transition: width 0.3s ease;
            z-index: 9999;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar .logo-container {
            display: flex;
            align-items: center;
            padding: 10px;
        }

        .sidebar .logo {
            width: 50px;
            height: 50px;
        }

        .sidebar .logo-text {
            display: block;
        }

        .sidebar.collapsed .logo-text {
            display: none;
        }

        .sidebar .nav-item {
            display: flex;
            align-items: center;
            padding: 10px;
            color: #fff;
        }

        .sidebar .nav-item:hover {
            background-color: #495057;
        }

        .sidebar .nav-link {
            color: #fff;
            width: 100%;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 10px;
            text-align: center;
        }

        .navbar {
            z-index: 9998;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .content.collapsed {
            margin-left: 80px;
        }

        @media (max-width: 750px) {
            .title {
                display: none;
            }

            .sidebar {
                width: 80px;
            }

            .sidebar .nav-link span {
                display: none;
            }

            .content {
                margin-left: 80px;
            }
        }
    </style>
</head>

<body>
    @include('components.navbar')
    @include('components.sidebar')

    <div class="content" id="content">
        @yield('content')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleButton = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const sidebarIcon = document.getElementById('sidebarIcon');

            toggleButton.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('collapsed');
                sidebarIcon.classList.toggle('bi-list');
                sidebarIcon.classList.toggle('bi-x');
            });

            const profileBtn = document.getElementById('profile-btn');
            const profileDropdown = document.getElementById('profile-dropdown');

            profileBtn.addEventListener('click', () => {
                profileDropdown.style.display = profileDropdown.style.display === 'none' || profileDropdown
                    .style.display === '' ? 'block' : 'none';
            });

            document.addEventListener('click', (event) => {
                if (!profileBtn.contains(event.target) && !profileDropdown.contains(event.target)) {
                    profileDropdown.style.display = 'none';
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
