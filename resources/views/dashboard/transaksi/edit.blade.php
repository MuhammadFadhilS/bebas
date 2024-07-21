<x-dashboard-layout>
    <h1 class="mt-4">Proses Pesanan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Proses Pesanan</li>
    </ol>
    <div class="row mb-3">
        @if ($cart->method == 'QRIS')
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Bukti Pembayaran
                </div>

                <div class="card-body">
                    <img src="/storage/photos/{{ $cart->bukti }}" class="img-fluid">
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Kurir
                </div>
                <div class="card-body">
                    <form action="{{ route('transaction.update', $id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="col-12 mb-3">
                            <label for="courier_id" class="form-label">Kurir</label>
                            <select name="courier_id" id="courier_id"
                                class="form-control @error('courier_id') is-invalid @enderror" required>
                                <option selected disabled value="">-- Pilih Kurir --</option>
                                @foreach ($couriers as $courier)
                                <option value="{{ $courier->id }}">
                                    {{ $courier->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('courier_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <button type="submit" class="btn btn-success">Konfirmasi Pesanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>