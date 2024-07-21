<x-app-layout>
    <section class="pt-5 pb-5">
        <div class="container">
            @if (session('success'))
                <div class="alert text-dark" role="alert" style="background-color: #2bd1d7">
                    {{ session('success') }}
                </div>
            @endif

            @if ($carts->count() > 0)
                <div class="row">
                    {{-- DAFTAR KERANJANG --}}
                    <div class="col-md-6">
                        @foreach ($carts as $cart)
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="/storage/photos/{{ $cart->product->photo }}"
                                            class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-header text-end">
                                            <input type="checkbox" class="item-checkbox"
                                                data-price="{{ $cart->product->price }}" data-id="{{ $cart->id }}">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $cart->product->name }}</h5>
                                            <p class="card-text">
                                                Rp. {{ number_format($cart->product->price, 0, ',', '.') }}
                                            </p>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <select name="qty" id="qty_{{ $cart->id }}"
                                                        class="form-select">
                                                        @for ($i = 1; $i <= $cart->product->stock; $i++)
                                                            <option value="{{ $i }}"
                                                                @selected($i == $cart->qty)>{{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col d-flex justify-content-end">
                                                    <a href="{{ route('cart-destroy', $cart->id) }}"
                                                        class="btn btn-danger"
                                                        onclick="return confirm('Yakin ingin hapus barang dari keranjang?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- TOTAL --}}
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header text-center">
                                PEMESANAN
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>Total</h3>
                                    </div>
                                    <div class="col-md-6">
                                        <h3 id="total-price">Rp. 0</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center d-grid">
                                <button class="btn btn-primary" id="btn-buat-pesanan">Buat Pesanan</button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row justify-content-center my-5">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <p>Belum ada barang di keranjang</p>
                                <a href="/" class="btn btn-primary">Belanja Sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const btnBuatPesanan = document.getElementById('btn-buat-pesanan');

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateTotalPrice();
            });
        });

        const qtySelects = document.querySelectorAll('select[name="qty"]');
        qtySelects.forEach(function(qtySelect) {
            qtySelect.addEventListener('change', function() {
                updateTotalPrice();
            });
        });

        btnBuatPesanan.addEventListener('click', function() {
            const selectedItems = [];
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    const id = checkbox.getAttribute('data-id');
                    selectedItems.push(id);
                }
            });

            if (selectedItems.length > 0) {
                const itemsWithQty = selectedItems.map(item => ({
                    id: item,
                    qty: document.getElementById(`qty_${item}`).value
                }));

                fetch('/update-status-barang', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            items: itemsWithQty,
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        const selectedProducts = selectedItems.join(',');
                        const total = getTotalPrice();
                        const url = `/cart/order?products=${selectedProducts}&total=${total}`;
                        window.location.href = url;
                    })
                    .catch(error => {
                        console.error('There has been a problem with your fetch operation:', error);
                    });
            } else {
                alert('Pilih barang terlebih dahulu sebelum membuat pesanan.');
            }
        });

        function updateTotalPrice() {
            let total = 0;
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    let price = parseFloat(checkbox.getAttribute('data-price'));
                    let id = checkbox.getAttribute('data-id');
                    let qtySelect = document.getElementById('qty_' + id);
                    let qty = parseInt(qtySelect.value);
                    total += price * qty;
                }
            });

            document.getElementById('total-price').innerText = formatRupiah(total);
        }

        function formatRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return 'Rp. ' + ribuan;
        }

        function getTotalPrice() {
            let total = 0;
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    let price = parseFloat(checkbox.getAttribute('data-price'));
                    let id = checkbox.getAttribute('data-id');
                    let qtySelect = document.getElementById('qty_' + id);
                    let qty = parseInt(qtySelect.value);
                    total += price * qty;
                }
            });
            return total;
        }
    });
</script>
