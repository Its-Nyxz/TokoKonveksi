@extends('home.templates.index')

@section('page-content')
    <section id="home-section" class="ftco-section">
        <form method="post" enctype="multipart/form-data" action="{{ url('home/ubahakun/' . $pengguna->id) }}" id="formAkun">
            @csrf
            <div class="container mt-4">
                <h1 style="color: black; font-weight:bold;">Akun Saya</h1>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="color:black; font-weight:bold;">Nama Lengkap</label>
                            <input value="{{ $pengguna->nama }}" type="text" value="" class="form-control"
                                name="nama">
                        </div>
                        <div class="form-group">
                            <label style="color:black; font-weight:bold;">Email</label>
                            <input value="{{ $pengguna->email }}" type="email" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                            <label style="color:black; font-weight:bold;">Telepon</label>
                            <input value="{{ $pengguna->telepon }}" type="number" class="form-control" name="telepon">
                        </div>
                        <div class="form-group">
                            <label style="color:black; font-weight:bold;">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" rows="5">{{ $pengguna->alamat }}</textarea>
                            <script>
                                CKEDITOR.replace('alamat');
                            </script>
                        </div>
                        <div class="form-group">
                            <label style="color:black; font-weight:bold;">Jenis Kelamin</label>
                            <select class="form-control" name="jekel" id="">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Perempuan" {{ $pengguna->jekel == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                </option>
                                <option value="Laki-laki" {{ $pengguna->jekel == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="color:black; font-weight:bold;">Kata sandi (biarkan kosong jika tidak ingin
                                diubah)*</label>
                            <input type="text" class="form-control" name="password">
                            <input type="hidden" class="form-control" name="passwordlama"
                                value="{{ $pengguna->password }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="color:black; font-weight:bold;">Tanggal Lahir</label>
                            <input value="{{ $pengguna->tgl_lahir }}" type="date" value="" class="form-control"
                                name="tgl_lahir">
                        </div>
                        <div class="form-group">
                            <label style="color:black; font-weight:bold;">Tempat Lahir</label>
                            <input value="{{ $pengguna->tempat_lahir }}" type="text" class="form-control"
                                name="tempat_lahir">
                        </div>
                        <div class="form-group">
                            <label style="color:black; font-weight:bold;">Provinsi</label>
                            <input value="{{ $pengguna->provinsi }}" type="text" class="form-control" name="provinsi">
                        </div>
                        <div class="form-group">
                            <label style="color:black; font-weight:bold;">Kota</label>
                            <input value="{{ $pengguna->kota }}" type="text" class="form-control" name="kota">
                        </div>
                        <div class="form-group">
                            <label style="color:black; font-weight:bold;">Kecamatan</label>
                            <input value="{{ $pengguna->kec }}" type="text" class="form-control" name="kec">
                        </div>
                        <div class="form-group">
                            <label style="color:black; font-weight:bold;">Kode Pos</label>
                            <input value="{{ $pengguna->kode_pos }}" type="text" class="form-control" name="kode_pos">
                        </div>
                    </div>
                    <button type="button" class="btn ml-3" id="btnSimpan" style="background-color: #55acce">
                        <i class="glyphicon glyphicon-saved"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </section>

    {{-- Sweet Alert CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Konfirmasi sebelum submit
        document.getElementById('btnSimpan').addEventListener('click', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Perubahan',
                text: "Apakah Anda yakin ingin menyimpan perubahan data akun?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffbf0f',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formAkun').submit();
                }
            });
        });

        // Notifikasi berhasil setelah update (dari session)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                confirmButtonColor: ' #ffbf0f',
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        // Notifikasi error jika ada
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session("error") }}',
                confirmButtonColor: '  #ffbf0f'
            });
        @endif
    </script>
@endsection