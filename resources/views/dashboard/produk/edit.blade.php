<x-dashboard-layout>
    <h1 class="mt-4">Edit Produk</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Edit Produk</li>
    </ol>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('product.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="col-12 mb-3">
                            <label for="name" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Nama Produk" name="name" id="name" value="{{ $product->name }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="kode_barang" class="form-label">Kode Barang</label>
                            <input type="text" class="form-control @error('kode_barang') is-invalid @enderror"
                                placeholder="Kode Barang" name="kode_barang" id="kode_barang" value="{{ $product->kode_barang }}">
                            @error('kode_barang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select name="category_id" id="category_id"
                                class="form-control @error('category_id') is-invalid @enderror">
                                <option selected disabled>-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected($category->id == $product->category_id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="brand" class="form-label">Nama Brand</label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror"
                                placeholder="Nama Brand" name="brand" id="brand" value="{{ $product->brand }}">
                            @error('brand')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="harga_awal" class="form-label">Harga Awal</label>
                            <input type="number" class="form-control @error('harga_awal') is-invalid @enderror"
                                placeholder="Harga Awal" name="harga_awal" id="harga_awal" value="{{ $product->harga_awal }}">
                            @error('harga_awal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="price" class="form-label">Harga Jual</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror"
                                placeholder="Harga" name="price" id="price" value="{{ $product->price }}">
                            @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="expired" class="form-label">Expired</label>
                            <input type="date" class="form-control @error('expired') is-invalid @enderror"
                                placeholder="Expired" name="expired" id="expired" value="{{ $product->expired }}">
                            @error('expired')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                placeholder="Stock" name="stock" id="stock" value="{{ $product->stock }}">
                            @error('stock')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">Keterangan</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Keterangan" name="description" id="description"
                                value="{{ $product->description }}">
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="photo" class="form-label">Gambar</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                placeholder="Gambar" name="photo" id="photo" onchange="previewFile(this)">
                            @error('photo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-6 mb-3" id="frameOri">
                            <img src="/storage/photos/{{ $product->photo }}" class="img-fluid" width="200">
                        </div>
                        <div class="col-6 mb-3 d-none" id="frame">
                            <img src="" class="img-fluid" width="200" id="previewImage">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option selected disabled>-- Pilih Status --</option>
                                <option value="1" @selected($product->status == 1)>Tampilkan</option>
                                <option value="0" @selected($product->status == 0)>Tidak Tampilkan</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
