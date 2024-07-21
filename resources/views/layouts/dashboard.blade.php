<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - Toko Wildan</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Toko Wildan</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Master Data</div>
                        <a class="nav-link {{ Request::is('dashboard-TokoWildan') ? 'active' : '' }}"
                            href="{{ route('admin') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        @if (Auth::user()->role == 'admin')
                            <a class="nav-link {{ Request::is('product*') ? 'active' : '' }}"
                                href="{{ route('product.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Produk
                            </a>
                            <a class="nav-link {{ Request::is('suppliers*') ? 'active' : '' }}"
                                href="{{ route('suppliers.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Supplier
                            </a>
                            <a class="nav-link {{ Request::is('category*') ? 'active' : '' }}"
                                href="{{ route('category.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Kategori
                            </a>
                            <a class="nav-link {{ Request::is('transaction*') ? 'active' : '' }}"
                                href="{{ route('transaction.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Transaksi
                            </a>
                            <a class="nav-link {{ Request::is('report*') ? 'active' : '' }}"
                                href="{{ route('report.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Laporan Penjualan
                            </a>
                            <a class="nav-link {{ Request::is('upah*') ? 'active' : '' }}"
                                href="{{ route('upah.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Upah Kurir
                            </a>
                            <a class="nav-link {{ Request::is('courier*') ? 'active' : '' }}"
                                href="{{ route('courier.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Kurir
                            </a>
                        @elseif (Auth::user()->role == 'owner')
                            <a class="nav-link {{ Request::is('admin*') ? 'active' : '' }}"
                                href="{{ route('admin.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Admin
                            </a>
                            {{-- <a class="nav-link  {{ Request::is('operator*') ? 'active' : '' }}"
                            href="{{ route('operator.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Operator
                        </a> --}}
                            <a class="nav-link {{ Request::is('report*') ? 'active' : '' }}"
                                href="{{ route('report.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Laporan
                            </a>
                        @elseif (Auth::user()->role == 'kurir')
                            <a class="nav-link {{ Request::is('daftar-paket') ? 'active' : '' }}"
                                href="{{ route('courier.paket') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Daftar Paket
                            </a>
                        @else
                            <a class="nav-link {{ Request::is('report*') ? 'active' : '' }}"
                                href="{{ route('report.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Laporan
                            </a>
                        @endif
                        <a class="nav-link" href="{{ route('logout') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-power-off"></i>
                            </div>
                            Logout
                        </a>

                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    {{ Auth::user()->role }}
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function previewFile(input) {
            $("#frame").removeClass('d-none');
            $("#frameOri").addClass('d-none');
            var file = $("input[type=file]").get(0).files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function() {
                    $("#previewImage").attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>
