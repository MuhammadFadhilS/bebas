<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-5">
            <div class="card shadow">
                <form class="card-body" method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- LOGO --}}
                    <div class="text-center">
                        <img src="{{ asset('storage/photos/Logo_TA.png') }}"
                            class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3" width="200px"
                            alt="Logo">
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                            aria-describedby="emailHelp" placeholder="Email" name="email" value="{{ old('email') }}">
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

                    {{-- Lupa Password --}}
                    <div class="form-text text-end text-dark mb-3">
                        <a href="{{ route('password.request') }}" class="text-dark fw-bold"> Lupa Password?</a>
                    </div>

                    {{-- LOGIN BUTTON --}}
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>

                    {{-- REGISTER --}}
                    <div class="form-text text-center mb-5 text-dark">Belum punya akun? <a href="{{ route('register') }}"
                            class="text-dark fw-bold"> Daftar</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-guest-layout>

<!-- CSS tambahan (tambahkan ini ke file stylesheet Anda atau dalam <style> tag) -->
<style>
    .profile-image-pic {
        border: 2px solid #dee2e6; /* Warna border */
        background-color: #f8f9fa; /* Warna latar belakang */
        padding: 5px; /* Jarak antara border dan gambar */
    }

    /* Gambar harus responsif */
    .img-fluid {
        max-width: 100%; /* Pastikan gambar tidak lebih lebar dari container */
        height: auto; /* Pertahankan rasio aspek gambar */
    }
</style>
