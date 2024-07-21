<x-dashboard-layout>
    <h1 class="mt-4">Tambah Laporan Penjualan (Offline)</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Tambah Laporan Penjualan (Offline)</li>
    </ol>
    <div class="row mb-5">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <div class="col-12 mb-3">
                            <label for="nama_customer" class="form-label">Nama Customer</label>
                            <input type="text" class="form-control @error('nama_customer') is-invalid @enderror"
                                name="nama_customer" value="{{ old('nama_customer') }}" placeholder="Nama Customer">
                            @error('nama_customer')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                name="tanggal" value="{{ old('tanggal') }}" placeholder="Tanggal">
                            @error('tanggal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div id="product-container">
                            <div class="product-group">
                                <div class="row align-items-center">
                                    <div class="col-4 mb-3">
                                        <label for="product_id" class="form-label">Nama Produk</label>
                                        <select name="product_id[]" class="form-select product-id @error('product_id') is-invalid @enderror">
                                            <option selected disabled>-- Pilih Produk --</option>
                                            @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-stock="{{ $product->stock }}"
                                                data-price="{{ $product->price }}"
                                                {{ $product->id == old('product_id') ? 'selected' : '' }}>
                                                {{ $product->name }} - {{ number_format($product->price, 0, ',', '.') }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('product_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-2 mb-3">
                                        <label for="qty" class="form-label">Jumlah</label>
                                        <select name="qty[]" class="form-select qty @error('qty') is-invalid @enderror">
                                        </select>
                                        @error('qty')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-2 mb-3">
                                        <label for="price" class="form-label">Harga</label>
                                        <input type="text" class="form-control price" name="price[]" readonly>
                                    </div>

                                    <div class="col-2 mb-3">
                                        <button type="button" class="btn btn-danger remove-product">Hapus</button>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <button type="button" class="btn btn-primary" id="add-product">Tambah Produk</button>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="total-price" class="form-label">Total Harga</label>
                            <input type="text" class="form-control" id="total-price" name="total_price" readonly>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productContainer = document.getElementById('product-container');
            const addProductButton = document.getElementById('add-product');
            const totalPriceInput = document.getElementById('total-price');

            addProductButton.addEventListener('click', function() {
                // Check for duplicate products
                const productIds = Array.from(document.querySelectorAll('.product-id')).map(select => select.value);
                const hasDuplicate = productIds.some((item, index) => productIds.indexOf(item) !== index);

                if (hasDuplicate) {
                    alert('Anda tidak dapat menambahkan produk yang sama lebih dari sekali.');
                    return;
                }

                const productGroup = document.querySelector('.product-group').cloneNode(true);
                productGroup.querySelectorAll('input').forEach(input => input.value = '');
                productGroup.querySelectorAll('.qty').forEach(select => select.innerHTML = '');
                productContainer.appendChild(productGroup);
                attachProductChangeEvent(productGroup);
                attachRemoveProductEvent(productGroup.querySelector('.remove-product'));
                updateTotalPrice();
            });

            function attachProductChangeEvent(productGroup) {
                const productSelect = productGroup.querySelector('.product-id');
                const qtySelect = productGroup.querySelector('.qty');
                const priceInput = productGroup.querySelector('.price');

                productSelect.addEventListener('change', function() {
                    const selectedOption = productSelect.options[productSelect.selectedIndex];
                    const stock = selectedOption.getAttribute('data-stock');
                    const price = selectedOption.getAttribute('data-price');

                    priceInput.value = formatNumber(price);

                    qtySelect.innerHTML = '';

                    for (let i = 1; i <= stock; i++) {
                        const option = document.createElement('option');
                        option.value = i;
                        option.textContent = i;
                        qtySelect.appendChild(option);
                    }

                    qtySelect.value = 1;  // Default to quantity 1

                    // Check for duplicate products
                    const productIds = Array.from(document.querySelectorAll('.product-id')).map(select => select.value);
                    const hasDuplicate = productIds.some((item, index) => productIds.indexOf(item) !== index);

                    if (hasDuplicate) {
                        alert('Anda tidak dapat menambahkan produk yang sama lebih dari sekali.');
                        productSelect.value = '';
                        priceInput.value = '';
                        qtySelect.innerHTML = '';
                        return;
                    }

                    updateTotalPrice();
                });

                qtySelect.addEventListener('change', updateTotalPrice);

                productSelect.dispatchEvent(new Event('change'));
            }

            function attachRemoveProductEvent(removeButton) {
                removeButton.addEventListener('click', function() {
                    if (document.querySelectorAll('.product-group').length > 1) {
                        removeButton.closest('.product-group').remove();
                        updateTotalPrice();
                    } else {
                        alert('Anda harus memiliki setidaknya satu produk.');
                    }
                });
            }

            function updateTotalPrice() {
                let total = 0;
                document.querySelectorAll('.product-group').forEach(group => {
                    const price = parseFloat(group.querySelector('.price').value.replace(/\./g, '') || 0);
                    const qty = parseInt(group.querySelector('.qty').value || 0);
                    total += price * qty;
                });
                totalPriceInput.value = formatNumber(total);
            }

            function formatNumber(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            document.querySelectorAll('.product-group').forEach(group => {
                attachProductChangeEvent(group);
                attachRemoveProductEvent(group.querySelector('.remove-product'));
                group.querySelector('.qty').addEventListener('change', updateTotalPrice);
            });

            updateTotalPrice();
        });
    </script>

    <!-- CSS Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    <style>
        .product-group {
            border: 1px solid #dee2e6;
            border-radius: .375rem;
            padding: 1rem;
            background-color: #fff;
        }
        .product-group hr {
            margin: 1rem 0;
        }
        .product-group .remove-product {
            display: block;
            width: 100%;
        }
        /* Flexbox adjustments */
        #product-container {
            display: flex;
            flex-direction: column;
            gap: 1rem; /* Adjust the gap between product groups */
        }
        /* Responsive layout for 2 columns */
        @media (min-width: 768px) {
            .product-group .row > div {
                padding: 0 0.5rem;
            }
        }
        /* Adjust for alignment of the delete button */
        .remove-product {
            padding: 0.375rem 0.75rem;
            margin-top: 0;
        }
    </style>
</x-dashboard-layout>
