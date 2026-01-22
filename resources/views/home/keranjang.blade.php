@extends('home.templates.index')

@section('page-content')
    <section id="home-section" class="hero">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ftco-animate mt-5">
                    <div class="mt-5">
                        <h1 style="color: black; font-weight:bold;">Keranjang Anda</h1>
                    </div>
                    <div class="cart-list mt-5">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th style="color: black;">No</th>
                                    <th style="color: black;"></th>
                                    <th style="color: black;">Produk</th>
                                    <th style="color: black;">Jumlah</th>
                                    <th style="color: black;">Total</th>
                                    <th style="color: black;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($keranjang))
                                    <?php $nomor = 1; ?>
                                    @foreach ($keranjang as $idproduk => $item)
                                        @php
                                            $totalharga = (float) $item['harga'] * (int) $item['jumlah'];
                                        @endphp
                                        <tr class="text-center">
                                            <td style="color: black;">{{ $nomor }}</td>
                                            <td class="image-prod">
                                                <img src="{{ asset('foto/' . $item['foto']) }}" width="100px"
                                                    style="border-radius: 10px;">
                                            </td>
                                            <td style="color: black;">{{ $item['nama'] }}</td>
                                            <td style="color: black;">{{ $item['jumlah'] }}</td>

                                            <td style="color: black;">Rp {{ number_format($totalharga) }}</td>
                                            <td>
                                                <a href="{{ url('home/hapuskeranjang/' . $idproduk) }}" class="btn btn-xs"
                                                    style="background-color: #ffbf0f; color: white">Hapus</a>
                                            </td>
                                        </tr>
                                        <?php $nomor++; ?>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">Keranjang Kosong</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="row justify-content-center float-right">
                <a href="{{ url('home/produkdaftar') }}" class="btn text-white" style="background-color: #ffbf0f;"><i
                        class="fa fa-cart-plus"></i> Lanjutkan
                    Belanja</a>
                &nbsp;
                @if (!empty($keranjang))
                    <a href="{{ url('home/checkout') }}" class="btn text-white" style="background-color: #ffbf0f">Lanjutkan
                        ke Checkout</a>
                @endif
            </div>
            <br><br>
        </div>
    </section>
@endsection
