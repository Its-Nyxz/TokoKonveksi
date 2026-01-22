@extends('home.templates.index')

@section('page-content')
    <style>
        .product {
            position: relative;
        }

        .sale-label {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #ffbf0f;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
            z-index: 10;
            /* Pastikan label muncul di atas gambar */
        }
    </style>

    <br>
    <br>
    <br>
    <br>
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-5">
                        <h1 style="color: black; font-weight:bold;">Tentang Kami</h1>
                        <br>
                        <h5 style="color: black; font-weight:bold;">
                            Oldshine Konveksi adalah brand terpercaya yang bergerak di bidang konveksi dan produksi pakaian
                            custom.
                        </h5>
                        <p>
                            Kami menyediakan berbagai jenis pakaian berkualitas seperti kaos, kemeja, hoodie, jaket, dan
                            seragam
                            untuk kebutuhan pribadi, komunitas, perusahaan, hingga event. Setiap produk dikerjakan dengan
                            standar
                            tinggi, menggunakan bahan pilihan dan proses produksi yang rapi serta profesional.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 d-flex justify-content-center">
                    <img src="{{ asset('foto/bg.jpg') }}" href="{{ url('home') }}" width="100%"
                        style="border-radius: 10px;">
                </div>
            </div>
        </div>
    </section>
@endsection
