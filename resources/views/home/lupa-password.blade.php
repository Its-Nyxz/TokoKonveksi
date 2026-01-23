<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('foto/logonya.jpeg') }}">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
            margin-top: 50px;
        }
        .btn-login {
            background-color: #ffbf0f;
            color: #fff;
            border: none;
        }
        .btn-login:hover {
            background-color: #a77c06;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="login-form">
                <h4 class="text-center">Lupa Password</h4>
                <p class="text-center">Masukkan email terdaftar untuk menerima OTP</p>

                <form method="POST" action="{{ url('home/lupa-password') }}">
                    @csrf
                    <div class="form-group">
                        <label>Email*</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-login btn-block">
                        Kirim OTP
                    </button>

                    <a href="{{ url('home/login') }}" class="d-block text-center mt-3">
                        Kembali ke Login
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

@vite(['resources/css/app.css', 'resources/js/app.js'])
<x-sweetalert />
</body>
</html>
