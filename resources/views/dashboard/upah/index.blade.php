<x-dashboard-layout>
    <h1 class="mt-4">Data Upah</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Upah Kurir</li>
    </ol>

    <div class="row mb-5">
        <div class="col-12 mb-2">
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <div class="col-12 mb-2">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <div class="col-12 mb-4">
            <!-- Tombol untuk membuka modal dengan styling lebih baik -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateWageModal">
                Ganti Harga Upah
            </button>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-body">
                    @if($items->isEmpty())
                        <p>No data available</p>
                    @else
                        <table id="datatablesSimple" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kurir</th>
                                    <th>Jumlah Orderan Selesai</th>
                                    <th>Upah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->courier_name }}</td>
                                        <td>{{ $item->total_orders }}</td>
                                        <td>Rp {{ number_format($item->total_orders * $wagePerOrder, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Ganti Harga Upah -->
    <div class="modal fade" id="updateWageModal" tabindex="-1" aria-labelledby="updateWageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateWageModalLabel">Ganti Harga Upah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update-wage') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="wage" class="form-label">Harga Upah per Order</label>
                            <input type="number" class="form-control" id="wage" name="wage" value="{{ $wagePerOrder }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Harga</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatablesSimple').DataTable({
                responsive: true
            });
        });
    </script>

    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5em 1em;
            border-radius: 0.25rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #007bff;
            color: white;
        }

        /* Styling untuk tombol modal */
        .btn-primary {
            margin-top: 10px;
            padding: 0.5em 1em;
            font-size: 1em;
        }

        /* Styling untuk table DataTables */
        #datatablesSimple thead th {
            background-color: #f8f9fa;
            color: #495057;
        }

        #datatablesSimple tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Styling untuk modal */
        .modal-content {
            border-radius: 0.5rem;
        }
    </style>
</x-dashboard-layout>
