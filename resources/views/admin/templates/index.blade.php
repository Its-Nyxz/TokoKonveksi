{{-- @if (!session('admin'))
    <script>
        alert('Anda Harus Login');
        location = '{{ url('home/login') }}';
    </script>
@endif --}}
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Oldshine Konveksi - {{ session('admin')->level }}</title>
    <link href="{{ asset('assets/admin/css/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('assets/admin/css/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet"
        href="{{ asset('assets/admin/assets/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') }}">
    <link href="{{ asset('assets/admin/css/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet"
        type="text/css">
    <script src="{{ asset('assets/admin/assets/ckeditor/ckeditor.js') }}"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('foto/logo.jpeg') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .btn-secondary {
            background-color: #ffbf0f;
            border: none;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #a77c06;
        }

        .btn-secondary:active,
        .btn-secondary:focus {
            background-color: #a77c06;
            outline: none;
            /* Menghilangkan outline saat fokus */
            box-shadow: none;
            /* Menghilangkan box-shadow default */
        }

        .bg-coklat {
            background-color: #ffbf0f;
        }

        .dropdown-menu .dropdown-item {
            color: #000;
            /* Warna teks default item */
        }

        .dropdown-menu .dropdown-item:hover,
        .dropdown-menu .dropdown-item:active {
            background-color: #a77c06;
            /* Warna latar belakang saat hover atau aktif */
            color: #fff;
            border: 1px solid #ffbf0f !important;
            /* Warna teks saat hover atau aktif */
        }

        .alerts-header {
            background-color: #ffbf0f !important;
            /* Warna Coklat */
            color: white !important;
            /* Teks Putih jika diinginkan */
            border: 1px solid #ffbf0f !important;
        }
    </style>

</head>

