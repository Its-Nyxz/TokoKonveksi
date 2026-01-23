<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

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
                    <h4 class="text-center">Reset Password</h4>
                    <p class="text-center">Masukkan password baru Anda</p>

                    <form method="POST" action="{{ url('home/reset-password') }}">
                        @csrf
                        <div class="form-group">
                            <label>Password Baru*</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Konfirmasi Password*</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-login btn-block">
                            Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-sweetalert />
</body>

</html>
