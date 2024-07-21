<x-dashboard-layout>
    <h1 class="mt-4">Tambah Supplier</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">Data Supplier</a></li>
        <li class="breadcrumb-item active">Tambah Supplier</li>
    </ol>
    <div class="row mb-5">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-plus me-1"></i>
                    Tambah Supplier
                </div>
                <div class="card-body">
                    <form action="{{ route('suppliers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">No Telp</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_brand" class="form-label">Merk Produk</label>
                            <input type="text" class="form-control" id="product_brand" name="product_brand" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="expired" class="form-label">Expired</label>
                            <input type="date" class="form-control" id="expired" name="expired" required>
                        </div>
                        <div class="mb-3">
                            <label for="payment_proof" class="form-label">Bukti Pembayaran</label>
                            <input type="file" class="form-control" id="payment_proof" name="payment_proof">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
