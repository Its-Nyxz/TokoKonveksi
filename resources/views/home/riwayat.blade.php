@extends('home.templates.index')

@section('page-content')
    <section id="home-section" class="ftco-section">
        <div class="container mt-4">
            <h1 style="color: black; font-weight:bold;">Riwayat Transaksi</h1>
            <div class="row">
                <div class="col-md-12 ftco-animate">
                    <div class="cart-list">
                        <div class="table-responsive"> <!-- Added this div for responsiveness -->
                            <table class="table">
                                <thead>
                                    <tr class="text-center">
                                        <th style="color: black;" width="10px">No</th>
                                        <th style="color: black;" width="25%">ID Transaksi</th>
                                        <th style="color: black;" width="25%">Daftar</th>
                                        <th style="color: black;">Tanggal Order</th>
                                        <th style="color: black;">Total</th>
                                        <th style="color: black;">Metode Pembayaran</th>
                                        <th style="color: black;">Bukti Pembayaran</th>
                                        <th style="color: black;">QR Code</th>
                                        <th style="color: black;">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $nomor = 1; ?>
                                    @foreach ($databeli as $db)
                                        <tr>
                                            <td style="color: black;"><?php echo $nomor; ?></td>
                                            <td style="color: black;">{{ $db->notransaksi }}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($dataproduk[$db->idpembelianreal] as $dp)
                                                        <li style="color: black;">
                                                            {{ $dp->nama }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td style="color: black;">{!! tanggal($db->tanggalbeli) . '<br>' . date('H:i', strtotime($db->waktu)) !!}</td>
                                            <td style="color: black;">Rp {{ number_format($db->totalbeli) }}</td>
                                            <td style="color: black;">{{ $db->metodepembayaran }}</td>
                                            <td class="text-center">
                                                {{-- Bukti DP --}}
                                                <div>
                                                    <small>DP:</small><br>
                                                    @if (!empty($db->bukti_dp) && file_exists(public_path('foto/' . $db->bukti_dp)))
                                                        <img width="80" src="{{ asset('foto/' . $db->bukti_dp) }}"
                                                            alt="">
                                                    @else
                                                        <strong>-</strong>
                                                    @endif
                                                </div>

                                                <hr>

                                                {{-- Bukti Lunas --}}
                                                <div>
                                                    <small>Lunas:</small><br>
                                                    @if (!empty($db->bukti_lunas) && file_exists(public_path('foto/' . $db->bukti_lunas)))
                                                        <img width="80" src="{{ asset('foto/' . $db->bukti_lunas) }}"
                                                            alt="">
                                                    @else
                                                        <strong>-</strong>
                                                    @endif
                                                </div>
                                            </td>

                                            <td>
                                                <a href="{{ asset('qr/' . $db->qrcode) }}" target="_blank">
                                                    <img src="{{ asset('qr/' . $db->qrcode) }}" alt="qr-code"
                                                        width="100">
                                                </a>
                                            </td>

                                            </td>
                                            <td>
                                                {{-- Jika sudah bayar DP tapi belum bayar Lunas --}}
                                                @if ($db->bukti_dp && !$db->bukti_lunas && $db->statusbeli != 'Belum Bayar')
                                                    <a href="{{ url('home/pelunasan/' . $db->idpembelianreal) }}"
                                                        class="btn btn-warning text-white"
                                                        style="background-color: #ff7f00;">
                                                        Lanjutkan Pelunasan
                                                    </a>
                                                @endif

                                                {{-- Kondisi normal --}}
                                                @if ($db->statusbeli == 'Belum Bayar')
                                                    <?php
                                                    $deadline = date('Y-m-d H:i', strtotime($db->waktu . ' +1 day'));
                                                    $harideadline = date('Y-m-d', strtotime($db->waktu . ' +1 day'));
                                                    $jamdeadline = date('H:i', strtotime($db->waktu . ' +1 day'));
                                                    ?>

                                                    @if (date('Y-m-d H:i') >= $deadline)
                                                        Waktu pembayaran<br>telah habis
                                                    @else
                                                        <a href="{{ url('home/detailtransaksi/' . $db->idpembelianreal) }}"
                                                            class="btn text-white" style="background-color: #ffbf0f">
                                                            Upload Bukti<br>Pembayaran Sebelum<br>
                                                            <?= tanggal($harideadline) . ' - Jam ' . $jamdeadline ?>
                                                        </a>
                                                    @endif
                                                @elseif ($db->statusbeli == 'Sudah Upload Bukti Pembayaran' || $db->statusbeli == 'Menunggu Konfirmasi')
                                                    <a class="btn text-white" style="background-color: #ffbf0f">
                                                        Menunggu Konfirmasi Admin
                                                    </a>
                                                @elseif ($db->statusbeli == 'Pesanan Di Terima')
                                                    <a href="{{ url('home/detailtransaksi/' . $db->idpembelianreal) }}"
                                                        class="btn text-white" style="background-color: #ffbf0f">
                                                        Pesanan Di Terima
                                                    </a>
                                                @elseif ($db->statusbeli == 'Selesai')
                                                    <label class="btn btn-success">Selesai</label>
                                                @elseif ($db->statusbeli == 'Pesanan Di Tolak')
                                                    <a class="btn btn-danger text-white">Pesanan Anda Di Tolak</a>
                                                @else
                                                    <a class="btn btn-success text-white">{{ $db->statusbeli }}</a>
                                                @endif
                                            </td>


                                        </tr>
                                        <?php $nomor++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- End of table-responsive -->
                    </div>
                    <div class="text-center">
                        {{ $databeli->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
