<html>

<head>
    <title>Laporan Transaksi</title>
    <style type="text/css">
        body {
            font-family: "Segoe UI", Tahoma, sans-serif;
            font-size: 10pt;
            padding: 30px;
            -webkit-print-color-adjust: exact;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 18pt;
            font-weight: bold;
        }

        .header p {
            margin: 3px 0;
            color: #555;
            font-size: 10pt;
        }

        .divider {
            border-top: 3px solid #333;
            margin: 15px 0 25px;
        }

        table#info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11pt;
        }

        table#info td {
            padding: 6px 4px;
        }

        #table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
            margin-top: 10px;
        }

        #table th {
            background-color: #2b5797;
            color: white;
            padding: 8px;
            border: 1px solid black;
            text-align: center;
        }

        #table td {
            padding: 7px;
            border: 1px solid black;
            vertical-align: top;
        }

        #table tr:nth-child(even) {
            background-color: #f7f7f7;
        }

        #table tr:hover {
            background-color: #e8f0fe;
        }

        tfoot th {
            background-color: #2b5797;
            color: white;
            padding: 8px;
            border: 1px solid black;
            text-align: right;
        }

        .footer {
            margin-top: 40px;
            font-size: 10pt;
            text-align: right;
        }

        @page {
            size: A4;
            margin: 20mm;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <h2>LAPORAN TRANSAKSI</h2>
        <p>Oldshine Konveksi</p>
        <p>Piji, Pijiharjo, Manyaran, Wonogiri</p>
        <p>Telp: 0852-2924-7413 | Email: oldshinekonveksi@gmail.com</p>
    </div>

    <div class="divider"></div>

    <!-- TANGGAL & FILTER -->
    <table id="info">
        <tr>
            <td width="150px"><strong>Tanggal Awal</strong></td>
            <td width="250px">: <?= tanggal($tanggalawal) ?></td>
            <td width="150px"><strong>Status Filter</strong></td>
            <td>: {{ empty($status) ? 'Semua Status' : $status }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Akhir</strong></td>
            <td>: <?= tanggal($tanggalakhir) ?></td>
            <td><strong>Metode Pengiriman</strong></td>
            <td>: 
                @if (empty($metode))
                    Semua Metode
                @elseif (strtolower($metode) == 'transfer')
                    Dengan Kurir
                @elseif (strtolower($metode) == 'cod')
                    Tanpa Kurir
                @else
                    {{ $metode }}
                @endif
            </td>
        </tr>
    </table>

    <!-- TABLE TRANSAKSI -->
    <table id="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pembeli</th>
                <th>Daftar Produk</th>
                <th>Tanggal Pembelian</th>
                <th>Total Pembelian</th>
                <th>Metode</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 1; ?>
            @foreach ($pembelian as $p)
                <tr>
                    <td style="text-align:center;">{{ $nomor }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>
                        <ul style="margin: 0; padding-left: 18px;">
                            @foreach ($dataproduk[$p->idpembelian] as $dp)
                                <li>
                                    {{ $dp->nama }} ({{ $dp->jumlah }}x)
                                    @if ($dp->size_m > 0 || $dp->size_l > 0 || $dp->size_xl > 0 || $dp->size_xxl > 0)
                                        <small style="font-size: 8pt; color: #555;">
                                            (Size: 
                                            @if($dp->size_m > 0) M:{{ $dp->size_m }} @endif
                                            @if($dp->size_l > 0) L:{{ $dp->size_l }} @endif
                                            @if($dp->size_xl > 0) XL:{{ $dp->size_xl }} @endif
                                            @if($dp->size_xxl > 0) XXL:{{ $dp->size_xxl }} @endif
                                            )
                                        </small>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        @if ($p->size_m > 0 || $p->size_l > 0 || $p->size_xl > 0 || $p->size_xxl > 0)
                            <div style="font-size: 8.5pt; margin-top: 5px; font-style: italic; color: #555;">
                                Size: M:{{ $p->size_m }} | L:{{ $p->size_l }} | XL:{{ $p->size_xl }} | XXL:{{ $p->size_xxl }}
                            </div>
                        @endif
                    </td>
                    <td>{{ tanggal(date('Y-m-d', strtotime($p->tanggalbeli))) }}</td>
                    <td>Rp {{ number_format($p->totalbeli) }}</td>
                    <td>
                        @if (strtolower($p->metodepembayaran) == 'transfer')
                            Dengan Kurir
                        @elseif (strtolower($p->metodepembayaran) == 'cod')
                            Tanpa Kurir
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $p->statusbeli }}</td>
                </tr>
                <?php $nomor++; ?>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <th colspan="4" style="text-align: right;">TOTAL PEMBELIAN</th>
                <th style="text-align: left;">Rp {{ number_format($totalPembelian) }}</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <p>Wonogiri, <?= date('d F Y') ?></p>
        <br><br><br>
        <p><strong>Admin</strong></p>
    </div>

</body>

</html>

<script>
    window.print();
</script>
