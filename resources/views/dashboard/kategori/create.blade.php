<x-dashboard-layout>
    <h1 class="mt-4">Tambah Kategori</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Tambah Kategori</li>
    </ol>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('category.store') }}" method="POST">
                            @csrf
                            <div class="col-12 mb-3">
                                <label for="name" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Nama Kategori" name="name" id="name">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="description" class="form-label">Keterangan</label>
                                <input type="text" class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Keterangan" name="description" id="description">
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
