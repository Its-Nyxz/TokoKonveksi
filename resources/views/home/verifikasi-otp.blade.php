<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
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
                    <h4 class="text-center">Verifikasi OTP</h4>
                    <p class="text-center">Masukkan kode OTP yang dikirim ke email Anda</p>

                    <form method="POST" action="{{ url('home/verifikasi-otp') }}">
                        @csrf
                        <div class="form-group">
                            <label>Kode OTP*</label>
                            <input type="text" name="otp" class="form-control text-center" maxlength="6"
                                required>
                        </div>

                        <button type="submit" class="btn btn-login btn-block">
                            Verifikasi
                        </button>
                    </form>

                    {{-- RESEND OTP --}}
                    <div class="text-center mt-3">
                        <small>Tidak menerima OTP?</small><br>
                        <form action="{{ url('home/resend-otp') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link p-0" style="color:#ffbf0f">
                                Kirim ulang OTP
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-sweetalert />
</body>

</html>
