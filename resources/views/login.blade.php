<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventaris</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Lexend Deca', sans-serif;
        }

        .logo {
            width: 60px; height: 60px;
        }

        .login-frame {
            width: 400px; height: 400px;
        }

    </style>    
</head>

<body>
    <div class="p-5">
        <div class="d-flex mb-5">
            <img class="logo mx-2" src="{{ asset('login/wikrama-logo.png') }}">
            <h5 class="text-primary">Inventaris <span class="text-secondary"> <br> SMK Wikrama Bogor </span></h5>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img class="login-frame" src="{{ asset('login/frame-login.png') }}">
            </div>
            <div class="col-md-6">
                <div class="">
                    <div class="">
                        <h1 class="text-primary fs-1">Selamat Datang!</h1>
                        <h4 class="mb-5">Ada banyak peminjam yang menunggumu!</h4>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                            aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-lock"></i></span>
                        <input type="text" class="form-control" placeholder="password" aria-label="Password"
                            aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
