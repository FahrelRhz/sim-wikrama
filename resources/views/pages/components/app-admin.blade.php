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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            font-family: 'Lexend Deca', sans-serif;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            position: fixed;
            width: 225px;
            height: 95%;
            background-color: #042456;
            z-index: 9999;
            border-radius: 30px;
            left: 20px;
            top: 20px;
            bottom: 20px;
        }

        .sidebar.collapsed {
            width: 80px;
            border-radius: 20px;
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
            transition: all 0.5s ease, color 0.5s ease;
            border-radius: 30px 0 0 30px;
            padding-left: 10px;
        }

        .sidebar .nav-item:hover,
        .sidebar .nav-item.active {
            background-color: #fff;
            color: #000;
            margin-left: 20px;
        }

        .sidebar .nav-item:hover .nav-link i,
        .sidebar .nav-item.active .nav-link i {
            color: #000;
        }

        .sidebar .nav-link {
            color: inherit;
            width: 100%;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: color 0.5s ease;
        }

        .sidebar .nav-link i {
            margin-right: 15px;
            transition: color 0.5s ease;
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

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.5s ease;
        }

        @media (max-width: 750px) {
            body {
                position: relative;
            }

            .sidebar {
                position: fixed;
                transform: translateY(calc(99vh - 75px));
                width: 100%;
                height: 75px;
                display: flex;
                flex-direction: row;
                justify-content: center;
                border-radius: 20px 20px 0 0;
                padding: 10px;
                left: 0;
                right: 0;
                z-index: 9999;
                background-color: #042456;
            }

            .sidebar .nav-item {
                border-radius: 50%;
                max-width: 50px;
                max-height: 50px;
                font-size: 20px;
                text-align: center;
                position: relative;
                backface-visibility: hidden;
            }

            .sidebar .nav-link {
                display: flex;
                flex-direction: column;
            }

            .sidebar .nav-link span {
                display: none;
            }

            .sidebar .logo {
                display: none;
            }

            .sidebar .logo-text {
                display: none;
            }

            .content {
                position: relative;
                margin-left: 0;
                margin-bottom: 75px;
            }
        }
    </style>

</head>

<body>
    @include('pages.components.sidebar-admin')

    <div class="content" id="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>

</html>
