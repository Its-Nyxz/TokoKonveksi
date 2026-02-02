@extends('home.templates.index')

@section('page-content')
    <style>
        .cart-table {
            background: white;
            border-radius: 10px;
            overflow: visible;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            table-layout: fixed;
        }

        .cart-table thead {
            background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
        }

        .cart-table thead th {
            padding: 18px 8px !important;
            vertical-align: middle;
            color: #000 !important;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border: none;
        }

        .cart-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s ease;
        }

        .cart-table tbody tr:hover {
            background-color: #f8f9ff;
        }

        .cart-table tbody tr:last-child {
            border-bottom: none;
        }

        .cart-table tbody td {
            padding: 20px 8px !important;
            vertical-align: middle !important;
            font-size: 13px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .product-image {
            border-radius: 10px;
            border: 3px solid #667eea;
            box-shadow: 0 2px 6px rgba(102, 126, 234, 0.2);
            transition: transform 0.2s ease;
            max-width: 100px;
        }

        .product-image:hover {
            transform: scale(1.05);
        }

        .product-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
        }

        .quantity-badge {
            background: #e8f4f8;
            color: #2c3e50;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 14px;
            display: inline-block;
            border: 2px solid #3498db;
        }

        .price-tag-cart {
            font-weight: 700;
            color: #27ae60;
            font-size: 14px;
            background: #e8f8f5;
            padding: 8px 12px;
            border-radius: 6px;
            display: inline-block;
        }

        .btn-delete {
            border-radius: 8px;
            font-weight: 700;
            font-size: 12px;
            padding: 10px 18px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            background-color: #e74c3c !important;
            border-color: #e74c3c !important;
            color: white;
        }

        .btn-delete:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            background-color: #c0392b !important;
            border-color: #c0392b !important;
        }

        .btn-action {
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            padding: 12px 24px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            background-color: #ffbf0f;
            color: white;
        }

        .btn-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            background-color: #e6ac00;
            color: white;
        }

        .btn-action i {
            margin-right: 5px;
        }

        .table-responsive {
            border-radius: 10px;
            overflow-x: auto;
            overflow-y: visible;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive::-webkit-scrollbar {
            height: 10px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #ffc107;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #ffb300;
        }

        .page-title {
            color: black;
            font-weight: bold;
            margin-bottom: 30px;
            padding-bottom: 15px;
            display: inline-block;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .empty-cart {
            color: #7f8c8d;
            font-size: 16px;
            font-weight: 600;
            padding: 40px 0;
        }

        @media (max-width: 768px) {
            .cart-table thead th {
                padding: 12px 6px !important;
                font-size: 10px;
            }

            .cart-table tbody td {
                padding: 15px 6px !important;
                font-size: 11px;
            }

            .product-image {
                max-width: 70px;
            }

            .product-name {
                font-size: 12px;
            }

            .quantity-badge {
                padding: 6px 12px;
                font-size: 12px;
            }

            .price-tag-cart {
                font-size: 12px;
                padding: 6px 10px;
            }

            .btn-delete {
                font-size: 10px;
                padding: 8px 12px;
            }

            .btn-action {
                font-size: 11px;
                padding: 10px 16px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .action-buttons a {
                width: 100%;
            }
        }
    </style>

    <section id="home-section" class="hero">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ftco-animate mt-5">
                    <div class="mt-5">
                        <h1 class="page-title">Keranjang Anda</h1>
                    </div>
                    <div class="cart-list mt-5">
                        <div class="table-responsive">
                            <table class="table cart-table">
                                <thead>
                                    <tr class="text-center">
                                        <th width="5%">No</th>
                                        <th width="15%"></th>
                                        <th width="30%">Produk</th>
                                        <th width="15%">Jumlah</th>
                                        <th width="20%">Total</th>
                                        <th width="15%">Aksi</th>
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
                                                <td style="color: black;">
                                                    <strong>{{ $nomor }}</strong>
                                                </td>
                                                <td class="image-prod">
                                                    <img src="{{ asset('foto/' . $item['foto']) }}" 
                                                         class="product-image" 
                                                         width="100">
                                                </td>
                                                <td>
                                                    <span class="product-name">{{ $item['nama'] }}</span>
                                                </td>
                                                <td>
                                                    <span class="quantity-badge">{{ $item['jumlah'] }}</span>
                                                </td>
                                                <td>
                                                    <span class="price-tag-cart">Rp {{ number_format($totalharga) }}</span>
                                                </td>
                                                <td>
                                                    <a href="{{ url('home/hapuskeranjang/' . $idproduk) }}" 
                                                       class="btn-delete">
                                                        Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php $nomor++; ?>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center empty-cart">
                                                🛒 Keranjang Kosong
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="action-buttons">
                        <a href="{{ url('home/produkdaftar') }}" class="btn-action">
                            <i class="fa fa-cart-plus"></i> Lanjutkan Belanja
                        </a>
                        @if (!empty($keranjang))
                            <a href="{{ url('home/checkout') }}" class="btn-action">
                                Lanjutkan ke Checkout
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection