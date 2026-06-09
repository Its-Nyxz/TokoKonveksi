@extends('home.templates.index')

@section('page-content')
    <style>
        .price-wrapper {
            background-color: #333333;
            padding: 10px;
            width: 100%;
            text-align: center;
            border-radius: 5px;
            display: inline-block;
            color: #fff;
            margin-top: 10px;
        }

        .price {
            margin: 0;
        }

        .quantity-wrapper {
            display: flex;
            align-items: center;
        }

        .quantity-input {
            width: 60px;
            margin: 0 10px;
            text-align: center;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .quantity-btn {
            background-color: #ffbf0f;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        .description {
            margin-top: 20px;
        }

        .best-product .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .best-product .product-card img {
            border-radius: 10px;
            margin-bottom: 10px;
            max-height: 200px;
            object-fit: cover;
        }

        .best-product .product-card h3 {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .best-product .product-card .price {
            font-size: 14px;
            color: #ffbf0f;
            font-weight: bold;
            margin-top: auto;
        }

        .best-product .product-card .sale {
            background-color: #ffbf0f;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            position: absolute;
            top: 10px;
            left: 10px;
        }
    </style>

    <section class="ftco-section">
        <div class="container">
            <div class="row mt-5">
                @php
                    $photos = explode(',', $produk->foto);
                    $mainPhoto = $photos[0];
                @endphp
                <div class="col-lg-6 mb-5 ftco-animate">
                    <a href="{{ asset('foto/' . $mainPhoto) }}" id="mainProductLink" class="image-popup d-block" style="height: auto; background: transparent; box-shadow: none;">
                        <img id="mainProductImg" src="{{ asset('foto/' . $mainPhoto) }}" alt="Product Image" style="border-radius: 10px; object-fit: cover; width: 100%; height: auto; max-height: 450px; display: block;">
                    </a>
                    @if (count($photos) > 1)
                        <div class="row mt-3 px-2">
                            @foreach ($photos as $ph)
                                <div class="col-3 p-1">
                                    <img src="{{ asset('foto/' . $ph) }}" class="img-thumbnail img-fluid thumbnail-gallery" style="cursor: pointer; height: 80px; width: 100%; object-fit: cover; border-radius: 5px; transition: transform 0.2s;" onclick="changeMainImage('{{ asset('foto/' . $ph) }}')" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                    <h3 style="color: black;">{{ $produk->nama }}</h3>
                    <p style="color: black;">Kota Asal Pengiriman : Kabupaten Wonogiri</p>
                    <hr>
                    <div class="price-wrapper">
                        <p class="price">
                            @if (!empty($produk->harga_sebelum) && $produk->harga_sebelum > $produk->harga)
                                <span style="color: #bbb; text-decoration: line-through; font-size: 0.85em; margin-right: 12px;">Rp. {{ number_format($produk->harga_sebelum) }}</span>
                            @endif
                            <span style="color: white; font-weight: bold;">Rp. {{ number_format($produk->harga) }}</span>
                        </p>
                    </div>

                    <form method="post" action="{{ url('home/pesan') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="idproduk" value="{{ $produk->idproduk }}">

                        <div class="form-group">
                            <label for="jumlah">Jumlah:</label>
                            <div class="quantity-wrapper">
                                <button type="button" class="quantity-btn" id="decrease">-</button>
                                <input type="text" id="jumlah" value="1" class="quantity-input"
                                    name="jumlah" min="1" required>
                                <button type="button" class="quantity-btn" id="increase">+</button>
                            </div>
                        </div>

                        <p class="mt-3">Kategori: <span style="color: #ffbf0f;">{{ $produk->namakategori }}</span></p>
                        <button class="btn float-right text-white" style="background-color: #ffbf0f !important;"
                            name="beli">ADD KERANJANG</button>
                    </form>
                </div>
            </div>
            <div class="description card p-4 shadow-sm border-0 mb-5" style="border-radius: 12px; background: #fafafa;">
                <h3 class="text-black font-weight-bold mb-3" style="border-bottom: 2px solid #ffbf0f; display: inline-block; padding-bottom: 5px;">Deskripsi</h3>
                <div style="color: #555; line-height: 1.6;">
                    {!! $produk->deskripsi !!}
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById("increase").addEventListener("click", function() {
            var input = document.getElementById("jumlah");
            var currentValue = parseInt(input.value) || 0;
            input.value = currentValue + 1;
        });

        document.getElementById("decrease").addEventListener("click", function() {
            var input = document.getElementById("jumlah");
            var currentValue = parseInt(input.value) || 0;
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        });

        function changeMainImage(src) {
            document.getElementById("mainProductImg").src = src;
            document.getElementById("mainProductLink").href = src;
        }
    </script>
@endsection
