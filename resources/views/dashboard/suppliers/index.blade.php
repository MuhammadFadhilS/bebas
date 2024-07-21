<x-dashboard-layout>
    <h1 class="mt-4">Data Supplier</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Data Supplier</li>
    </ol>
    <div class="row mb-5">
        <div class="col">
            <a class="btn btn-primary mb-3" href="{{ route('suppliers.create') }}">Tambah Supplier</a>

            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <table id="datatablesSimple" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>No Telp</th>
                                <th>Nama Produk</th>
                                <th>Merk Produk</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Expired</th>
                                <th>Bukti Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suppliers as $supplier)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->phone }}</td>
                                <td>{{ $supplier->product_name }}</td>
                                <td>{{ $supplier->product_brand }}</td>
                                <td>{{ $supplier->quantity }}</td>
                                <td>{{ $supplier->price }}</td>
                                <td>{{ \Carbon\Carbon::parse($supplier->expired)->format('d-m-Y') }}</td> <!-- Menggunakan Carbon untuk memformat tanggal -->
                                <td>
                                    @if($supplier->payment_proof)
                                    <img src="{{ asset('storage/photos/' . $supplier->payment_proof) }}" alt="Bukti Pembayaran" width="50" height="50">
                                    @else
                                    Tidak ada bukti
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus data?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
