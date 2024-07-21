<x-app-layout>
    <section class="pt-5 pb-5">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header text-center">
                    Order
                </div>
                <div class="card-body table-responsive">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th> <!-- Add Tanggal column -->
                                <th>Barang</th>
                                {{-- <th>Total</th> --}}
                                {{-- <th>Ongkir</th> --}}
                                <th>Total Harga</th>
                                <th>Nama Kurir</th>
                                <th>Telepon Kurir</th>
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
                                <td>{{ \Carbon\Carbon::parse($order->tanggal)->format('d-m-Y') }}</td> <!-- Display Tanggal -->
                                <td>{{ $order->product_names }} <br></td>
                                {{-- <td>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($order->ongkir, 0, ',', '.') }}</td> --}}
                                <td>Rp. {{ number_format($order->total_price + $order->ongkir, 0, ',', '.') }}</td> <!-- Calculate Total Harga -->
                                <td>{{ $order->courier }}</td>
                                <td>{{ $order->courier_telepon }}</td>
                                <td>
                                    @php
                                    $statusClass = '';
                                    $statusText = '';

                                    switch ($order->status) {
                                        case 3:
                                            $statusClass = 'bg-warning text-dark';
                                            $statusText = 'Proses Pengemasan';
                                            break;
                                        case 4:
                                            $statusClass = 'bg-info text-white';
                                            $statusText = 'Proses Pengiriman';
                                            break;
                                        case 5:
                                            $statusClass = 'bg-success text-white';
                                            $statusText = 'Barang telah diterima';
                                            break;
                                        case 6:
                                            $statusClass = 'bg-primary text-white';
                                            $statusText = 'Pengajuan Refund';
                                            break;
                                        case 7:
                                            $statusClass = 'bg-danger text-white';
                                            $statusText = 'Pengajuan Refund Ditolak';
                                            break;
                                        case 8:
                                            $statusClass = 'bg-success text-white';
                                            $statusText = 'Pengajuan Refund Diterima';
                                            break;
                                        case 9:
                                            $statusClass = 'bg-dark text-white';
                                            $statusText = 'Order Ditolak';
                                            break;
                                    }
                                    @endphp
                                    <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                </td>
                                <td>
                                    @if ($order->status == 3)
                                        <a href="{{ route('order.destroy', $order->id) }}" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin batalkan pesanan?')">
                                            Batalkan
                                        </a>
                                    @elseif ($order->status == 4)
                                        <a href="{{ route('order.confirmation', $order->id) }}"
                                            class="btn btn-sm btn-success"
                                            onclick="return confirm('Yakin ingin terima barang?')">
                                            Terima
                                        </a>
                                        <a class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#refund{{ $order->id }}">
                                            Refund
                                        </a>

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
                                                    <form action="{{ route('refund') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $order->id }}">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Alasan Refund</label>
                                                                <textarea name="alasan_refund" class="form-control"
                                                                    placeholder="Alasan Refund" required></textarea>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Bukti</label>
                                                                <input type="file" class="form-control" name="bukti_refund"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">
                                                                Refund
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatablesSimple').DataTable({
                responsive: true
            });
        });
    </script>

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
            color: #ffffff;
        }

        .bg-primary {
            background-color: #0d6efd;
            color: #ffffff;
        }

        .bg-danger {
            background-color: #dc3545;
            color: #ffffff;
        }

        .bg-dark {
            background-color: #343a40;
            color: #ffffff;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5em 1em;
            border-radius: 0.25rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #007bff;
            color: white;
        }

        /* Optional: Add styling for table headers and rows */
        #datatablesSimple thead th {
            background-color: #f8f9fa;
            color: #495057;
        }

        #datatablesSimple tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</x-app-layout>
