@extends('layouts.guest')

@section('content')

<h1 class="login-title">
    Masuk
</h1>

<p class="login-subtitle">
    Login untuk masuk ke dashboard
</p>

<form method="POST" action="{{ route('login') }}">

    @csrf

    {{-- EMAIL --}}
    <div class="mb-4">

        <label class="form-label">
            Email
        </label>

        <div class="input-group-custom">

            <i class="bi bi-envelope"></i>

            <input
                type="email"
                name="email"
                class="form-control"
                placeholder="Masukkan email"
                value="{{ old('email') }}"
                required
                autofocus
            >

        </div>

        @error('email')

            <div class="text-danger mt-2">
                {{ $message }}
            </div>

        @enderror

    </div>

    {{-- PASSWORD --}}
    <div class="mb-4">

        <label class="form-label">
            Password
        </label>

        <div class="input-group-custom">

            <i class="bi bi-key"></i>

            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Masukkan password"
                required
            >

        </div>

        @error('password')

            <div class="text-danger mt-2">
                {{ $message }}
            </div>

        @enderror

    </div>

    {{-- REMEMBER --}}
    <div class="remember-wrap">

        <div class="form-check">

            <input
                class="form-check-input"
                type="checkbox"
                name="remember"
                id="remember_me"
            >

            <label
                class="form-check-label"
                for="remember_me"
            >
                Ingat saya
            </label>

        </div>

        @if (Route::has('password.request'))

            <a
                href="{{ route('password.request') }}"
                class="forgot-link"
            >
                Lupa password?
            </a>

        @endif

    </div>

    {{-- BUTTON LOGIN --}}
    <button
        type="submit"
        class="btn-login"
    >

        <i class="bi bi-box-arrow-in-right me-2"></i>

        Login

    </button>

    {{-- REGISTER --}}
    @if (Route::has('register'))

        <div class="register-text">

            Belum punya akun?

            <a href="{{ route('register') }}">
                Daftar
            </a>

        </div>

    @endif

</form>

@endsection