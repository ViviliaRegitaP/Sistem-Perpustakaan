@extends('layouts.guest')

@section('content')

<style>

    /* CARD AGAR TIDAK KEPOTONG */
    .login-card{
        width:100%;
        max-width:520px;
        margin:auto;
        padding:45px 40px;
    }

    /* TITLE */
    .login-title{
        text-align:center;
        margin-bottom:10px;
    }

    .login-subtitle{
        text-align:center;
        margin-bottom:32px;
    }

    /* FORM */
    .form-label{
        font-weight:600;
        margin-bottom:10px;
        color:#2A211C;
    }

    .input-group-custom{
        position:relative;
    }

    .input-group-custom i{
        position:absolute;
        top:50%;
        left:18px;
        transform:translateY(-50%);
        color:#8B8B8B;
        z-index:5;
    }

    .form-control{
        height:58px;
        border-radius:16px;
        padding-left:50px;
        border:1px solid #E8DED5;
        background:#fff;
    }

    .form-control:focus{
        border-color:#7C4F38;
        box-shadow:
            0 0 0 4px rgba(124,79,56,.10);
    }

    /* BUTTON */
    .btn-login{
        width:100%;
        height:58px;
        border:none;
        border-radius:16px;

        background:linear-gradient(
            135deg,
            #7C4F38,
            #B17457
        );

        color:white;
        font-weight:600;
        font-size:15px;

        transition:.3s ease;
    }

    .btn-login:hover{
        transform:translateY(-2px);

        box-shadow:
            0 12px 24px rgba(124,79,56,.20);
    }

    /* LOGIN TEXT */
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

    /* RESPONSIVE */
    @media(max-width:768px){

        .login-card{
            padding:35px 24px;
            border-radius:24px;
        }

        .login-title{
            font-size:38px;
        }

    }

</style>

<div class="login-card">

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

</div>

@endsection
