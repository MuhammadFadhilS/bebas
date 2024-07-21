<x-dashboard-layout>
    <h1 class="mt-4">Produk</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Produk</li>
    </ol>
    <div class="row mb-5">
        <div class="col">
            <a class="btn btn-primary mb-3" href="{{ route('product.create') }}">Tambah Produk</a>
            <a class="btn btn-primary mb-3" href="{{ route('order.create') }}">Penjualan Offline</a>

            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Brand</th>
                                <th>Harga Awal</th> <!-- Add Harga Awal column -->
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Expired</th>
                                <th>Status</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp

                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $product->kode_barang }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->brand }}</td>
                                <td>{{ $product->harga_awal }}</td> <!-- Display Harga Awal -->
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->expired }}</td>
                                <td>
                                    @php
                                    if ($product->status == 1) {
                                    echo 'Ditampilkan';
                                    } else {
                                    echo 'Tidak Ditampilkan';
                                    }
                                    @endphp
                                </td>
                                <td>
                                    <img src="/storage/photos/{{ $product->photo }}" width="50">
                                </td>
                                <td>
                                    <a href="{{ route('product.edit', $product) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <a href="{{ route('product.destroy', $product) }}" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin hapus data?')">Hapus</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
