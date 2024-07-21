<x-dashboard-layout>
    <h1 class="mt-4">Kurir</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Kurir</li>
    </ol>
    <div class="row mb-5">
        <div class="col">
            <a class="btn btn-primary mb-3" href="{{ route('courier.create') }}">Tambah Kurir</a>

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
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Gender</th>
                                <th>Telepon</th>
                                <th>Nama Kendaraan</th>
                                <th>Nomor Kendaraan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($couriers as $courier)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        <img src="/storage/photos/{{ $courier->photo }}" width="50">
                                    </td>
                                    <td>{{ $courier->name }}</td>
                                    <td>{{ $courier->gender }}</td>
                                    <td>{{ $courier->telepon }}</td>
                                    <td>{{ $courier->motor }}</td>
                                    <td>{{ $courier->no_motor }}</td>
                                    <td>
                                        <a href="{{ route('courier.edit', $courier) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <a href="{{ route('courier.destroy', $courier) }}"
                                            class="btn btn-sm btn-danger"
                                            onclick="confirm('Yakin ingin hapus data?')">Hapus</a>
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
