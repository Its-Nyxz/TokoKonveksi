<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Pembelian</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Laporan Pembelian</h1>
    <table>
        <thead>
            <tr>
                <th>ID Pembelian</th>
                <th>Nama Pengguna</th>
                <th>Tanggal Pembelian</th>
                <th>Total Pembelian</th>
                <th>Produk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembelian as $row)
                <tr>
                    <td>{{ $row->idpembelian }}</td>
                    <td>{{ $row->nama }}</td>
                    <td>{{ $row->tanggalbeli }}</td>
                    <td>{{ $row->totalbeli }}</td>
                    <td>
                        <ul>
                            @foreach ($dataproduk[$row->idpembelian] as $produk)
                                <li>{{ $produk->nama }} - {{ $produk->jumlah }} x {{ $produk->harga }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
