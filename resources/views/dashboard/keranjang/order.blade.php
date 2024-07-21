<x-app-layout>
    <section class="pt-5 pb-5">
        <div class="container">
            <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $_GET['products'] }}" name="items">
                <input type="hidden" id="ongkir" name="ongkir" value="10000"> <!-- Hidden field for shipping cost -->

                <div class="row">
                    <div class="col-md-6 mb-3">
                        {{-- Informasi Pelanggan --}}
                        <div class="card mb-3">
                            <div class="card-header text-center">
                                Informasi Pelanggan
                            </div>
                            <div class="card-body table-responsive">
                                <div class="row">
                                    <div class="col-md-3">Nama</div>
                                    <div class="col-auto">:</div>
                                    <div class="col-auto">{{ Auth::user()->name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">Email</div>
                                    <div class="col-auto">:</div>
                                    <div class="col-auto">{{ Auth::user()->email }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">Alamat</div>
                                    <div class="col-auto">:</div>
                                    <div class="col-auto">{{ Auth::user()->address }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">Telepon</div>
                                    <div class="col-auto">:</div>
                                    <div class="col-auto">{{ Auth::user()->telepon }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Wilayah Pelanggan --}}
                        <div class="card mb-3">
                            <div class="card-header">Wilayah Pelanggan</div>
                            <div class="card-body">
                                <select name="wilayah" id="wilayah" class="form-select" required>
                                    <option value="SELATAN" data-ongkir="10000">Banjarmasin Selatan</option>
                                    <option value="UTARA" data-ongkir="20000">Banjarmasin Utara</option>
                                    <option value="BARAT" data-ongkir="30000">Banjarmasin Barat</option>
                                    <option value="TIMUR" data-ongkir="40000">Banjarmasin Timur</option>
                                </select>
                            </div>
                        </div>

                        {{-- Metode Pembayaran --}}
                        <div class="card mb-3">
                            <div class="card-header">Metode Pembayaran</div>
                            <div class="card-body">
                                <select name="method" id="method" class="form-select" required>
                                    <option value="COD">COD</option>
                                    <option value="QRIS">QRIS</option>
                                </select>
                            </div>
                        </div>

                        {{-- Bukti Pembayaran --}}
                        <div class="card mb-3" id="method-payment" style="display:none;">
                            <div class="card-header text-center">Bukti Pembayaran</div>
                            <div class="card-body">
                                <input type="file" name="bukti" class="form-control">
                            </div>
                        </div>

                        {{-- Catatan Pembayaran --}}
                        <div class="card mb-3">
                            <div class="card-header text-center">Catatan</div>
                            <div class="card-body">
                                <textarea name="notes" id="notes" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        {{-- QRIS Payment --}}
                        <div class="card mb-3" id="qris-card" style="display:none;">
                            <div class="card-header text-center">Pembayaran</div>
                            <div class="card-body table-responsive">
                                <img src="{{ asset('qris.jpg') }}" class="img-fluid qris">
                            </div>
                        </div>

                        {{-- Total --}}
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header text-center">PEMESANAN</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3>Total</h3>
                                        </div>
                                        <div class="col-md-6">
                                            <h3 id="total-price">Rp. {{ $_GET['total'] }}</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3>Ongkos Kirim</h3>
                                        </div>
                                        <div class="col-md-6">
                                            <h3 id="shipping-price">Rp. 10.000</h3>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3>Total Harga</h3>
                                        </div>
                                        <div class="col-md-6">
                                            <h3 id="total-harga">Rp. {{ $_GET['total'] + 10000 }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary" type="submit">Checkout</button>
                </div>
            </form>
        </div>
    </section>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        function calculateTotalPrice() {
            // Ambil nilai dari total-price dan shipping-price
            var totalPriceText = document.getElementById("total-price").innerText.replace("Rp. ", "").replace(".", "");
            var shippingPriceText = document.getElementById("shipping-price").innerText.replace("Rp. ", "").replace(".", "");

            // Konversi nilai ke integer
            var totalPrice = parseInt(totalPriceText);
            var shippingPrice = parseInt(shippingPriceText);

            // Hitung total harga
            var totalHarga = totalPrice + shippingPrice;

            // Format angka dengan titik sebagai pemisah ribuan
            function formatRupiah(angka) {
                var numberString = angka.toString(),
                sisa = numberString.length % 3,
                rupiah = numberString.substr(0, sisa),
                ribuan = numberString.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    var separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return "Rp. " + rupiah;
            }

            // Tampilkan total harga yang sudah diformat
            document.getElementById("total-harga").innerText = formatRupiah(totalHarga);
        }

        document.getElementById("wilayah").addEventListener("change", function() {
            var selectedOption = this.options[this.selectedIndex];
            var shippingPrice = selectedOption.getAttribute("data-ongkir");

            document.getElementById("shipping-price").innerText = "Rp. " + shippingPrice;
            document.getElementById("ongkir").value = shippingPrice;  // Update hidden field value
            calculateTotalPrice();
        });

        document.getElementById("wilayah").dispatchEvent(new Event('change'));

        const methodSelect = document.getElementById('method');
        const qrisCard = document.getElementById('qris-card');
        const methodPayment = document.getElementById('method-payment');
        const buktiInput = document.querySelector('input[name="bukti"]');

        methodSelect.addEventListener('change', function() {
            if (this.value === 'QRIS') {
                qrisCard.style.display = 'block';
                methodPayment.style.display = 'block';
                buktiInput.setAttribute('required', 'required');
            } else {
                qrisCard.style.display = 'none';
                methodPayment.style.display = 'none';
                buktiInput.removeAttribute('required');
            }
        });
    });
    </script>
</x-app-layout>
