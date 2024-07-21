<x-dashboard-layout>
    <h1 class="mt-4">Transaksi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Transaksi</li>
    </ol>

    <div class="row mb-3">
        <div class="col">
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
                                <th>Waktu Order</th> <!-- Tambahkan kolom Waktu Order -->
                                <th>Nama Pelanggan</th>
                                <th>Produk</th>
                                <th>Metode</th>
                                <th>Total Harga</th>
                                <th>Ongkir</th>
                                <th>Kurir</th>
                                <th>Alamat Pelanggan</th>
                                <th>Catatan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_time)->setTimezone('Asia/Jakarta')->format('H:i:s') }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->product_names }}</td>
                                <td>{{ $order->method }}</td>
                                <td>{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td>{{ number_format($order->ongkir, 0, ',', '.') }}</td>
                                <td>{{ $order->courier }}</td>
                                <td>{{ $order->address }}</td>
                                <td>{{ $order->notes }}</td>
                                <td>
                                    @php
                                    if ($order->status == 3) {
                                        echo '<span class="badge bg-warning">Proses Pengemasan</span>';
                                    } elseif ($order->status == 4) {
                                        echo '<span class="badge bg-warning">Proses Pengiriman</span>';
                                    } elseif ($order->status == 5) {
                                        echo '<span class="badge bg-success">Barang telah diterima</span>';
                                    } elseif ($order->status == 6) {
                                        echo '<span class="badge bg-info">Pengajuan Refund</span>';
                                    } elseif ($order->status == 7) {
                                        echo '<span class="badge bg-danger">Pengajuan Refund Ditolak</span>';
                                    } elseif ($order->status == 8) {
                                        echo '<span class="badge bg-success">Pengajuan Refund Diterima</span>';
                                    } elseif ($order->status == 9) {
                                        echo '<span class="badge bg-dark">Order Ditolak</span>';
                                    }
                                    @endphp
                                </td>
                                <td>
                                    @if ($order->status == 6)
                                    <a class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#refund{{ $order->id }}">
                                        Refund
                                    </a>
                                    @elseif ($order->status >= 4)
                                    <button class="btn btn-sm btn-warning" disabled>Proses</button>
                                    @else
                                    <a href="{{ route('transaction.edit', $order->id) }}"
                                        class="btn btn-warning btn-sm">Proses</a>
                                    <form action="{{ route('transaction.reject', $order->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="refund{{ $order->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Refund
                                                {{ $order->product_names }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <input type="hidden" name="id" value="{{ $order->id }}">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Alasan Refund</label>
                                                <textarea name="alasan_refund" class="form-control"
                                                    placeholder="Alasan Refund"
                                                    disabled>{{ $order->alasan_refund }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Bukti</label>
                                                <img src="/storage/photos/{{ $order->bukti_refund }}"
                                                    class="img-fluid img-thumbnail">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <a href="{{ route('refund.reject', $order->id) }}" class="btn btn-danger">
                                                Tolak Refund
                                            </a>
                                            <a href="{{ route('refund.accept', $order->id) }}" class="btn btn-primary">
                                                Terima Refund
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <style>
        .badge {
            padding: 0.5em 1em;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 700;
            line-height: 1;
            display: inline-block;
            text-align: center;
        }

        .bg-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .bg-success {
            background-color: #198754;
            color: #ffffff;
        }

        .bg-info {
            background-color: #0dcaf0;
            color: #212529;
        }

        .bg-danger {
            background-color: #dc3545;
            color: #ffffff;
        }

        .bg-dark {
            background-color: #343a40;
            color: #ffffff;
        }
    </style>
</x-dashboard-layout>
