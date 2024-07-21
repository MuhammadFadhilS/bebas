<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko Wildan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        .horizontal-list .list-group-item {
            height: 100%;
        }

        .navbar-custom {
            background-color: #2bd1d7;
        }

        .text-bg-custom {
            background-color: #2bd1d7;
        }

        .text-bg-custom:hover {
            color: #000000af !important;
        }

        .text-dark {
            color: #000000af !important;
        }

        .text-dark:hover {
            color: #000000 !important;
        }

        .active {
            color: #000000 !important;
        }

        .btn-primary {
            background-color: #2bd1d7 !important;
            border-color: #2bd1d7 !important;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #2bd1d7 !important;
            color: #000000 !important;
        }

        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        .footer-contact {
            font-size: 1.1rem;
        }

        .footer-icon {
            font-size: 1.5rem;
            margin-right: 10px;
        }

        .responsive-img {
            max-width: 100%;
            height: auto;
        }

        .social-icons .fa {
            font-size: 1.5rem;
            margin: 0 15px;
            color: #fff;
            transition: color 0.3s ease-in-out;
        }

        .social-icons .fa:hover {
            color: #000;
        }

        .footer-logo img {
            max-width: 150px;
            margin-bottom: 20px;
        }

        .footer {
            color: white;
            background-color: #2bd1d7;
        }
    </style>
</head>

<body style="background-color: whitesmoke">
    <main>
        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg navbar-custom navbar-dark sticky-top">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav gap-2 fw-semibold">
                        <li class="nav-item">
                            <a class="nav-link text-dark {{ Request::is('/') ? 'active' : '' }}" aria-current="page" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark {{ Request::is('about') ? ' active' : '' }}" href="/about">About</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav gap-2 fw-semibold ms-auto">
                        @auth
                        <form action="{{ route('dashboard') }}" method="GET" class="d-flex text-end" role="search">
                            <input type="text" name="keyword" class="form-control" placeholder="Cari nama barang" value="{{request()->keyword}}">
                            <button class="btn btn-primary" type="submit" id="button-addon2">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bxs-user fs-5"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-lg-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('order.index') }}">Order</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                                </li>
                            </ul>
                        </li>
                        @else
                        <form action="{{ route('dashboard') }}" method="GET" class="d-flex text-end" role="search">
                            <input type="text" name="keyword" class="form-control" placeholder="Cari nama barang" value="{{request()->keyword}}">
                            <button class="btn btn-primary" type="submit" id="button-addon2">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        @endauth
                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}"><i class="bx bxs-cart fs-5"></i></a>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
        <!-- NAVBAR -->

        {{ $slot }}

        <!-- FOOTER -->
        <footer class="footer mt-5 py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 footer-logo">
                        <img src="{{ asset('storage/photos/Logo_TA.png') }}" alt="Toko Wildan Logo">
                    </div>
                    <div class="col-md-3">
                        <h5 class="fw-bold pb-2">Jam Buka</h5>
                        <p class="footer-contact"><i class="fas fa-clock footer-icon"></i>Senin - Jumat</p>
                        <p class="footer-contact"><i class="fas fa-clock footer-icon"></i>08.00 - 20.00 Malam</p>
                        <p class="footer-contact"><i class="fas fa-clock footer-icon"></i>Minggu Tutup</p>
                    </div>
                    <div class="col-md-3">
                        <h5 class="fw-bold pb-2">Customer Service</h5>
                        <p class="footer-contact"><i class="fas fa-phone footer-icon"></i>+62 (85753724243)</p>
                        <p class="footer-contact"><i class="fas fa-envelope footer-icon"></i>tokowildan@gmail.com</p>
                    </div>
                    <div class="col-md-3">
                        <h5 class="fw-bold pb-2">Location</h5>
                        <p class="footer-contact">
                            <i class="fas fa-map-marker-alt footer-icon"></i>Jalan Sutoyo S<br>
                            <span class="address-details">Komplek Wildan Sari 4</span>
                        </p>
                        <a href="https://www.google.co.id/maps/place/3%C2%B019'29.6%22S+114%C2%B034'25.4%22E/@-3.3248191,114.5733475,19.09z/data=!4m4!3m3!8m2!3d-3.324876!4d114.573731?entry=ttu">
                            <img src="{{ asset('maps.png') }}" alt="Map" class="responsive-img">
                        </a>
                        <p class="text-center py-3">Lokasi Toko Wildan</p>
                    </div>
                </div>
                <div class="row mt-3 text-center">
                    <div class="col">
                        <div class="social-icons">
                            <a href="#" class="fa fa-facebook"></a>
                            <a href="#" class="fa fa-twitter"></a>
                            <a href="#" class="fa fa-instagram"></a>
                            <a href="#" class="fa fa-linkedin"></a>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col text-center">
                        <span class="text-dark" style="font-size: 13px;">© 2024 Toko Wildan</span>
                    </div>
                </div>
            </div>
        </footer>
        <!-- FOOTER -->
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
