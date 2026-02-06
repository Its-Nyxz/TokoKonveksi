@extends('admin.templates.index')

@section('page-content')
    <section class="ftco-section">
        <form action="{{ route('admin.ubahakun', $pengguna->id) }}" method="POST" id="formAkun">
            @csrf
            @method('PUT')
            <div class="container mt-4">
                <h1 style="color: black; font-weight:bold;">Akun Saya</h1>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="color:black; font-weight:bold;">Nama</label>
                            <input value="{{ $pengguna->nama }}" type="text" class="form-control" name="nama" readonly>
                        </div>

                        <div class="form-group">
                            <label style="color:black; font-weight:bold;">Email</label>
                            <input value="{{ $pengguna->email }}" type="email" class="form-control" name="email" required>
                        </div>

                        @if($pengguna->id == 2 || $pengguna->nama == 'Administrator')
                            <div class="form-group">
                                <label style="color:black; font-weight:bold;">Kata sandi (biarkan kosong jika tidak ingin diubah)</label>
                                <input type="password" class="form-control" name="password" placeholder="Masukkan kata sandi baru (opsional)">
                            </div>
                        @endif

                        <input type="hidden" name="passwordlama" value="{{ $pengguna->password }}">

                        <button type="button" class="btn" id="btnSimpan" style="background-color: #55acce; color: white;">
                            <i class="glyphicon glyphicon-saved"></i> Simpan Perubahan
                        </button>
                    </div>
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
                icon: 'question',
                title: 'Konfirmasi Perubahan',
                text: 'Apakah Anda yakin ingin menyimpan perubahan data akun?',
                showCancelButton: true,
                confirmButtonColor: '#ffbf0f',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading saat submit
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit form
                    document.getElementById('formAkun').submit();
                }
            });
        });
    </script>

    {{-- Sweet Alert untuk notifikasi dari session --}}
    @if (session()->has('swal_type'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: @json(session('swal_type')),
                    title: @json(session('swal_title')),
                    text: @json(session('swal_text')),
                    confirmButtonColor: '#ffbf0f',
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        </script>
    @endif
@endsection