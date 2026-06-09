@extends('home.templates.index')

@php
    $settings = DB::table('settings')->pluck('value', 'key');
@endphp

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
                        <h3 style="color: black; font-weight:bold;">
                            {{ $settings['tentang_kami_judul'] ?? 'Tentang Oldshine Konveksi' }}
                        </h3>
                        <p style="color: black; font-size: 1.1rem; line-height: 1.7;">
                            {!! nl2br(e($settings['tentang_kami_isi'] ?? 'Oldshine Konveksi adalah brand terpercaya yang bergerak di bidang konveksi dan produksi pakaian custom.')) !!}
                        </p>
                    </div>
                </div>

                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <img src="{{ asset('foto/' . ($settings['tentang_kami_foto'] ?? 'logo.jpg')) }}" width="100%"
                        style="border-radius: 10px; max-height: 400px; object-fit: cover; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
                </div>
            </div>
        </div>
    </section>
@endsection
