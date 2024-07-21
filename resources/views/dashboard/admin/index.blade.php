<x-dashboard-layout>
    <h1 class="mt-4">Admin</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Admin</li>
    </ol>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <a class="btn btn-success mb-3" href="{{ route('admin.create') }}">Tambah Admin</a>
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Gender</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($users as $admin)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->telepon }}</td>
                                    <td>{{ $admin->gender }}</td>
                                    <td>{{ $admin->address }}</td>
                                    <td>
                                        <a href="{{ route('admin.edit', $admin) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <a href="{{ route('admin.destroy', $admin->id) }}"
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
