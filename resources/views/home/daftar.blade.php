<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun Baru</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('foto/logonya.jpeg') }}">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .registration-form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        .registration-form h2 {
            margin-bottom: 20px;
        }

        .registration-form .form-group label {
            font-weight: bold;
        }

        .btn-register {
            background-color: #ffbf0f;
            color: #fff;
            border: none;
        }

        .btn-register:hover {
            background-color: #a77c06;
        }

        .login-link {
            margin-top: 10px;
            display: block;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="registration-form mt-5">
                    <h2 class="text-center">Registrasi Akun Baru</h2>
                    <p class="text-center">Silahkan melakukan registrasi dengan menggunakan data Anda yang valid</p>
                    <form method="post" action="{{ url('home/dodaftar') }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nama">Nama Lengkap*</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="telepon">No. Telephone*</label>
                                <input type="text" class="form-control" id="telepon" name="telepon" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email*</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tempatLahir">Tempat Lahir*</label>
                                <input type="text" class="form-control" id="tempatLahir" name="tempat_lahir"
                                    required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tanggalLahir">Tanggal Lahir*</label>
                                <input type="date" class="form-control" id="tanggalLahir" name="tgl_lahir" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="jenisKelamin">Jenis Kelamin*</label>
                                <select class="form-control" id="jenisKelamin" name="jekel" required>
                                    <option value="">Pilih</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="password">Password*</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="confirmPassword">Konfirmasi Password*</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                                    required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-register btn-block">Registrasi</button>
                        <a href="/home/login" class="login-link" style="color: black;">Sudah punya akun? <span
                                style="color: #ffbf0f;">Login</span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
