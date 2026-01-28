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
                    @php
                        $grandTotal = $totalbelanja + (int)$datapembelian->ongkir;
                        $dpAmount = 0;
                        $lunasAmount = 0;
                        $hasDpProof = false;
                        if (isset($pembayaran)) {
                            foreach ($pembayaran as $p) {
                                $tipe = strtolower(trim($p->tipe));
                                $jumlah = (int) $p->jumlah;
                                if ($tipe == 'dp') {
                                    $dpAmount += $jumlah;
                                    if (!empty(trim($p->bukti))) {
                                        $hasDpProof = true;
                                    }
                                } else {
                                    $lunasAmount += $jumlah;
                                }
                            }
                        }
                        $calculatedDp50 = (int) round($grandTotal * 0.5);
                    @endphp

                    {{-- 1) Jika belum ada pembayaran dan status 'Belum Bayar' -> tunjukkan DP 50% dan sisa --}}
                    @if($dpAmount == 0 && $lunasAmount == 0 && isset($datapembelian->statusbeli) && strtolower($datapembelian->statusbeli) == strtolower('Belum Bayar'))
                        @php
                            $remaining = $grandTotal - $calculatedDp50;
                        @endphp
                        <p>DP (50%): Rp {{ number_format($calculatedDp50) }}</p>
                        <p>Sisa yang harus dibayar: Rp {{ number_format($remaining) }}</p>
                        <p>PENGIRIMAN : {{ $datapembelian->alamat }}</p>

                    {{-- 2) Jika ada bukti DP tetapi belum pelunasan -> tampilkan DP, Pelunasan (sisa), Ongkir, Total --}}
                    @elseif($hasDpProof && $lunasAmount == 0)
                        @php
                            $remaining = max(0, $grandTotal - $dpAmount);
                            $totalTerbayar = min($grandTotal, $dpAmount + $lunasAmount);
                        @endphp
                        <p>DP: Rp {{ number_format($dpAmount) }}</p>
                        <p>Pelunasan (sisa): Rp {{ number_format($remaining) }}</p>
                        <p>ONGKIR: Rp {{ number_format((int)$datapembelian->ongkir) }}</p>
                        <p>TOTAL (Subtotal + Ongkir): Rp {{ number_format($grandTotal) }}</p>

                    {{-- 3) Jika sudah ada DP dan pelunasan tercatat --}}
                    @elseif($dpAmount > 0 && $lunasAmount > 0)
                        @php
                            $totalPaid = min($grandTotal, $dpAmount + $lunasAmount);
                        @endphp
                        <p>DP: Rp {{ number_format($dpAmount) }}</p>
                        <p>Pelunasan: Rp {{ number_format($lunasAmount) }}</p>
                        <p>ONGKIR: Rp {{ number_format((int)$datapembelian->ongkir) }}</p>
                        <p>TOTAL (Subtotal + Ongkir): Rp {{ number_format($grandTotal) }}</p>

                    {{-- 4) Default: tampilkan subtotal dan total penuh --}}
                    @else
                        <p>SUBTOTAL: Rp {{ number_format($totalbelanja) }}</p>
                        <p>ONGKIR: Rp {{ number_format($datapembelian->ongkir) }}</p>
                        <p>PENGIRIMAN : {{ $datapembelian->alamat }}</p>
                        <p>TOTAL : Rp {{ number_format($grandTotal) }}</p>
                    @endif

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
