<!DOCTYPE html>
<html>
<title>INVOICE</title>
<link rel="shortcut icon" type="image/x-icon" href="../assets/home/assets/img/logo/logo2.png">

<head>
    <style type="text/css">
        table {
            border-style: double;
            border-width: 3px;
            border-color: white;
        }

        table tr .text2 {
            text-align: right;
            p-size: 13px;
        }

        table tr .text {
            text-align: right;
            p-size: 13px;
        }

        table tr td {
            p-size: 13px;
        }

        @page {
            size: auto;
            margin: 0;
        }
    </style>
</head>

<body>
    <br><br><br>
    <center>
        <table style="width: 600px; p-size: 16pt; p-family: calibri; border-collapse: collapse;" border="0">
            <tr>
                {{-- <td><img src="{{ asset('foto/logonya1.png') }}" href="{{ url('home') }}" width="80"></td> --}}
                <td>
                    <p size="5" style="text-align: right"><b>INVOICE<b></p>
                    <p size="5" style="text-align: right"><b>Oldshine Konveksi</b></p>
                    <p size="3" style="text-align: right">oldshinekonveksi@gmail.com | 085229247413</p>
                </td>
            </tr>
        </table>
        <br>
        <table width="625">
            <tr style="float: right;">
                <td colspan="2">
                    <p>INVOICE NUMBER: {{ $datapembelian->notransaksi }}</p>
                    <p>INVOICE DATE : {{ tanggal(date('Y-m-d', strtotime($datapembelian->tanggalbeli))) }}</p>
                    <p>TO : {{ $datapembelian->nama }}</p>
                </td>
            </tr>
        </table>
        <br>
        <table width="625" style="border-collapse: collapse; box-shadow: 0 0 2px #DFE4EA;">
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="border-right: 1px solid #ddd; padding: 8px;">No Transaksi</td>
                <td style="border-right: 1px solid #ddd; padding: 8px;">Nama Produk</td>
                <td style="border-right: 1px solid #ddd; padding: 8px;">Tgl. Pesanan</td>
                <td style="padding: 8px;">Total Harga</td>
            </tr>
            <?php $totalbelanja = 0; ?>
            @foreach ($dataproduk as $dp)
                @php
                    $totalharga = $dp->harga * $dp->jumlah;
                @endphp
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="border-right: 1px solid #ddd; padding: 8px;">{{ $datapembelian->notransaksi }}</td>
                    <td style="border-right: 1px solid #ddd; padding: 8px;">{{ $dp->nama }}</td>
                    <td style="border-right: 1px solid #ddd; padding: 8px;">
                        {{ tanggal(date('Y-m-d', strtotime($datapembelian->tanggalbeli))) }}</td>
                    <td style="padding: 8px;">Rp {{ number_format($totalharga) }},-</td>
                </tr>
                <?php $totalbelanja += $totalharga; ?>
            @endforeach
        </table><br><br>
        <table width="625">
            <tr style="float: right; border-collapse: collapse; box-shadow: 0 0 2px #DFE4EA;">
                <td colspan="2">
                    <p>SUBTOTAL: Rp {{ number_format($totalbelanja) }}</p>
                    <p>ONGKIR: Rp {{ number_format($datapembelian->ongkir) }}</p>
                    <p>PENGIRIMAN : {{ $datapembelian->alamat }}</p>
                    <p>TOTAL : Rp {{ number_format($totalbelanja + $datapembelian->ongkir) }}</p>
                </td>
            </tr>
        </table>

        <br><br><br>
        <table width="625">
            <tr>
                <td colspan="2">
                    <p style="color: #635BFF;">PEMBAYARAN RESMI</p>
                    <p>Oldshine Konveksi</p>
                    <p>SWIFT/IBAN: NZ0201230012</p>
                    <p>Account number: 085229247413</p>
                    <p>For any questions please contact us atoldshinekonveksi@gmail.com</p>
                </td>
            </tr>
        </table>
    </center>
    <script>
        window.print();
    </script>
</body>

</html>
