@extends('home.templates.index')

@section('page-content')
    <style>
        .transaction-table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .transaction-table thead {
            background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
        }

        .transaction-table thead th {
            padding: 18px 8px !important;
            vertical-align: middle;
            color: #000 !important;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border: none;
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
            padding: 20px 8px !important;
            vertical-align: middle !important;
            font-size: 13px;
            word-wrap: break-word;
            overflow-wrap: break-word;
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
            word-break: break-all;
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
            line-height: 1.4;
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
            align-items: flex-start;
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

        .status-cell {
            min-width: 140px;
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
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-warning {
            background-color: #ff7f00 !important;
            border-color: #ff7f00 !important;
        }

        .btn-warning:hover {
            background-color: #e67300 !important;
            border-color: #e67300 !important;
        }

        .btn-upload {
            background-color: #ffbf0f !important;
            border-color: #ffbf0f !important;
        }

        .btn-upload:hover {
            background-color: #e6ac00 !important;
            border-color: #e6ac00 !important;
        }

        .btn-pending {
            background-color: #17a2b8 !important;
            border-color: #17a2b8 !important;
            cursor: default;
        }

        .btn-success {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }

        .btn-success:hover {
            background-color: #218838 !important;
            border-color: #218838 !important;
        }

        .btn-danger {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
        }

        .btn-danger:hover {
            background-color: #c82333 !important;
            border-color: #c82333 !important;
        }

        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
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
                padding: 12px 8px !important;
                font-size: 10px;
            }

            .transaction-table tbody td {
                padding: 15px 8px !important;
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
                flex-direction: column;
                gap: 8px;
            }

            .table-responsive {
                overflow-x: auto;
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
                                        <th width="3%">No</th>
                                        <th width="12%">ID Transaksi</th>
                                        <th width="15%">Daftar Produk</th>
                                        <th width="11%">Tanggal Order</th>
                                        <th width="10%">Total</th>
                                        <th width="9%">Metode</th>
                                        <th width="13%">Bukti Bayar</th>
                                        <th width="8%">QR Code</th>
                                        <th width="19%">Status</th>
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

                                            <td class="text-center status-cell">
                                                @if ($db->bukti_dp && !$db->bukti_lunas && $db->statusbeli != 'Belum Bayar')
                                                    <a href="{{ url('home/pelunasan/' . $db->idpembelianreal) }}"
                                                        class="btn btn-warning text-white"
                                                        style="background-color: #ff7f00;">
                                                        Lanjutkan Pelunasan
                                                    </a>
                                                @endif

                                                @if ($db->statusbeli == 'Belum Bayar')
                                                    <?php
                                                    $deadline = date('Y-m-d H:i', strtotime($db->waktu . ' +1 day'));
                                                    $harideadline = date('Y-m-d', strtotime($db->waktu . ' +1 day'));
                                                    $jamdeadline = date('H:i', strtotime($db->waktu . ' +1 day'));
                                                    ?>

                                                    @if (date('Y-m-d H:i') >= $deadline)
                                                        <span style="color: #e74c3c; font-weight: 600;">
                                                            Waktu pembayaran<br>telah habis
                                                        </span>
                                                    @else
                                                        <a href="{{ url('home/detailtransaksi/' . $db->idpembelianreal) }}"
                                                            class="btn btn-upload text-white">
                                                            Upload Bukti<br>Pembayaran Sebelum<br>
                                                            <?= tanggal($harideadline) . ' - Jam ' . $jamdeadline ?>
                                                        </a>
                                                    @endif
                                                @elseif ($db->statusbeli == 'Sudah Upload Bukti Pembayaran' || $db->statusbeli == 'Menunggu Konfirmasi')
                                                    <button class="btn btn-pending text-white">
                                                        Menunggu Konfirmasi Admin
                                                    </button>
                                                @elseif ($db->statusbeli == 'Pesanan Di Terima')
                                                    <a href="{{ url('home/detailtransaksi/' . $db->idpembelianreal) }}"
                                                        class="btn btn-upload text-white">
                                                        Pesanan Di Terima
                                                    </a>
                                                @elseif ($db->statusbeli == 'Selesai')
                                                    <button class="btn btn-success text-white">Selesai ✓</button>
                                                @elseif ($db->statusbeli == 'Pesanan Di Tolak')
                                                    <button class="btn btn-danger text-white">Pesanan Anda Di Tolak</button>
                                                @else
                                                    <button class="btn btn-success text-white">{{ $db->statusbeli }}</button>
                                                @endif
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