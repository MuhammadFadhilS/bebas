<x-dashboard-layout>
    <h1 class="mt-4">Kategori</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Kategori</li>
    </ol>
    <div class="row">
        <div class="col">
            <a class="btn btn-primary mb-3" href="{{ route('category.create') }}">Tambah Kategori</a>

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
                                <th>Nama Kategori</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>
                                        <a href="{{ route('category.edit', $category) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <a href="{{ route('category.destroy', $category) }}"
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
