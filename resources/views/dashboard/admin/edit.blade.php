<x-dashboard-layout>
    <h1 class="mt-4">Edit Admin</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Edit Admin</li>
    </ol>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('admin.update', $user) }}" method="POST">
                            @csrf
                            @method('put')
                            <div class="col-12 mb-3">
                                <label for="name" class="form-label">Nama Admin</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Nama Admin" name="name" id="name" value="{{ $user->name }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Email" name="email" id="email" value="{{ $user->email }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="gender">Gender</label>
                                <select name="gender" id="gender"
                                    class="form-select @error('gender') is-invalid @enderror">
                                    <option selected disabled>-- Pilih Gender --</option>
                                    <option value="male" @selected(old('gender', $user->gender) == 'male')>Male</option>
                                    <option value="female" @selected(old('gender', $user->gender) == 'female')>Female</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="telepon" class="form-label">Telepon</label>
                                <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                                    placeholder="Telepon" name="telepon" id="telepon" value="{{ $user->telepon }}">
                                @error('telepon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="address">Alamat</label>
                                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Alamat">{{ $user->address }}</textarea>
                                @error('address')
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
