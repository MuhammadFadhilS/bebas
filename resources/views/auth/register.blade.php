<x-guest-layout>
    <div class="row justify-content-center align-items-center min-vh-100 my-3">
        <div class="col-md-5">
            <div class="card shadow">
                <form class="card-body p-lg-5" method="POST" action="{{ route('register') }}">
                    @csrf
                    {{-- LOGO --}}
                    <div class="text-center">
                        <img src="https://cdn.pixabay.com/photo/2016/03/31/19/56/avatar-1295397__340.png"
                            class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3" width="200px"
                            alt="profile">
                    </div>

                    {{-- NAME --}}
                    <div class="mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                            placeholder="Email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" placeholder="Password" name="password">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- LOGIN BUTTON --}}
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-dark">Register</button>
                    </div>

                    {{-- LOGIN --}}
                    <div id="emailHelp" class="form-text text-center mb-5 text-dark">Sudah punya akun? <a
                            href="{{ route('login') }}" class="text-dark fw-bold"> Login</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

</x-guest-layout>
