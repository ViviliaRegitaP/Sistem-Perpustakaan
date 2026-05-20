@extends('layouts.guest')

@section('content')

<h1 class="login-title">
    Daftar
</h1>

<p class="login-subtitle">
    Buat akun untuk mengakses dashboard
</p>

<form method="POST" action="{{ route('register') }}">

    @csrf

    {{-- NAMA --}}
    <div class="mb-4">

        <label class="form-label">
            Nama
        </label>

        <div class="input-group-custom">

            <i class="bi bi-person"></i>

            <input
                type="text"
                name="name"
                class="form-control"
                placeholder="Masukkan nama"
                value="{{ old('name') }}"
                required
                autofocus
            >

        </div>

        @error('name')

            <div class="text-danger mt-2">
                {{ $message }}
            </div>

        @enderror

    </div>

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

    {{-- KONFIRMASI PASSWORD --}}
    <div class="mb-4">

        <label class="form-label">
            Konfirmasi Password
        </label>

        <div class="input-group-custom">

            <i class="bi bi-shield-lock"></i>

            <input
                type="password"
                name="password_confirmation"
                class="form-control"
                placeholder="Ulangi password"
                required
            >

        </div>

    </div>

    {{-- BUTTON --}}
    <button
        type="submit"
        class="btn-login"
    >

        <i class="bi bi-person-plus me-2"></i>

        Daftar

    </button>

    {{-- LOGIN --}}
    <div class="register-text">

        Sudah punya akun?

        <a href="{{ route('login') }}">
            Login
        </a>

    </div>

</form>

@endsection