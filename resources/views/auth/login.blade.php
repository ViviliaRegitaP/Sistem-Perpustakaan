@extends('layouts.guest')

@section('content')

<style>

    /* TITLE */
    .login-title{
        text-align:center;
        margin-bottom:10px;
    }

    .login-subtitle{
        text-align:center;
        margin-bottom:32px;
    }

    /* REGISTER TEXT */
    .register-text{
        text-align:center;
        margin-top:24px;
        font-size:15px;
        color:#7A6A61;
        font-weight:500;
    }

    .register-text a{
        color:#7C4F38;
        text-decoration:none;
        font-weight:700;
        transition:.3s ease;
        position:relative;
    }

    .register-text a:hover{
        color:#5E3928;
    }

    .register-text a::after{
        content:'';
        position:absolute;
        left:0;
        bottom:-3px;
        width:100%;
        height:2px;
        background:#7C4F38;
        border-radius:10px;
        transform:scaleX(0);
        transition:.3s ease;
    }

    .register-text a:hover::after{
        transform:scaleX(1);
    }

</style>

<h1 class="login-title">
    Selamat datang
</h1>

<p class="login-subtitle">
    Masuk untuk mengakses Lentera Pustaka
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

        <a
            href="{{ route('password.request') }}"
            class="forgot-link"
        >
            Lupa password?
        </a>

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
                Daftar Sekarang
            </a>

        </div>

    @endif

</form>

@endsection
