<x-app-layout>
    <style>
        .gambar img {
            width: 100%;
            height: auto;
            object-fit: fill;
        }

        /* Ensure the carousel height is consistent across devices */
        @media (max-width: 767.98px) {
            .gambar img {
                height: auto;

                /* Adjust height for mobile view */
            }
        }

        @media (min-width: 768px) {
            .gambar img {
                height: 480px;
                /* Adjust height for larger screens */
            }
        }

        .harga-awal {
            text-decoration: line-through;
            color: #888;
        }

        /* Card styling for the price */
        .card {
            height: 100%;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-title {
            height: 60px;
        }

        .card img {
            max-width: auto;
            max-height: 100px;
            display: block;
            margin: 0 auto;
        }

        #scrollTopBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            border: none;
            outline: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        #scrollTopBtn:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            #scrollTopBtn {
                bottom: 10px;
                right: 10px;
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>
    <div class="container pt-4">
        <div class="row">
            <div class="col-md-8">
                <h1 class="text-primary">
                    <span>Toko Wildan</span>
                </h1>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col carousel-slide">
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item gambar active">
                            <img src="storage/photos/satu.jpg" class="d-block w-100 img-fluid rounded" alt="Toko Wildan">
                            <div class="carousel-caption d-none d-md-block  bg-opacity-50 rounded">
                                {{-- <h5>First slide label</h5>
                                <p>Some representative placeholder content for the first slide.</p> --}}
                            </div>
                        </div>
                        <div class="carousel-item gambar">
                            <img src="storage/photos/2new.jpg" class="d-block w-100 img-fluid rounded" alt="Toko Wildan">
                            <div class="carousel-caption d-none d-md-block  bg-opacity-50 rounded">
                                {{-- <h5>Second slide label</h5>
                                <p>Some representative placeholder content for the second slide.</p> --}}
                            </div>
                        </div>
                        <div class="carousel-item gambar">
                            <img src="storage/photos/3new.jpg" class="d-block w-100 img-fluid rounded" alt="Toko Wildan">
                            <div class="carousel-caption d-none d-md-block  bg-opacity-50 rounded">
                                {{-- <h5>Third slide label</h5>
                                <p>Some representative placeholder content for the third slide.</p> --}}
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <section class="pt-5 pb-5">
        <div class="container">
            @if (session('success'))
            <div class="alert text-dark" role="alert" style="background-color: #2bd1d7">
                {{ session('success') }}
            </div>
            @endif

            <div class="row">
                <div class="col-4 mb-2">
                    <form action="{{ route('dashboard') }}" method="GET">
                        <select name="category" class="form-select" onchange="this.form.submit()">
                            <option selected disabled>Kategori</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                @if ($products->count() > 0)
                <div class="col-12 text-end">
                    <a class="btn btn-primary mb-3 mr-1" role="button" data-bs-slide="prev" data-bs-target="#carouselExampleIndicators2">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <a class="btn btn-primary mb-3" role="button" data-bs-slide="next" data-bs-target="#carouselExampleIndicators2">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
                <div class="col-12">
                    <style>
                    .card {
                        height: 100%;
                        transition: transform 0.3s;
                    }
                    .card:hover {
                        transform: scale(1.05);
                    }
                    .card-title {
                        height: 60px;
                    }
                    .card img {
                        max-width: auto;
                        max-height: 100px;
                        display: block;
                        margin: 0 auto;
                    }
                    #scrollTopBtn {
                        display: none;
                        position: fixed;
                        bottom: 20px;
                        right: 30px;
                        z-index: 99;
                        border: none;
                        outline: none;
                        background-color: #007bff;
                        color: white;
                        cursor: pointer;
                        padding: 15px;
                        border-radius: 10px;
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                        transition: background-color 0.3s, box-shadow 0.3s;
                    }
                    #scrollTopBtn:hover {
                        background-color: #0056b3;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
                    }
                    @media (max-width: 768px) {
                        #scrollTopBtn {
                            bottom: 10px;
                            right: 10px;
                            padding: 10px;
                            font-size: 14px;
                        }
                    }
                    .discount-label {
                        position: absolute;
                        top: 10px;
                        right: 10px;
                        background-color: red;
                        color: white;
                        padding: 5px 10px;
                        border-radius: 5px;
                        font-weight: bold;
                    }
                    </style>
                    <div id="carouselExampleIndicators2" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @php
                            $productChunks = $products->toArray();
                            $productChunks = array_chunk($productChunks, 6);
                            @endphp
                             @foreach ($productChunks as $productChunk)
                             <div class="carousel-item {{ $loop->first ? ' active' : '' }}">
                                 <div class="row">
                                     @foreach ($productChunk as $product)
                                     @php
                                     $discountPercent = 0;
                                     if ($product['harga_awal'] && $product['harga_awal'] > $product['price']) {
                                     $discountPercent = round((($product['harga_awal'] - $product['price']) /
                                     $product['harga_awal']) * 100);
                                     }
                                     @endphp
                                     <div class="col-md-4 mb-3">
                                         <div class="card shadow">
                                             @if($discountPercent > 0)
                                             <div class="discount-label">Diskon {{ $discountPercent }}%</div>
                                             @endif
                                             <img class=" img-fluid small-card" alt="ashopx"
                                                 src=" storage/photos/{{ $product['photo'] }}"
                                                 style="max-height: 250px;">
                                             <div class=" card-body">
                                                 <h4 class="card-title">{{ $product['name'] }}</h4>
                                                 <p class="card-text">
                                                     @if($product['harga_awal'] && $product['harga_awal'] >
                                                     $product['price'])
                                                     <del>IDR
                                                         {{ number_format($product['harga_awal'], 0, ',', '.') }}</del><br>
 
                                                     @endif
                                                     IDR {{ number_format($product['price'], 0, ',', '.') }}
                                                 </p>
                                                 <a href="{{ route('product.show', $product['id']) }}"
                                                     class="btn btn-primary">Add to cart</a>
                                             </div>
                                         </div>
                                     </div>
                                     @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <div class="row justify-content-center mt-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <b>Belum ada barang</b>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <button onclick="topFunction()" id="scrollTopBtn" title="Go to top"><i class="fas fa-arrow-up"></i></button>
    <script>
        window.onscroll = function() {scrollFunction();};

        function scrollFunction() {
            const scrollTopBtn = document.getElementById("scrollTopBtn");
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                scrollTopBtn.style.display = "block";
            } else {
                scrollTopBtn.style.display = "none";
            }
        }

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
</x-app-layout>