<body id="page-top">

    <div id="wrapper">
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #222D32;">
            <a class="sidebar-brand d-flex align-items-center justify-content-center text-white"
                style="background-color: #a77c06" href="{{ url('admin') }}">
                <div class="sidebar-brand-text mx-3">Oldshine Konveksi</sup></div>
            </a>
            <hr class="sidebar-divider">

            <!-- Profile Section -->
            <div class="sidebar-profile d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center flex-grow-1">
                    <img class="img-profile rounded-circle mr-2" src="{{ asset('foto/avatar.png') }}" alt="Avatar"
                        width="80">
                    <div>
                        <span class="text-white">{{ session('admin')->nama }}</span>
                        <br>
                        <span class="badge badge-success">Online</span>
                    </div>
                </div>
            </div>
            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link text-white" href="{{ url('admin') }}">
                    <i class="fas fa-fw fa-book text-white"></i>
                    <span>Dashboard</span></a>
            </li>

            @if (session('admin')->level == 'Admin')
                <hr class="sidebar-divider">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('admin/kategori') }}">
                        <i class="fas fa-fw fa-list text-white"></i>
                        <span>Kategori</span></a>
                </li>
                <hr class="sidebar-divider">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('admin/produk') }}">
                        <i class="fas fa-fw fa-pen text-white"></i>
                        <span>Produk</span></a>
                </li>
                <hr class="sidebar-divider">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('admin/pembelian') }}">
                        <i class="fas fa-fw fa-home text-white"></i>
                        <span>Transaksi</span></a>
                </li>
                <hr class="sidebar-divider">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('admin/laporan') }}">
                        <i class="fas fa-fw fa-home text-white"></i>
                        <span>Laporan</span></a>
                </li>
                <hr class="sidebar-divider">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('admin/pengguna') }}">
                        <i class="fas fa-fw fa-users text-white"></i>
                        <span>Data Member</span></a>
                </li>
                {{-- <hr class="sidebar-divider">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('admin/timproduksi') }}">
                        <i class="fas fa-fw fa-users text-white"></i>
                        <span>Data Tim Produksi</span></a>
                </li> --}}
            @endif

            @if (session('admin')->level == 'Owner')
                <hr class="sidebar-divider">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('admin/kategori') }}">
                        <i class="fas fa-fw fa-list text-white"></i>
                        <span>Kategori</span></a>
                </li>
                <hr class="sidebar-divider">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('admin/produk') }}">
                        <i class="fas fa-fw fa-pen text-white"></i>
                        <span>Produk</span></a>
                </li>
                <hr class="sidebar-divider">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('admin/laporan') }}">
                        <i class="fas fa-fw fa-home text-white"></i>
                        <span>Laporan</span></a>
                </li>
            @endif
            @if (session('admin')->level == 'Tim Produksi')
                <hr class="sidebar-divider">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('admin/kategori') }}">
                        <i class="fas fa-fw fa-list text-white"></i>
                        <span>Kategori</span></a>
                </li>
                <hr class="sidebar-divider">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('admin/produk') }}">
                        <i class="fas fa-fw fa-pen text-white"></i>
                        <span>Produk</span></a>
                </li>
                <hr class="sidebar-divider">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('admin/pembelian') }}">
                        <i class="fas fa-fw fa-home text-white"></i>
                        <span>Transaksi</span></a>
                </li>
            @endif
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow"
                    style="background-color: #ffbf0f">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">

                        <!-- User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="{{ asset('foto/avatar.png') }}">
                                <span
                                    class="mr-2 d-none d-lg-inline text-white small">{{ session('admin')->nama }}</span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href={{ url('admin/akun') }}> <i
                                        class="fa-solid fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Profil
                                    Akun</a>
                                <a class="dropdown-item" href="#" id="logoutBtn">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">
                    <div id="page-inner">
                        {{-- @if (Session::has('alert'))
                            <div class="alert alert-primary">
                                {{ Session::get('alert') }}
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif --}}
                        @yield('page-content')
                    </div>
                </div>
            </div>
            <script src="{{ asset('assets/admin/assets/js/jquery-1.10.2.js') }}"></script>
            <script src="{{ asset('assets/admin/assets/js/bootstrap.min.js') }}"></script>
            <script src="{{ asset('assets/admin/assets/js/jquery.metisMenu.js') }}"></script>
            <script src="{{ asset('assets/admin/assets/js/morris/raphael-2.1.0.min.js') }}"></script>
            <script src="{{ asset('assets/admin/assets/js/morris/morris.js') }}"></script>
            <script src="{{ asset('assets/admin/css/js/sb-admin-2.min.js') }}"></script>
            <script src="{{ asset('assets/admin/assets/js/jquery.min.js') }}"></script>
            <script src="{{ asset('assets/admin/assets/js/bootstrap.bundle.min.js') }}"></script>
            <script src="{{ asset('assets/admin/assets/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
            <script src="{{ asset('assets/admin/assets/DataTables/DataTables-1.10.18/js/dataTables.bootstrap4.min.js') }}">
            </script>
            <script src="{{ asset('assets/admin/assets/DataTables/JSZip-2.5.0/jszip.min.js') }}"></script>
            <script src="{{ asset('assets/admin/assets/DataTables/pdfmake-0.1.36/pdfmake.min.js') }}"></script>
            <script src="{{ asset('assets/admin/assets/DataTables/pdfmake-0.1.36/vfs_fonts.js') }}"></script>
            <script src="{{ asset('assets/admin/assets/DataTables/Buttons-1.5.6/js/buttons.html5.min.js') }}"></script>
            <script src="{{ asset('assets/admin/assets/DataTables/Buttons-1.5.6/js/buttons.print.min.js') }}"></script>
            <script src="{{ asset('assets/admin/assets/DataTables/Buttons-1.5.6/js/buttons.colvis.min.js') }}"></script>
            <script>
                $(document).ready(function() {
                    var table = $('#table').DataTable({
                        buttons: ['csv', 'print', 'excel', 'pdf'],
                        dom: "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" +
                            "<'row'<'col-md-12'tr>>" +
                            "<'row'<'col-md-5'i><'col-md-7'p>>",
                        lengthMenu: [
                            [5, 10, 25, 50, 100, -1],
                            [5, 10, 25, 50, 100, "ALL"]
                        ]
                    });

                    table.buttons().container()
                        .appendTo('#table_wrapper .col-md-5:eq(0)');
                });
            </script>
            <script>
                // Toggle the sidebar
                $("#sidebarToggleTop").on('click', function() {
                    $("body").toggleClass("sidebar-toggled");
                    $(".sidebar").toggleClass("toggled");
                    if ($(".sidebar").hasClass("toggled")) {
                        $('.sidebar .collapse').collapse('hide');
                    }
                });
            </script>
            <script>
                // SweetAlert Logout Confirmation
                function handleLogout(e) {
                    e.preventDefault();

                    Swal.fire({
                        icon: 'warning',
                        title: 'Konfirmasi Logout',
                        html: '<p style="color: #222D32; font-size: 16px;">Apakah Anda yakin ingin keluar?</p>',
                        showCancelButton: true,
                        confirmButtonColor: '#ffbf0f',
                        confirmButtonTextColor: '#222D32',
                        cancelButtonColor: '#d33',
                        cancelButtonTextColor: '#fff',
                        confirmButtonText: '<i class="fas fa-sign-out-alt"></i> Ya, Keluar',
                        cancelButtonText: 'Batal',
                        didOpen: function() {
                            const titleElement = document.querySelector('.swal2-title');
                            if (titleElement) {
                                titleElement.style.color = '#ffbf0f';
                                titleElement.style.fontWeight = 'bold';
                            }
                            const confirmBtn = document.querySelector('.swal2-confirm');
                            if (confirmBtn) {
                                confirmBtn.style.fontWeight = 'bold';
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ url('admin/logout') }}';
                        }
                    });
                }

                document.getElementById('logoutBtn').addEventListener('click', handleLogout);

                document.querySelectorAll('.logout-btn').forEach(function(btn) {
                    btn.addEventListener('click', handleLogout);
                });
            </script>
            @if (session()->has('swal_type'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: @json(session('swal_type')),
                            title: @json(session('swal_title')),
                            text: @json(session('swal_text')),
                            confirmButtonColor: '#ffbf0f'
                        });
                    });
                </script>
            @endif
            @vite(['resources/css/app.css', 'resources/js/app.js'])
            <x-sweetalert />
</body>

</html>
