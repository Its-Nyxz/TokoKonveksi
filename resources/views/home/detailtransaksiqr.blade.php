<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-color: #f8f9fa;">

    <div class="container mt-5 mb-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Detail Transaksi</h2>
            <p class="text-muted">Berikut adalah informasi lengkap transaksi Anda.</p>
        </div>

        <!-- Informasi Pembelian -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white fw-bold">
                Informasi Pembelian
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <p><strong>No Transaksi:</strong> {{ $pembelian->notransaksi }}</p>
                        <p><strong>Nama:</strong> {{ $pembelian->nama }}</p>
                        <p><strong>Email:</strong> {{ $pembelian->email }}</p>
                        <p><strong>Telepon:</strong> {{ $pembelian->telepon }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Alamat Pengiriman:</strong> {{ $pembelian->alamat }}</p>
                        <p><strong>Lokasi Tujuan:</strong> {{ $pembelian->lokasi }}</p>
                        <p><strong>Metode Pembayaran:</strong> {{ $pembelian->metodepembayaran }}</p>
                        <p><strong>Status:</strong> <span
                                class="badge bg-warning text-dark">{{ $pembelian->statusbeli }}</span></p>
                        <p><strong>Tanggal:</strong> {{ date('d M Y, H:i', strtotime($pembelian->waktu)) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produk yang Dibeli -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-secondary text-white fw-bold">
                Produk yang Dibeli
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalbelanja = 0; @endphp
                            @foreach ($produk as $item)
                                @php $totalbelanja += $item->subharga; @endphp
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td class="text-center">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $item->jumlah }}</td>
                                    <td class="text-end">Rp {{ number_format($item->subharga, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Subtotal</th>
                                <th class="text-end">Rp {{ number_format($totalbelanja, 0, ',', '.') }}</th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Ongkir</th>
                                <th class="text-end">Rp {{ number_format($pembelian->ongkir, 0, ',', '.') }}</th>
                            </tr>
                            <tr class="table-success">
                                <th colspan="3" class="text-end">Total</th>
                                <th class="text-end">Rp
                                    {{ number_format($pembelian->totalbeli + $pembelian->ongkir, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- QR Code -->
        @if ($pembelian->qrcode)
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-success text-white fw-bold">
                    QR Code Transaksi
                </div>
                <div class="card-body text-center">
                    <p>Scan QR Code berikut untuk melihat detail transaksi:</p>
                    <img src="{{ asset('qr/' . $pembelian->qrcode) }}" alt="QR Code" class="img-thumbnail"
                        style="max-width: 200px;">
                </div>
            </div>
        @endif

        <!-- Tombol Aksi -->
        <div class="text-center">
            <a href="{{ url('home/riwayat') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left-circle"></i> Kembali ke Riwayat
            </a>
        </div>
    </div>

    <!-- Optional: Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-sweetalert />
</body>

</html>
