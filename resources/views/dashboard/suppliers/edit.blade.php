<x-dashboard-layout>
    <h1 class="mt-4">Edit Supplier</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">Data Supplier</a></li>
        <li class="breadcrumb-item active">Edit Supplier</li>
    </ol>
    <div class="row mb-5">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                    Edit Supplier
                </div>
                <div class="card-body">
                    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $supplier->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">No Telp</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}" required>
                            @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="{{ old('product_name', $supplier->product_name) }}" required>
                            @error('product_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="product_brand" class="form-label">Merk Produk</label>
                            <input type="text" class="form-control @error('product_brand') is-invalid @enderror" id="product_brand" name="product_brand" value="{{ old('product_brand', $supplier->product_brand) }}" required>
                            @error('product_brand')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', $supplier->quantity) }}" required>
                            @error('quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $supplier->price) }}" required>
                            @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="expired" class="form-label">Expired</label>
                            <input type="date" class="form-control @error('expired') is-invalid @enderror" id="expired" name="expired" value="{{ old('expired', \Carbon\Carbon::parse($supplier->expired)->format('Y-m-d')) }}" required>
                            @error('expired')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="payment_proof" class="form-label">Bukti Pembayaran</label>
                            <input type="file" class="form-control" id="payment_proof" name="payment_proof">
                            @if($supplier->payment_proof)
                            <div class="mt-2">
                                <img src="{{ asset('storage/photos/' . $supplier->payment_proof) }}" alt="Bukti Pembayaran" width="100" height="100">
                            </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
