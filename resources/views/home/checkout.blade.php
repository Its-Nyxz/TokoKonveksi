@extends('home.templates.index')

<style>
    .product-row-hover:hover {
        background-color: #f8f9fa !important;
        border-radius: 8px;
        transition: background-color 0.2s ease;
    }

    .product-sizes-container::-webkit-scrollbar {
        width: 6px;
    }

    .product-sizes-container::-webkit-scrollbar-thumb {
        background: #e0e0e0;
        border-radius: 10px;
    }

    .product-sizes-container::-webkit-scrollbar-thumb:hover {
        background: #cccccc;
    }

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
                        Pesan Produk
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
                                        <input type="text" value="{{ old('nama', $pengguna->nama) }}" name="nama" required
                                            class="form-control" id="inputNama" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat Email</label>
                                        <input type="text" value="{{ old('email', $pengguna->email) }}" name="email" required
                                            class="form-control" id="inputEmail" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No. Telepon</label>
                                        <input type="text" value="{{ old('telepon', $pengguna->telepon) }}" name="telepon" required
                                            class="form-control" id="inputTelepon" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat Lengkap</label>
                                        <textarea class="form-control" name="alamat" placeholder="Masukkan Alamat" required id="inputAlamat" readonly>{{ old('alamat', $pengguna->alamat) }}</textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-md-7">
                                    <label><strong>Rincian Ukuran Per Produk (M - XXL)</strong></label>
                                    <hr class="mt-1 mb-3">
                                    <div class="product-sizes-container" style="max-height: 350px; overflow-y: auto; padding-right: 5px; margin-bottom: 15px;">
                                        @foreach (session('keranjang') as $idproduk => $item)
                                            @php
                                                $produk = DB::table('produk')->where('idproduk', $idproduk)->first();
                                                $firstFoto = 'noimage.png';
                                                if ($produk && !empty($produk->foto)) {
                                                    $firstFoto = explode(',', $produk->foto)[0];
                                                }
                                            @endphp
                                            <div class="product-size-section mb-3 p-3 bg-white border rounded product-row-hover" style="cursor: pointer;" data-id="{{ $idproduk }}" data-qty="{{ $item['jumlah'] }}" data-nama="{{ $produk->nama }}" data-foto="{{ asset('foto/' . $firstFoto) }}">
                                                <h6 style="color: black; font-weight: bold; margin-bottom: 8px;">{{ $produk->nama }} (Kuantitas: {{ $item['jumlah'] }})</h6>
                                                <div class="row">
                                                    <div class="col-3 px-1">
                                                        <label class="mb-1 text-dark" style="font-size: 0.8rem;">Size M</label>
                                                        <input type="number" name="sizes[{{ $idproduk }}][m]" class="form-control size-input size-m p-1 text-center" value="{{ old('sizes.' . $idproduk . '.m', 0) }}" min="0" readonly style="height: 30px; font-size: 0.85rem;">
                                                    </div>
                                                    <div class="col-3 px-1">
                                                        <label class="mb-1 text-dark" style="font-size: 0.8rem;">Size L</label>
                                                        <input type="number" name="sizes[{{ $idproduk }}][l]" class="form-control size-input size-l p-1 text-center" value="{{ old('sizes.' . $idproduk . '.l', 0) }}" min="0" readonly style="height: 30px; font-size: 0.85rem;">
                                                    </div>
                                                    <div class="col-3 px-1">
                                                        <label class="mb-1 text-dark" style="font-size: 0.8rem;">Size XL</label>
                                                        <input type="number" name="sizes[{{ $idproduk }}][xl]" class="form-control size-input size-xl p-1 text-center" value="{{ old('sizes.' . $idproduk . '.xl', 0) }}" min="0" readonly style="height: 30px; font-size: 0.85rem;">
                                                    </div>
                                                    <div class="col-3 px-1">
                                                        <label class="mb-1 text-dark" style="font-size: 0.8rem;">Size XXL</label>
                                                        <input type="number" name="sizes[{{ $idproduk }}][xxl]" class="form-control size-input size-xxl p-1 text-center" value="{{ old('sizes.' . $idproduk . '.xxl', 0) }}" min="0" readonly style="height: 30px; font-size: 0.85rem;">
                                                    </div>
                                                </div>
                                                <small class="product-size-warning text-danger font-weight-bold mt-1" style="display: none;"></small>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Catatan untuk Penjual (opsional)</label>
                                        <textarea class="form-control" name="catatan_pembeli" placeholder="Contoh: Pesan Varian Warna Biru"
                                            id="inputCatatan" readonly style="height: 200px;">{{ old('catatan_pembeli') }}</textarea>
                                    </div>
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
                            Dengan melanjutkan ke tahapan selanjutnya, Anda telah membaca dan setuju dengan pihak Oldshine
                            Konveksi dengan <a href="#" onclick="buttonModal()" style="color: #ffbf0f;">Syarat
                                & Kententuannya</a>.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mt-5 py-2 px-2">
                            @php
                                $firstCartItem = null;
                                if (session('keranjang') && count(session('keranjang')) > 0) {
                                    $firstCartItemId = array_key_first(session('keranjang'));
                                    $firstCartItem = DB::table('produk')->where('idproduk', $firstCartItemId)->first();
                                }
                                $firstFoto = 'noimage.png';
                                if ($firstCartItem && !empty($firstCartItem->foto)) {
                                    $firstFoto = explode(',', $firstCartItem->foto)[0];
                                }
                            @endphp

                            <h3 style="color: black;" id="previewProductTitle">{{ $firstCartItem ? $firstCartItem->nama : 'Detail Pesanan' }}</h3>
                            
                            <div id="previewProductContainer">
                                @if($firstCartItem)
                                    <img id="previewProductImage" src="{{ asset('foto/' . $firstFoto) }}" height="250px" alt="" style="object-fit: cover; border-radius: 8px; width: 100%;">
                                @else
                                    <div class="text-center py-5 bg-light" id="previewProductPlaceholder">
                                        <span class="text-muted">Foto produk tidak tersedia</span>
                                    </div>
                                @endif
                            </div>

                            <span class="text-muted mt-2 d-block">Kota Asal Pengiriman : Kabupaten Wonogiri</span>
                        {{-- metode pembayaran --}}


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

                        <p style="color: #ffbf0f; font-weight:600">Metode Pengiriman</p>
                        <div class="form-group">
                            <label>Pilih Metode Pengiriman</label>
                            <select name="metodepembayaran" id="metodepembayaran" class="form-control" required
                                disabled>
                                <option value="">Pilih lokasi terlebih dahulu</option>
                                <option value="Transfer">Dengan Kurir</option>
                                <option value="COD" id="optionTanpaKurir">Tanpa Kurir</option>
                            </select>
                            <small id="infoMetodePengiriman" class="text-danger"></small>
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
                                    $firstFoto = 'noimage.png';
                                    if ($produk && !empty($produk->foto)) {
                                        $firstFoto = explode(',', $produk->foto)[0];
                                    }
                                @endphp
                                <div class="row product-row-hover" style="cursor: pointer; padding: 5px 0; margin-bottom: 5px;" data-foto="{{ asset('foto/' . $firstFoto) }}" data-nama="{{ $produk->nama }}">
                                    <div class="col-md-6">
                                        <p style="color: black; margin-bottom: 0;">{{ $produk->nama }} ({{ $item['jumlah'] }} x)</p>
                                        <p style="color: black; margin-bottom: 0;">Rp {{ number_format($produk->harga) }},-</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p style="color: black;font-weight: bold; margin-bottom: 0;" class="text-right">Rp
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
                        <p>Dengan melanjutkan ke tahapan selanjutnya, Anda telah membaca dan setuju dengan pihak
                            Oldshine Konveksi dengan <a href="#" onclick="buttonModal()"
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
                <i class="fa-solid fa-xmark close-icon" onclick="buttonModal()"></i>
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

                <section>
                    <h3>Pesanan Ditolak</h3>
                    <p>Pesanan akan ditolak oleh admin apabila dalam waktu 1×24 jam setelah pemesanan tidak terdapat
                        bukti pembayaran yang valid. Pastikan bukti pembayaran telah diunggah atau dikirim sesuai
                        ketentuan agar pesanan dapat diproses.</p>
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
    @php
        $totalJumlahGlobal = 0;
        if (session('keranjang')) {
            foreach (session('keranjang') as $item) {
                $totalJumlahGlobal += $item['jumlah'];
            }
        }
    @endphp
    const totalJumlahGlobal = {{ $totalJumlahGlobal }};
    const modalContainer = document.getElementById('modalContainer');
    const totalBelanja = {{ $totalbelanja ?? 0 }};

    function buttonModal() {
        if (modalContainer.style.display === 'flex') {
            modalContainer.style.display = 'none';
        } else {
            modalContainer.style.display = 'flex';
        }
    }

    function cekLokasiWonogiri() {
        const lokasiSelect = document.getElementById('destination_id');
        const metodeSelect = document.getElementById('metodepembayaran');
        const optionTanpaKurir = document.getElementById('optionTanpaKurir');
        const infoMetode = document.getElementById('infoMetodePengiriman');

        if (!lokasiSelect || !metodeSelect || !optionTanpaKurir) {
            return;
        }

        const selectedOption = lokasiSelect.options[lokasiSelect.selectedIndex];
        const teksLokasi = selectedOption ? selectedOption.text.toLowerCase() : '';

        if (!lokasiSelect.value) {
            metodeSelect.disabled = true;
            metodeSelect.value = '';
            metodeSelect.options[0].text = 'Pilih lokasi terlebih dahulu';
            optionTanpaKurir.disabled = true;

            if (infoMetode) {
                infoMetode.textContent = '';
            }

            $('.pengiriman').show();
            $('#courier').val('');
            $('#service').empty().append('<option value="">Pilih Jenis Pengiriman</option>');
            $('#etd-info').text('');
            $('input[name="ongkir"]').val('');
            updateTotal(0);

            return;
        }

        metodeSelect.disabled = false;
        metodeSelect.options[0].text = 'Pilih Metode Pengiriman';

        if (teksLokasi.includes('wonogiri')) {
            optionTanpaKurir.disabled = false;

            if (infoMetode) {
                infoMetode.textContent = 'Wilayah Wonogiri dapat memilih Tanpa Kurir.';
            }
        } else {
            optionTanpaKurir.disabled = true;

            if (metodeSelect.value === 'COD') {
                metodeSelect.value = '';
            }

            if (infoMetode) {
                infoMetode.textContent = 'Tanpa Kurir hanya tersedia untuk wilayah Wonogiri.';
            }

            $('.pengiriman').show();
            $('input[name="ongkir"]').val('');
            updateTotal(0);
        }
    }

    function aturMetodePengiriman() {
        const metode = $('#metodepembayaran').val();

        if (metode === 'COD') {
            $('.pengiriman').hide();
            $('#courier').val('');
            $('#service').empty().append('<option value="">Pilih Jenis Pengiriman</option>');
            $('#etd-info').text('');
            $('input[name="ongkir"]').val(0);
            updateTotal(0);
        } else if (metode === 'Transfer') {
            $('.pengiriman').show();
            $('input[name="ongkir"]').val('');
            updateTotal(0);
        } else {
            $('.pengiriman').show();
            $('input[name="ongkir"]').val('');
            updateTotal(0);
        }
    }

    // Simpan nilai awal untuk fitur batal
    let originalValues = {
        nama: $('#inputNama').val(),
        email: $('#inputEmail').val(),
        telepon: $('#inputTelepon').val(),
        alamat: $('#inputAlamat').val(),
        catatan: $('#inputCatatan').val()
    };
    let originalSizes = {};

    function validateSizes() {
        let allValid = true;
        $('.product-size-section').each(function() {
            const $section = $(this);
            const targetQty = parseInt($section.data('qty')) || 0;
            const productName = $section.data('nama');
            
            let sectionTotal = 0;
            $section.find('.size-input').each(function() {
                sectionTotal += parseInt($(this).val()) || 0;
            });
            
            const $warning = $section.find('.product-size-warning');
            if (sectionTotal !== targetQty) {
                $warning.text(`Total rincian ukuran (${sectionTotal}) harus sama dengan kuantitas pesanan (${targetQty}).`).show();
                allValid = false;
            } else {
                $warning.hide();
            }
        });
        return allValid;
    }

    $(document).on('input change', '.size-input', validateSizes);

    $('#btnEdit').click(function() {
        originalValues = {
            nama: $('#inputNama').val(),
            email: $('#inputEmail').val(),
            telepon: $('#inputTelepon').val(),
            alamat: $('#inputAlamat').val(),
            catatan: $('#inputCatatan').val()
        };
        originalSizes = {};
        $('.size-input').each(function() {
            originalSizes[$(this).attr('name')] = $(this).val();
        });

        $('#inputNama, #inputEmail, #inputTelepon, #inputAlamat, #inputCatatan, .size-input').prop('readonly', false);

        $('#btnEdit').hide();
        $('#btnSimpan, #btnBatal').show();
    });

    $('#btnSimpan').click(function() {
        if (!validateSizes()) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan',
                text: 'Ada rincian ukuran produk yang belum sesuai dengan kuantitas pesanan.',
                confirmButtonColor: '#ffbf0f'
            });
            return false;
        }

        $('#inputNama, #inputEmail, #inputTelepon, #inputAlamat, #inputCatatan, .size-input').prop('readonly', true);

        $('#btnSimpan, #btnBatal').hide();
        $('#btnEdit').show();

        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Berhasil menyimpan perubahan',
            confirmButtonColor: '#ffbf0f'
        });
    });

    $('#btnBatal').click(function() {
        $('#inputNama').val(originalValues.nama);
        $('#inputEmail').val(originalValues.email);
        $('#inputTelepon').val(originalValues.telepon);
        $('#inputAlamat').val(originalValues.alamat);
        $('#inputCatatan').val(originalValues.catatan);
        
        for (let name in originalSizes) {
            $(`input[name="${name}"]`).val(originalSizes[name]);
        }

        $('#inputNama, #inputEmail, #inputTelepon, #inputAlamat, #inputCatatan, .size-input').prop('readonly', true);

        $('#btnSimpan, #btnBatal').hide();
        $('#btnEdit').show();
        validateSizes();
    });

    $('#metodepembayaran').on('change', function() {
        cekLokasiWonogiri();
        aturMetodePengiriman();
    });

    $('#destination_id').on('change', function() {
        cekLokasiWonogiri();
        aturMetodePengiriman();
    });

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

                cekLokasiWonogiri();
                aturMetodePengiriman();
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

    $('#courier, #destination_id').change(function() {
        const destinationId = $('#destination_id option:selected').data('id');
        const courier = $('#courier').val();

        cekLokasiWonogiri();

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

    $('#service').change(function() {
        const ongkir = parseInt($(this).val()) || 0;
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

    $(document).ready(function() {
        cekLokasiWonogiri();
        aturMetodePengiriman();

        $('form[action*="docheckout"]').on('submit', function(e) {
            const alamat = $('#inputAlamat').val().trim();
            if (!alamat) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Alamat Belum Lengkap',
                    text: 'Alamat pengiriman wajib diisi. Silakan klik tombol "Edit" di bagian Data Kontak Pesan untuk melengkapi alamat Anda.',
                    confirmButtonColor: '#ffbf0f'
                });
                return false;
            }

            const destination_id = $('#destination_id').val();
            if (destination_id) {
                const addressLower = alamat.toLowerCase();
                const locationParts = destination_id.split(',');
                const missingParts = [];
                
                locationParts.forEach(function(part) {
                    const trimmedPart = part.trim();
                    if (trimmedPart && addressLower.indexOf(trimmedPart.toLowerCase()) === -1) {
                        missingParts.push(trimmedPart);
                    }
                });
                
                if (missingParts.length > 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Alamat Belum Lengkap',
                        text: 'Alamat pengiriman wajib mencantumkan lokasi tujuan: ' + missingParts.join(', ') + '. Silakan klik tombol "Edit" di bagian Data Kontak Pesan untuk melengkapi alamat Anda.',
                        confirmButtonColor: '#ffbf0f'
                    });
                    return false;
                }
            }

            if (!validateSizes()) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Pemesanan Gagal',
                    text: 'Jumlah rincian ukuran produk belum sesuai dengan kuantitas pesanan. Silakan periksa kembali rincian ukuran masing-masing produk.',
                    confirmButtonColor: '#ffbf0f'
                });
                return false;
            }
        });

        // Hover over products to change the preview image/title
        $(document).on('mouseenter', '.product-row-hover', function() {
            const foto = $(this).data('foto');
            const nama = $(this).data('nama');
            $('#previewProductTitle').text(nama);
            if ($('#previewProductImage').length) {
                $('#previewProductImage').attr('src', foto);
            } else {
                $('#previewProductContainer').html(`<img id="previewProductImage" src="${foto}" height="250px" alt="" style="object-fit: cover; border-radius: 8px; width: 100%;">`);
            }
        });
    });
</script>
@endsection
