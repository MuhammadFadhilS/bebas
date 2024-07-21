<x-app-layout>
    <section class="pt-5 pb-5">
        <div class="container">
            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif
            {{-- DETAIL PRODUCT --}}
            <div class="row mb-5">
                <div class="col-md-4 mb-3">
                    {{-- GAMBAR --}}
                    <img class="img-fluid img-thumbnail" alt="100%x280" src="/storage/photos/{{ $product->photo }}">
                </div>
                <div class="col-md-8 mb-3">
                    {{-- JUDUL --}}
                    <h2 class="mb-4">{{ $product->name }}</h2>
                    {{-- HARGA --}}
                    <h3 class="mb-4">
                        Rp. {{ number_format($product->price, 0, ',', '.') }}
                    </h3>
                    {{-- BODY --}}
                    <p style="text-align: justify" class="mb-4">
                        {{ $product->description }}
                    </p>
                    {{-- ADD TO CART --}}
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        <div class="row">
                            @csrf
                            <div class="col-md-2">
                                <select name="qty" id="qty" class="form-select">
                                    @for ($i = 1; $i <= $product->stock; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    Add to cart
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <hr>
            </div>

            {{-- ANOTHER PRODUCT --}}
            @if ($products->count() > 0)
            <style>
            .card {
                height: 100%;
            }

            .card-title {
                height: 60px;
            }

            .card img {
                max-width: auto;
                /* Set the desired max-width for the image */
                max-height: 100px;
                /* Set the desired max-height for the image */
                display: block;
                margin: 0 auto;
                /* Center the image horizontally */
            }
            </style>
            <div class="row">
                <div class="col-12">
                    <h3 class="mb-3">Another Products</h3>
                </div>
                <div class="col-12 text-end">
                    <a class="btn btn-primary mb-3 mr-1" role="button" data-bs-slide="prev"
                        data-bs-target="#carouselExampleIndicators2">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <a class="btn btn-primary mb-3 " role="button" data-bs-slide="next"
                        data-bs-target="#carouselExampleIndicators2">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
                <div class="col-12">
                    <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @php
                            $productChunks = $products->toArray();
                            $productChunks = array_chunk($productChunks, 6);
                            @endphp
                            @foreach ($productChunks as $productChunk)
                            <div class="carousel-item {{ $loop->first ? ' active' : '' }}">
                                <div class="row">
                                    @foreach ($productChunk as $product)
                                    <div class="col-md-4 mb-3">
                                        <div class="card shadow">
                                            <img class="img-fluid" alt="Toko Wildan"
                                                src="/storage/photos/{{ $product['photo'] }}"
                                                style="max-height: 250px;">

                                            <div class="card-body">
                                                <h4 class="card-title">{{ $product['name'] }}</h4>
                                                <p class="card-text">Rp
                                                    {{ number_format($product['price'], 0, ',', '.') }}
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
            </div>
            @endif

        </div>
    </section>
</x-app-layout>