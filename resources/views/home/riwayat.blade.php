@extends('home.templates.index')

@section('page-content')
    <style>
        .transaction-table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            table-layout: auto;
        }

        .transaction-table thead {
            background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
        }

        .transaction-table thead th {
            padding: 18px 15px !important;
            vertical-align: middle;
            color: #000 !important;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border: none;
            white-space: nowrap;
            min-width: 80px;
        }

        .transaction-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s ease;
        }

        .transaction-table tbody tr:hover {
            background-color: #f8f9ff;
        }

        .transaction-table tbody tr:last-child {
            border-bottom: none;
        }

        .transaction-table tbody td {
            padding: 20px 15px !important;
            vertical-align: middle !important;
            font-size: 13px;
            white-space: nowrap;
        }

        /* Kolom No */
        .transaction-table thead th:nth-child(1),
        .transaction-table tbody td:nth-child(1) {
            min-width: 60px;
        }

        /* Kolom ID Transaksi */
        .transaction-table thead th:nth-child(2),
        .transaction-table tbody td:nth-child(2) {
            min-width: 180px;
        }

        /* Kolom Daftar Produk */
        .transaction-table thead th:nth-child(3),
        .transaction-table tbody td:nth-child(3) {
            min-width: 220px;
            white-space: normal;
        }

        /* Kolom Tanggal Order */
        .transaction-table thead th:nth-child(4),
        .transaction-table tbody td:nth-child(4) {
            min-width: 160px;
        }

        /* Kolom Total */
        .transaction-table thead th:nth-child(5),
        .transaction-table tbody td:nth-child(5) {
            min-width: 140px;
        }

        /* Kolom Metode */
        .transaction-table thead th:nth-child(6),
        .transaction-table tbody td:nth-child(6) {
            min-width: 120px;
        }

        /* Kolom Bukti Bayar */
        .transaction-table thead th:nth-child(7),
        .transaction-table tbody td:nth-child(7) {
            min-width: 200px;
        }

        /* Kolom QR Code */
        .transaction-table thead th:nth-child(8),
        .transaction-table tbody td:nth-child(8) {
            min-width: 120px;
        }

        /* Kolom Status */
        .transaction-table thead th:nth-child(9),
        .transaction-table tbody td:nth-child(9) {
            min-width: 160px;
        }

        /* Kolom Aksi */
        .transaction-table thead th:nth-child(10),
        .transaction-table tbody td:nth-child(10) {
            min-width: 100px;
        }

        .transaction-id {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: #667eea;
            background: #f0f4ff;
            padding: 4px 8px;
            border-radius: 5px;
            display: inline-block;
            font-size: 11px;
        }

        .product-list {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }

        .product-list li {
            padding: 4px 0;
            position: relative;
            padding-left: 15px;
            line-height: 1.6;
            font-size: 12px;
        }

        .product-list li:before {
            content: "•";
            position: absolute;
            left: 0;
            color: #667eea;
            font-weight: bold;
            font-size: 16px;
        }

        .date-time-box {
            background: #f8f9fa;
            padding: 6px 10px;
            border-radius: 6px;
            display: inline-block;
        }

        .date-time-box .date {
            font-weight: 600;
            color: #2c3e50;
            display: block;
            margin-bottom: 2px;
            font-size: 12px;
        }

        .date-time-box .time {
            color: #7f8c8d;
            font-size: 11px;
        }

        .price-tag {
            font-weight: 700;
            color: #27ae60;
            font-size: 13px;
            background: #e8f8f5;
            padding: 5px 10px;
            border-radius: 6px;
            display: inline-block;
        }

        .payment-method {
            background: #fff3cd;
            color: #856404;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .payment-proof-container {
            display: flex;
            flex-direction: row;
            gap: 10px;
            align-items: center;
            justify-content: center;
        }

        .proof-section {
            background: #f8f9fa;
            padding: 8px;
            border-radius: 8px;
            width: auto;
            text-align: center;
            flex: 0 0 auto;
        }

        .proof-section small {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #495057;
            font-size: 10px;
            text-transform: uppercase;
        }

        .proof-section img {
            border-radius: 6px;
            border: 2px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
            cursor: pointer;
            max-width: 70px;
        }

        .proof-section img:hover {
            transform: scale(1.05);
        }

        .proof-section strong {
            color: #adb5bd;
            font-size: 18px;
        }

        .qr-code-container {
            text-align: center;
        }

        .qr-code-container img {
            border-radius: 8px;
            border: 3px solid #667eea;
            padding: 5px;
            background: white;
            box-shadow: 0 2px 6px rgba(102, 126, 234, 0.2);
            transition: transform 0.2s ease;
            max-width: 90px;
        }

        .qr-code-container img:hover {
            transform: scale(1.1);
        }

        .status-badge {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 11px;
            white-space: nowrap;
        }

        .status-belum-bayar {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-upload {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status-diterima {
            background-color: #d4edda;
            color: #155724;
        }

        .status-dikirim {
            background-color: #cfe2ff;
            color: #084298;
        }

        .status-selesai {
            background-color: #28a745;
            color: white;
        }

        .status-ditolak {
            background-color: #dc3545;
            color: white;
        }

        .btn {
            border-radius: 8px;
            font-weight: 700;
            font-size: 11px;
            padding: 10px 14px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            line-height: 1.3;
            white-space: nowrap;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-detail {
            background-color: #667eea !important;
            border-color: #667eea !important;
            color: white !important;
        }

        .btn-detail:hover {
            background-color: #5568d3 !important;
            border-color: #5568d3 !important;
        }

        .table-responsive {
            border-radius: 10px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .page-title {
            color: black;
            font-weight: bold;
            margin-bottom: 30px;
            padding-bottom: 15px;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .transaction-table thead th {
                padding: 12px 10px !important;
                font-size: 10px;
            }

            .transaction-table tbody td {
                padding: 15px 10px !important;
                font-size: 11px;
            }

            .proof-section img {
                width: 50px !important;
                max-width: 50px !important;
            }

            .qr-code-container img {
                width: 60px !important;
                max-width: 60px !important;
            }

            .transaction-id {
                font-size: 10px;
                padding: 3px 6px;
            }

            .price-tag {
                font-size: 11px;
                padding: 4px 8px;
            }

            .btn {
                font-size: 10px;
                padding: 8px 10px;
            }

            .payment-proof-container {
                flex-direction: row;
                gap: 8px;
            }
        }
    </style>

    <section id="home-section" class="ftco-section">
        <div class="container mt-4">
            <h1 class="page-title">Riwayat Transaksi</h1>
            <div class="row">
                <div class="col-md-12 ftco-animate">
                    <div class="cart-list">
                        <div class="table-responsive">
                            <table class="table transaction-table">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>ID Transaksi</th>
                                        <th>Daftar Produk</th>
                                        <th>Tanggal Order</th>
                                        <th>Total</th>
                                        <th>Metode</th>
                                        <th>Bukti Bayar</th>
                                        <th>QR Code</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $nomor = 1; ?>
                                    @foreach ($databeli as $db)
                                        <tr>
                                            <td style="color: black;" class="text-center">
                                                <strong><?php echo $nomor; ?></strong>
                                            </td>
                                            <td style="color: black;">
                                                <span class="transaction-id">{{ $db->notransaksi }}</span>
                                            </td>
                                            <td>
                                                <ul class="product-list">
                                                    @foreach ($dataproduk[$db->idpembelianreal] as $dp)
                                                        <li style="color: black;">
                                                            {{ $dp->nama }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td class="text-center">
                                                <div class="date-time-box">
                                                    <span class="date">{!! tanggal($db->tanggalbeli) !!}</span>
                                                    <span class="time">{{ date('H:i', strtotime($db->waktu)) }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="price-tag">Rp {{ number_format($db->totalbeli) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="payment-method">{{ $db->metodepembayaran }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="payment-proof-container">
                                                    <div class="proof-section">
                                                        <small>DP:</small>
                                                        @if (!empty($db->bukti_dp) && file_exists(public_path('foto/' . $db->bukti_dp)))
                                                            <img width="70" src="{{ asset('foto/' . $db->bukti_dp) }}" alt="Bukti DP">
                                                        @else
                                                            <strong>-</strong>
                                                        @endif
                                                    </div>

                                                    <div class="proof-section">
                                                        <small>Lunas:</small>
                                                        @if (!empty($db->bukti_lunas) && file_exists(public_path('foto/' . $db->bukti_lunas)))
                                                            <img width="70" src="{{ asset('foto/' . $db->bukti_lunas) }}" alt="Bukti Lunas">
                                                        @else
                                                            <strong>-</strong>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <div class="qr-code-container">
                                                    <a href="{{ asset('qr/' . $db->qrcode) }}" target="_blank">
                                                        <img src="{{ asset('qr/' . $db->qrcode) }}" alt="qr-code" width="90">
                                                    </a>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                @if ($db->statusbeli == 'Belum Bayar')
                                                    <span class="status-badge status-belum-bayar">Belum Bayar</span>
                                                @elseif ($db->statusbeli == 'Sudah Upload Bukti Pembayaran' || $db->statusbeli == 'Menunggu Konfirmasi')
                                                    <span class="status-badge status-upload">Menunggu Konfirmasi</span>
                                                @elseif ($db->statusbeli == 'Pesanan Di Terima')
                                                    <span class="status-badge status-diterima">Pesanan Diterima</span>
                                                @elseif ($db->statusbeli == 'Sedang Dikirim' || $db->statusbeli == 'Pesanan Sedang Dikirim')
                                                    <span class="status-badge status-dikirim">Sedang Dikirim</span>
                                                @elseif ($db->statusbeli == 'Selesai')
                                                    <span class="status-badge status-selesai">Selesai</span>
                                                @elseif ($db->statusbeli == 'Pesanan Di Tolak')
                                                    <span class="status-badge status-ditolak">Pesanan Ditolak</span>
                                                @else
                                                    <span class="status-badge">{{ $db->statusbeli }}</span>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <a href="{{ url('home/detailtransaksi/' . $db->idpembelianreal) }}" class="btn btn-detail">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                        <?php $nomor++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        {{ $databeli->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection