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

    <!-- TANGGAL -->
    <table id="info">
        <tr>
            <td><strong>Tanggal Awal</strong></td>
            <td>: <?= tanggal($tanggalawal) ?></td>
        </tr>
        <tr>
            <td><strong>Tanggal Akhir</strong></td>
            <td>: <?= tanggal($tanggalakhir) ?></td>
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
                                <li>{{ $dp->nama }}</li>
                            @endforeach
                        </ul> 
                    </td>
                    <td>{{ tanggal(date('Y-m-d', strtotime($p->tanggalbeli))) }}</td>
                    <td>Rp {{ number_format($p->totalbeli) }}</td>
                    <td>{{ $p->metodepembayaran }}</td>
                    <td>{{ $p->statusbeli }}</td>
                </tr>
                <?php $nomor++; ?>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <th colspan="6">TOTAL PEMBELIAN</th>
                <th>Rp {{ number_format($totalPembelian) }}</th>
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
