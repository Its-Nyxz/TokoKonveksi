@extends('home.templates.index')

<style>
    /* Container Utama untuk Overlay */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.4);
        /* Warna hitam transparan */

        /* Efek Blur Latar Belakang */
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);

        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    /* Box Modal */
    .modal-box {
        background-color: #ffffff;
        width: 100%;
        max-width: 600px;
        /* Lebar ideal untuk modal */
        max-height: 80vh;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.3);
        animation: fade 0.5s ease-in-out;
    }

    /* Header Modal */
    .modal-header {
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f0f0f0;
    }

    .modal-header h1 {
        font-size: 1.7rem;
        font-weight: 700;
        margin: 0;
        color: #1a1a1a;
    }

    .close-icon {
        cursor: pointer;
        color: #999;
        transition: color 0.2s;
    }

    .close-icon:hover {
        color: #ff4d4d;
    }

    /* Konten / Isi Modal */
    .modal-content {
        padding: 24px;
        overflow-y: auto;
        /* Scroll jika teks terlalu panjang */
        line-height: 1.6;
        color: #444;
    }

    .modal-content h3 {
        font-size: 1rem;
        margin-bottom: 8px;
        color: #000;
    }

    .modal-content p {
        margin-bottom: 20px;
        font-size: 0.9rem;
    }

    /* Footer Modal */
    .modal-footer {
        padding: 16px 24px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: flex-end;
        background-color: #fcfcfc;
    }

    .confirm-btn {
        background-color: #ffbf0f;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }

    .confirm-btn:hover {
        background-color: #bb8d0f;
    }

    /* Styling Scrollbar (Opsional agar lebih rapi) */
    .modal-content::-webkit-scrollbar {
        width: 6px;
    }

    .modal-content::-webkit-scrollbar-thumb {
        background: #e0e0e0;
        border-radius: 10px;
    }

    @keyframes fade {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
</style>

@section('page-content')
    <section id="home-section" class="ftco-section">
        <div class="container mt-4">
            <div>
                <div class="card text-center" style="background-color: #ffbf0f;">
                    <p style="color: white;" class="m-auto py-3">
                        {{-- <img src="{{ asset('foto/1a.png') }}" href="{{ url('home') }}" width="20"> Detail Informasi
                        <img src="{{ asset('foto/line.png') }}" href="{{ url('home') }}" width="20">
                        <img src="{{ asset('foto/2b.png') }}" href="{{ url('home') }}" width="20"> Pembayaran
                        <img src="{{ asset('foto/line.png') }}" href="{{ url('home') }}" width="20">
                        <img src="{{ asset('foto/3b.png') }}" href="{{ url('home') }}" width="20"> Konfirmasi --}}
                        Checkout
                    </p>
                </div>
            </div>
            <form method="post" action="{{ url('home/docheckout') }}">
                <?php $totalbelanja = 0; ?>
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="mt-5">
                            <h1 style="color: black; font-weight:bold;">Pesanan Anda</h1>
                        </div>
                        <div class="card py-2 px-2 text-justify">
                            Seluruh pesanan anda yang tercantum adalah harga final tambah biaya tambahan
                            lainnya dan dijamin harga terbaik.
                        </div>
                        <div class="card py-2 px-2 text-justify mt-5">
                            <h3 style="color: black;">Data Kontak Pesan</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Pelanggan</label>
                                        <input type="text" value="{{ $pengguna->nama }}" name="nama" required
                                            class="form-control" id="inputNama" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat Email</label>
                                        <input type="text" value="{{ $pengguna->email }}" name="email" required
                                            class="form-control" id="inputEmail" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No. Telepon</label>
                                        <input type="text" value="{{ $pengguna->telepon }}" name="telepon" required
                                            class="form-control" id="inputTelepon" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat Lengkap</label>
                                        <textarea class="form-control" name="alamat" placeholder="Masukkan Alamat" required id="inputAlamat" readonly>{{ $pengguna->alamat }}</textarea>
                                    </div>
                                </div>

                            </div>
                            <div>
                                <div class="form-group">
                                    <label>Catatan untuk Penjual (opsional)</label>
                                    <textarea class="form-control" name="catatan_pembeli" placeholder="Contoh: Pesan Ukuran XL & Varian Warna Biru"
                                        id="inputCatatan" readonly>{{ old('catatan_pembeli') }}</textarea>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="button" id="btnEdit" class="btn btn-sm text-white"
                                    style="background-color: #ffbf0f;">Edit</button>
                                <button type="button" id="btnSimpan" class="btn btn-sm text-white"
                                    style="background-color: #ffbf0f; display: none;">Simpan</button>
                                <button type="button" id="btnBatal" class="btn btn-sm text-white"
                                    style="background-color: #d33; display: none;">Batal</button>
                            </div>
                        </div>
                        <div class="card py-2 px-2 text-justify mt-5">
                            <h3 style="color: black;">Kebijakan Pemesanan</h3>
                            Dengan melanjutkan ke tahapan selanjutnya, Anda telah membaca dan setuju dengan pihak Seni
                            Relief Kuningan dengan <a href="#" onclick="buttonModal()" style="color: #ffbf0f;">Syarat
                                & Kententuannya</a>.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mt-5 py-2 px-2">
                            @foreach (session('keranjang') as $idproduk => $item)
                                @php
                                    $produk = DB::table('produk')->where('idproduk', $idproduk)->first();
                                    $totalharga = $produk->harga * $item['jumlah'];
                                @endphp
                                <h3 style="color: black;">{{ $produk->nama }}</h3>
                                Kota Asal Pengiriman : Kabupaten Wonogiri
                                <img src="{{ asset('foto/' . $produk->foto) }}" height="250px" alt="">
                            @break
                        @endforeach
                        {{-- metode pembayaran --}}

                        <p style="color: #ffbf0f; font-weight:600">Metode Pembayaran</p>
                        <div class="form-group">
                            <label>Pilih Metode Pembayaran</label>
                            <select id="metode" name="metodepembayaran" class="form-control" required>
                                <option value="">Pilih Metode Pembayaran</option>
                                <option value="Transfer">Transfer Bank</option>
                                <option value="COD">COD (Cash On Delivery)</option>
                                <!-- Tambah metode lainnya sesuai kebutuhan -->
                            </select>
                        </div>

                        <p style="color: #ffbf0f; font-weight:600"><img src="{{ asset('foto/location.png') }}"
                                alt=""> Input Lokasi Pengiriman Anda</p>
                        <div class="form-group">
                            <label for="lokasi">Nama Lokasi Tujuan</label>
                            <div class="input-group">
                                <input type="text" id="lokasi" class="form-control"
                                    placeholder="Contoh: Purwokerto">
                                <div class="input-group-append">
                                    <button type="button" id="btnCariLokasi" class="btn btn-success">Cari</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="destination_id">Pilih Lokasi Tujuan</label>
                            <select name="destination_id" id="destination_id" class="form-control" required>
                                <option value="">Pilih Lokasi</option>
                            </select>
                        </div>

                        <div class="pengiriman">
                            <div class="form-group">
                                <label>Ekspedisi</label>
                                <select id="courier" name="courier" class="form-control">
                                    <option value="">Pilih Ekspedisi</option>
                                    <option value="jne">JNE</option>
                                    <option value="pos">POS Indonesia</option>
                                    <option value="tiki">TIKI</option>
                                    <option value="jnt">J&T Express</option>
                                    <option value="sicepat">SiCepat</option>
                                    <option value="anteraja">AnterAja</option>
                                    <!-- Tambah ekspedisi lainnya sesuai kebutuhan -->
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Jenis Pengiriman</label>
                                <select id="service" name="service" class="form-control">
                                    <option value="">Pilih Jenis Pengiriman</option>
                                </select>
                                <small id="etd-info" class="text-muted"></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Ongkir</label>
                            <input type="text" class="form-control" name="ongkir" id="ongkir" readonly
                                required>
                        </div>

                    </div>
                    <div class="card py-2 px-2 text-justify mt-5">
                        <!-- Payment Method Selection -->
                        <div class="form-group mt-3">
                            <label style="color: black;"><strong>Pilih Tipe Pembayaran</strong></label><br>
                            <div>
                                <input type="radio" id="dp" name="tipe" value="DP" required>
                                <label for="dp">DP 50%</label>
                            </div>
                            <div>
                                <input type="radio" id="lunas" name="tipe" value="Lunas" required>
                                <label for="lunas">Lunas</label>
                            </div>
                        </div>

                        <h3 style="color: black; font-weight:bold;">Rincian Harga</h3>
                        @if (!empty(session('keranjang')))
                            @foreach (session('keranjang') as $idproduk => $item)
                                @php
                                    $produk = DB::table('produk')->where('idproduk', $idproduk)->first();
                                    $totalharga = $produk->harga * $item['jumlah'];
                                @endphp
                                <div class="row">
                                    <div class="col-md-6">
                                        <p style="color: black;">{{ $produk->nama }} ({{ $item['jumlah'] }} x)</p>
                                        <p style="color: black;">Rp {{ number_format($produk->harga) }},-</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p style="color: black;font-weight: bold;" class="text-right">Rp
                                            {{ number_format($totalharga) }},-</p>
                                    </div>
                                </div>
                                <?php $totalbelanja += $totalharga; ?>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">Keranjang Kosong</td>
                            </tr>
                        @endif
                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h5 style="color: black; font-weight:bold;">Total</h5>
                            </div>
                            <div class="col-md-6">
                                <p style="color: black; font-weight:bold;" id="totalHarga" class="text-right">Rp
                                    {{ number_format($totalbelanja) }} <br> <span
                                        style="color: red; font-weight:400;">NON REFUNDABLE</span></p>
                            </div>
                        </div>
                        <hr>
                        <p>Dengan melanjutkan ke tahapan selanjutnya, Anda telah membaca dan setuju dengan pihak Seni
                            Relief Kuningan dengan <a href="#" onclick="buttonModal()"
                                idstyle="color: #ffbf0f;">Syarat &
                                Kententuannya</a>.</p>

                        <input type="hidden" id="total_belanja" name="total_belanja" value="{{ $totalbelanja }}">
                        <button class="btn btn-lg text-white" style="background-color: #ffbf0f"
                            name="checkout">Lanjutkan Pembayaran</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div id="modalContainer" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h1>Syarat & Ketentuan</h1>
                <i class="fa-solid fa-x close-icon"></i>
            </div>

            <div class="modal-content">
                <section>
                    <h3>Pemesanan</h3>
                    <p>Pemesanan dilakukan melalui website, marketplace, atau kontak resmi kami. Data pesanan (jenis
                        produk, jumlah, ukuran, desain) wajib diisi dengan benar.</p>
                </section>

                <section>
                    <h3>Harga & Pembayaran</h3>
                    <p>Harga disesuaikan dengan jumlah, bahan, dan tingkat kesulitan desain. Pembayaran DP / pelunasan
                        dilakukan sesuai kesepakatan.</p>
                </section>

                <section>
                    <h3>Produksi & Custom Order</h3>
                    <p>Waktu produksi menyesuaikan jumlah dan tingkat kesulitan. Produk bersifat custom, tidak dapat
                        dibatalkan atau direfund setelah produksi berjalan.</p>
                </section>

                <section>
                    <h3>Komplain</h3>
                    <p>Komplain diterima maksimal 2×24 jam setelah barang diterima dengan bukti foto/video unboxing.</p>
                </section>
            </div>

            <div class="modal-footer">
                <button onclick="buttonModal()" class="confirm-btn">Saya Mengerti</button>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    const modalContainer = document.getElementById('modalContainer');

    function buttonModal() {
        if (modalContainer.style.display === 'flex') {
            modalContainer.style.display = 'none';
        } else {
            modalContainer.style.display = 'flex';
        }
    }

    const totalBelanja = {{ $totalbelanja ?? 0 }};

    // Simpan nilai awal untuk fitur batal
    let originalValues = {
        nama: $('#inputNama').val(),
        email: $('#inputEmail').val(),
        telepon: $('#inputTelepon').val(),
        alamat: $('#inputAlamat').val(),
        catatan: $('#inputCatatan').val()
    };

    // Tombol Edit
    $('#btnEdit').click(function() {
        // Simpan nilai awal sebelum edit
        originalValues = {
            nama: $('#inputNama').val(),
            email: $('#inputEmail').val(),
            telepon: $('#inputTelepon').val(),
            alamat: $('#inputAlamat').val(),
            catatan: $('#inputCatatan').val()
        };

        // Hilangkan readonly
        $('#inputNama, #inputEmail, #inputTelepon, #inputAlamat, #inputCatatan').prop('readonly', false);

        // Toggle tombol
        $('#btnEdit').hide();
        $('#btnSimpan, #btnBatal').show();
    });

    // Tombol Simpan
    $('#btnSimpan').click(function() {
        // Set readonly kembali
        $('#inputNama, #inputEmail, #inputTelepon, #inputAlamat, #inputCatatan').prop('readonly', true);

        // Toggle tombol
        $('#btnSimpan, #btnBatal').hide();
        $('#btnEdit').show();

        // Tampilkan sweet alert
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Berhasil menyimpan perubahan',
            confirmButtonColor: '#ffbf0f'
        });
    });

    // Tombol Batal
    $('#btnBatal').click(function() {
        // Kembalikan nilai ke nilai awal
        $('#inputNama').val(originalValues.nama);
        $('#inputEmail').val(originalValues.email);
        $('#inputTelepon').val(originalValues.telepon);
        $('#inputAlamat').val(originalValues.alamat);
        $('#inputCatatan').val(originalValues.catatan);

        // Set readonly kembali
        $('#inputNama, #inputEmail, #inputTelepon, #inputAlamat, #inputCatatan').prop('readonly', true);

        // Toggle tombol
        $('#btnSimpan, #btnBatal').hide();
        $('#btnEdit').show();
    });

    $('#metode').on('change', function() {
        const metode = $(this).val();
        if (metode === 'COD') {
            $('.pengiriman').hide();
            $('input[name="ongkir"]').val(0);
            updateTotal(0);
        } else {
            $('.pengiriman').show();
            $('input[name="ongkir"]').val('');
            updateTotal(0);
        }
    });

    // Cari lokasi berdasarkan keyword
    $('#btnCariLokasi').click(function() {
        const keyword = $('#lokasi').val();

        $.ajax({
            url: '{{ url('home/getlokasi') }}',
            method: 'GET',
            data: {
                keyword: keyword
            },
            success: function(res) {
                $('#destination_id').empty().append('<option value="">Pilih Lokasi</option>');
                res.forEach(function(lokasi) {
                    $('#destination_id').append(
                        `<option value="${lokasi.label}" data-id="${lokasi.id}">${lokasi.label}</option>`
                    );
                });

                // console.log(res);
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal mencari lokasi',
                    confirmButtonColor: '#ffbf0f'
                });
            }
        });
    });

    // Ambil layanan pengiriman saat kurir & tujuan dipilih
    $('#courier, #destination_id').change(function() {
        const destinationId = $('#destination_id option:selected').data('id');

        const courier = $('#courier').val();

        if (destinationId && courier) {
            $.ajax({
                url: '{{ url('home/getservices') }}',
                method: 'GET',
                data: {
                    destination_id: destinationId,
                    courier: courier
                },
                success: function(data) {
                    $('#service').empty().append(
                        '<option value="">Pilih Jenis Pengiriman</option>');
                    data.forEach(function(service) {
                        if (service.code === courier) {
                            $('#service').append(
                                `<option
                                    value="${service.cost}"
                                    data-service="${service.service}"
                                    data-description="${service.description}"
                                    data-etd="${service.etd}"
                                    data-code="${service.code}"
                                >
                                    ${service.service} - Rp ${service.cost.toLocaleString()} (${service.etd})
                                </option>`
                            );
                        }
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal mengambil layanan pengiriman',
                        confirmButtonColor: '#ffbf0f'
                    });
                }
            });
        }
    });

    // Ketika jenis pengiriman dipilih
    $('#service').change(function() {
        const ongkir = parseInt($(this).val());
        const serviceName = $(this).find(':selected').data('service');
        const etd = $(this).find(':selected').data('etd');

        $('input[name="ongkir"]').val(ongkir);
        $('#etd-info').text(etd ? `Estimasi pengiriman: ${etd}` : '');
        updateTotal(ongkir);
    });

    function updateTotal(ongkir) {
        const total = totalBelanja + ongkir;
        $('#totalHarga').html('Rp ' + total.toLocaleString() +
            ' <br><span style="color:red; font-weight:400;">NON REFUNDABLE</span>');
    }
</script>
@endsection