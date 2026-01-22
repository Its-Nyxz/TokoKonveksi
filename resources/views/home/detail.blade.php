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
                <div class="col-lg-6 mb-5 ftco-animate">
                    <a href="{{ asset('foto/' . $produk->foto) }}" class="image-popup prod-img-bg"><img
                            src="{{ asset('foto/' . $produk->foto) }}" width="100%" alt="Product Image"></a>
                </div>
                <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                    <h3 style="color: black;">{{ $produk->nama }}</h3>
                    <p style="color: black;">Kota Asal Pengiriman : Kabupaten Jepara</p>
                    <hr>
                    <div class="price-wrapper">
                        <p class="price"><span style="color: white">Rp. {{ number_format($produk->harga) }}</span></p>
                    </div>

                    @if ($produk->stok > 0)
                        <form method="post" action="{{ url('home/pesan') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="idproduk" value="{{ $produk->idproduk }}">

                            <div class="form-group">
                                <label for="jumlah">Jumlah:</label>
                                <div class="quantity-wrapper">
                                    <button type="button" class="quantity-btn" id="decrease">-</button>
                                    <input type="text" id="jumlah" value="1" class="quantity-input"
                                        name="jumlah" min="1" max="{{ $produk->stok }}" required>
                                    <button type="button" class="quantity-btn" id="increase">+</button>
                                </div>
                            </div>

                            <p class="mt-3">Kategori: <span style="color: #ffbf0f;">{{ $produk->namakategori }}</span></p>
                            <p class="mt-3">Stok Tersedia: <span style="color: #ffbf0f;">{{ $produk->stok }}</span></p>
                            <button class="btn float-right text-white" style="background-color: #ffbf0f !important;"
                                name="beli">ADD KERANJANG</button>
                        </form>
                    @else
                        <p class="text-danger">Stok habis, produk tidak tersedia untuk dibeli saat ini.</p>
                    @endif
                </div>
            </div>
            <div class="description card py-2 px-2">
                <h2 class="text-black">Deskripsi :</h2>
                <p>{!! $produk->deskripsi !!}</p>
            </div>
        </div>
    </section>

    <script>
        document.getElementById("increase").addEventListener("click", function() {
            var input = document.getElementById("jumlah");
            var currentValue = parseInt(input.value);
            var maxValue = parseInt(input.max);
            if (currentValue < maxValue) {
                input.value = currentValue + 1;
            }
        });

        document.getElementById("decrease").addEventListener("click", function() {
            var input = document.getElementById("jumlah");
            var currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        });
    </script>
@endsection
