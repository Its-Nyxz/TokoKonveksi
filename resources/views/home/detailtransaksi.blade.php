@extends('home.templates.index')

@section('page-content')
    <section id="home-section" class="ftco-section">
        <div class="container mt-4">
            <?php if ($datapembelian->statusbeli == "Belum Bayar") { ?>
            <div>
                <div class="card text-center" style="background-color: #ffbf0f;">
                    <p style="color: white;" class="m-auto py-3">
                        {{-- <img src="{{ asset('foto/1b.png') }}" href="{{ url('home') }}" width="20"> Detail Informasi
                        <img src="{{ asset('foto/line.png') }}" href="{{ url('home') }}" width="20">
                        <img src="{{ asset('foto/2b.png') }}" href="{{ url('home') }}" width="20"> Pembayaran
                        <img src="{{ asset('foto/line.png') }}" href="{{ url('home') }}" width="20">
                        <img src="{{ asset('foto/3a.png') }}" href="{{ url('home') }}" width="20"> Konfirmasi --}}
                        Pembayaran
                    </p>
                </div>
            </div>
            <div class="mt-5">
                <h1 style="color: black; font-weight:bold;">Pembayaran</h1>
            </div>
            <?php } ?>
            <div class="row">
                <div class="col-md-8">
                    <?php if ($datapembelian->statusbeli == "Belum Bayar") { ?>
                    <div class="card py-2 mb-5 px-2 text-justify">
                        <h3 style="color: black;">Catatan :</h3>
                        <ul>
                            <li>Untuk pembayaran via Transfer, verifikasi pembayaran akan dilakukan saat anda sudah
                                melakukan transfer ke rekening Oldshine Konveksi.</li>
                            <li>Jangan lupa anda screenshot bukti pembayaran yang nantinya akan dilampirkan di halaman
                                konfirmasi.</li>
                        </ul>
                        <p class="text-center">Rekening Oldshine Konveksi</p>
                        <div class="card text-center" style="background-color: #000;">
                            <p style="color: #fff;" class="m-auto py-3">BANK BRI <br> <span
                                    style="color: #43A86B; font-weight:bold; font-size:25px">034101000743001</span></p>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="card py-2 px-2 text-justify">
                        <h3 style="color: black; font-weight:bold;">Rincian Harga</h3>

                        <?php $totalbelanja = 0; ?>
                        @foreach ($dataproduk as $dp)
                            @php
                                $totalharga = $dp->harga * $dp->jumlah;
                            @endphp
                            <div class="row">
                                <div class="col-md-8">
                                    <p style="color: black;">{{ $dp->nama }} ({{ $dp->jumlah }} x) Rp
                                        {{ number_format($dp->harga) }},-</p>
                                </div>
                                <div class="col-md-4">
                                    <p style="color: black;font-weight: bold;" class="text-right">Rp
                                        {{ number_format($totalharga) }},-</p>
                                </div>
                            </div>
                            <?php $totalbelanja += $totalharga; ?>
                        @endforeach
                        <hr>
                        <div class="row">
                            <div class="col-md-8">
                                <h5 style="color: black; font-weight:bold;">Ongkir</h5>
                            </div>
                            <div class="col-md-4">
                                <p style="color: black; font-weight:bold;" class="text-right">Rp
                                    {{ number_format($datapembelian->ongkir) }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <h5 style="color: black; font-weight:bold;">Total</h5>
                            </div>
                            <div class="col-md-4">
                                <p style="color: black; font-weight:bold;" class="text-right">Rp
                                    {{ number_format($datapembelian->totalbeli + $datapembelian->ongkir) }} <br> <span
                                        style="color: red; font-weight:400;">NON
                                        REFUNDABLE</span></p>
                            </div>
                        </div>
                        <hr>

                        {{-- Tampilkan DP atau Lunas --}}
                        @if ($datapembelian->tipepembayaran == 'DP')
                            @php
                                $harusBayar = ($datapembelian->totalbeli + $datapembelian->ongkir) * 0.5;
                            @endphp

                            <div class="row">
                                <div class="col-md-8">
                                    <h5 style="color: black; font-weight:bold;">Total Dibayar (DP 50%)</h5>
                                </div>
                                <div class="col-md-4">
                                    <p style="color: black; font-weight:bold;" class="text-right">
                                        Rp {{ number_format($harusBayar) }}
                                    </p>
                                </div>
                            </div>

                            <p class="text-danger"><strong>Pembayaran: DP 50%</strong></p>
                        @else
                            @php
                                $harusBayar = $datapembelian->totalbeli + $datapembelian->ongkir;
                            @endphp

                            <div class="row">
                                <div class="col-md-8">
                                    <h5 style="color: black; font-weight:bold;">Total Dibayar (Lunas)</h5>
                                </div>
                                <div class="col-md-4">
                                    <p style="color: black; font-weight:bold;" class="text-right">
                                        Rp {{ number_format($harusBayar) }}
                                    </p>
                                </div>
                            </div>

                            <p class="text-success"><strong>Pembayaran: Lunas</strong></p>
                        @endif

                        <hr>
                        <p>Dengan melanjutkan ke tahapan selanjutnya, Anda telah membaca dan setuju dengan pihak Seni Relief
                            Kuningan dengan <a href="#" style="color: #ffbf0f;">Syarat & Kententuannya</a>.</p>

                        <?php if ($datapembelian->statusbeli == "Belum Bayar") { ?>
                        <a class="btn btn-lg text-white" href="{{ url('home/pembayaran/' . $datapembelian->idpembelian) }}"
                            style="background-color: #ffbf0f">Lanjutkan Pembayaran</a>
                        <?php } else { ?>
                        <a class="btn btn-lg text-white" href="{{ url('home/invoice/' . $datapembelian->idpembelian) }}"
                            style="background-color: #ffbf0f">Invoice</a>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card py-2 px-2">
                        <p>No Transaksi: <br> <span
                                style="color: #000; font-weight:bold;">{{ $datapembelian->notransaksi }}</span></p>
                    </div>
                    <div class="card mt-3 py-2 px-2">
                        <h3 style="color: black;">{{ $dp->nama }}</h3>
                        Kota Asal Pengiriman : Kabupaten Jepara
                        <img src="{{ asset('foto/' . $dp->foto) }}" height="250px" alt="">
                        <p style="color: #000;">{{ $datapembelian->alamat }}, {{ $datapembelian->kec }},
                            {{ $datapembelian->kota }}, {{ $datapembelian->provinsi }},{{ $datapembelian->kode_pos }}</p>
                        <table class="">
                            <tr>
                                <td width="150px"><strong>Nama Penerima</strong></td>
                                <td>: {{ $datapembelian->nama }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Pemesanan</td>
                                <td>: {{ tanggal(date('Y-m-d', strtotime($datapembelian->tanggalbeli))) }}</td>
                            </tr>
                            <tr>
                                <td>No Telepon</td>
                                <td>: {{ $datapembelian->telepon }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>: {{ $datapembelian->statusbeli }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
