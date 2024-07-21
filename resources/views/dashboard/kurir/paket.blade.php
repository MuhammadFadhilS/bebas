<x-dashboard-layout>
    <h1 class="mt-4">Daftar Paket</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Daftar Paket</li>
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

                    <table id="datatablesSimple" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Produk</th>
                                <th>Metode</th>
                                <th>Total Harga</th>
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
                            @foreach ($items as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->product_names }}</td>
                                <td>{{ $item->method }}</td>
                                <td>Rp. {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                <td>{{ $item->courier }}</td>
                                <td>{{ $item->address }}</td>
                                <td>{{ $item->notes }}</td>
                                <td>
                                    @php
                                    if ($item->status == 3) {
                                        echo '<span class="badge bg-warning">Proses Pengemasan</span>';
                                    } elseif ($item->status == 4) {
                                        echo '<span class="badge bg-info">Proses Pengiriman</span>';
                                    } elseif ($item->status == 5) {
                                        echo '<span class="badge bg-success">Barang telah diterima</span>';
                                    } elseif ($item->status == 6) {
                                        echo '<span class="badge bg-info">Pengajuan Refund</span>';
                                    } elseif ($item->status == 7) {
                                        echo '<span class="badge bg-danger">Pengajuan Refund Ditolak</span>';
                                    } elseif ($item->status == 8) {
                                        echo '<span class="badge bg-success">Pengajuan Refund Diterima</span>';
                                    } elseif ($item->status == 9) {
                                        echo '<span class="badge bg-dark">Order Ditolak</span>';
                                    }
                                    @endphp
                                </td>
                                <td>
                                    @if ($item->status == 4)
                                        <a href="{{ route('courier.confirmation', $item->id) }}" class="btn btn-sm btn-success" onclick="return confirm('Yakin ingin konfirmasi bahwa barang telah diterima?')">
                                            Terima
                                        </a>
                                    @endif
                                </td>
                            </tr>
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
</x-dashboard-layout>
