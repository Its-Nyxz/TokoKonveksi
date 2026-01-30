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

        /* Filter & Search Bar Styles */
        .filter-search-container {
            margin-bottom: 25px;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
            max-width: 400px;
        }

        .search-wrapper input {
            width: 100%;
            padding: 12px 45px 12px 20px;
            border: 2px solid #ffbf0f;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
        }

        .search-wrapper input:focus {
            outline: none;
            border-color: #ffbf0f;
            background: white;
            box-shadow: 0 0 0 3px rgba(255, 191, 15, 0.15);
        }

        .search-wrapper .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            pointer-events: none;
        }

        .filter-dropdown-wrapper {
            position: relative;
        }

        .filter-toggle-btn {
            padding: 12px 20px;
            background: #ffbf0f;
            color: #000;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 8px rgba(255, 191, 15, 0.3);
        }

        .filter-toggle-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(255, 191, 15, 0.4);
            background: #f0b300;
        }

        .filter-toggle-btn .badge {
            background: rgba(0, 0, 0, 0.15);
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 700;
        }

        .filter-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            padding: 20px;
            min-width: 320px;
            z-index: 1000;
            display: none;
        }

        .filter-dropdown.active {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .filter-group {
            margin-bottom: 18px;
        }

        .filter-group:last-child {
            margin-bottom: 0;
        }

        .filter-group label {
            display: block;
            font-weight: 600;
            font-size: 12px;
            color: #333;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-group select {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 13px;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .filter-group select:focus {
            outline: none;
            border-color: #667eea;
            background: white;
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .btn-apply-filter {
            flex: 1;
            padding: 12px;
            background: #ffbf0f;
            color: #000;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-apply-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 191, 15, 0.4);
            background: #f0b300;
        }

        .btn-reset-filter {
            flex: 1;
            padding: 12px;
            background: white;
            color: #ffbf0f;
            border: 2px solid #ffbf0f;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-reset-filter:hover {
            background: #fffbf0;
        }

        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .top-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .page-title {
                margin-bottom: 15px;
            }

            .search-wrapper {
                max-width: 100%;
                margin-bottom: 15px;
            }

            .filter-dropdown {
                right: auto;
                left: 0;
                min-width: 100%;
            }

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
            <div class="top-bar">
                <h1 class="page-title">Riwayat Transaksi</h1>
            </div>

            <div class="filter-search-container">
                <form method="GET" id="filterForm">
                    <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                        <!-- Search Bar -->
                        <div class="search-wrapper">
                            <input type="text" 
                                   name="search" 
                                   placeholder="Cari nama produk..." 
                                   value="{{ request('search') }}">
                            <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </div>

                        <!-- Filter Dropdown -->
                        <div class="filter-dropdown-wrapper">
                            <button type="button" class="filter-toggle-btn" onclick="toggleFilter()">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="4" y1="6" x2="20" y2="6"></line>
                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                    <line x1="12" y1="18" x2="12" y2="18"></line>
                                </svg>
                                Filter
                                @if(request('sort_time') || request('status') || request('metode'))
                                    <span class="badge">{{ collect([request('sort_time'), request('status'), request('metode')])->filter()->count() }}</span>
                                @endif
                            </button>

                            <div class="filter-dropdown" id="filterDropdown">
                                <div class="filter-group">
                                    <label>Urutkan Waktu</label>
                                    <select name="sort_time">
                                        <option value="">Semua</option>
                                        <option value="time_desc" {{ request('sort_time')=='time_desc'? 'selected':'' }}>Terbaru</option>
                                        <option value="time_asc" {{ request('sort_time')=='time_asc'? 'selected':'' }}>Terlama</option>
                                    </select>
                                </div>

                                <div class="filter-group">
                                    <label>Status Pesanan</label>
                                    <select name="status">
                                        <option value="">Semua Status</option>
                                        <option value="Belum Bayar" {{ request('status')=='Belum Bayar'? 'selected':'' }}>Belum Bayar</option>
                                        <option value="Sudah Upload Bukti Pembayaran" {{ request('status')=='Sudah Upload Bukti Pembayaran'? 'selected':'' }}>Sudah Upload Bukti Pembayaran</option>
                                        <option value="Menunggu Konfirmasi" {{ request('status')=='Menunggu Konfirmasi'? 'selected':'' }}>Menunggu Konfirmasi</option>
                                        <option value="Pesanan Di Terima" {{ request('status')=='Pesanan Di Terima'? 'selected':'' }}>Pesanan Diterima</option>
                                        <option value="Sedang Dikirim" {{ request('status')=='Sedang Dikirim'? 'selected':'' }}>Sedang Dikirim</option>
                                        <option value="Selesai" {{ request('status')=='Selesai'? 'selected':'' }}>Selesai</option>
                                        <option value="Pesanan Di Tolak" {{ request('status')=='Pesanan Di Tolak'? 'selected':'' }}>Pesanan Di Tolak</option>
                                    </select>
                                </div>

                                <div class="filter-group">
                                    <label>Metode Pembayaran</label>
                                    <select name="metode">
                                        <option value="">Semua Metode</option>
                                        <option value="Transfer" {{ request('metode')=='Transfer' ? 'selected' : '' }}>Transfer</option>
                                        <option value="COD" {{ request('metode')=='COD' ? 'selected' : '' }}>COD</option>
                                        @if(!empty($paymentMethods))
                                            @foreach($paymentMethods as $pm)
                                                @if(in_array($pm, ['Transfer', 'COD']))
                                                    @continue
                                                @endif
                                                <option value="{{ $pm }}" {{ request('metode') == $pm ? 'selected' : '' }}>{{ $pm }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="filter-actions">
                                    <button type="submit" class="btn-apply-filter">Terapkan Filter</button>
                                    <button type="button" class="btn-reset-filter" onclick="resetFilter()">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row mt-3">
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
                                    @if($databeli->isEmpty())
                                        <tr>
                                            <td colspan="10" class="text-center" style="color:#7f8c8d;font-weight:600;padding:40px 0;">
                                                Tidak ada data sesuai filter.
                                            </td>
                                        </tr>
                                    @endif
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

    <script>
        function toggleFilter() {
            const dropdown = document.getElementById('filterDropdown');
            dropdown.classList.toggle('active');
        }

        function resetFilter() {
            // Reset semua select ke nilai default
            document.querySelector('select[name="sort_time"]').value = '';
            document.querySelector('select[name="status"]').value = '';
            document.querySelector('select[name="metode"]').value = '';
            // Reset search input
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) searchInput.value = '';
            
            // Submit form
            document.getElementById('filterForm').submit();
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('filterDropdown');
            const filterBtn = document.querySelector('.filter-toggle-btn');
            
            if (!dropdown.contains(event.target) && !filterBtn.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });

        // Prevent dropdown close when clicking inside
        document.getElementById('filterDropdown').addEventListener('click', function(event) {
            event.stopPropagation();
        });
    </script>
@endsection