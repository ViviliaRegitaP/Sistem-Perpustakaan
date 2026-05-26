@extends('layouts.guest')

@section('content')

<style>

    body{
        overflow-x:hidden;
    }

    /* CARD */
    .login-card{

        width:100%;
        max-width:400px;

        margin:auto;

        padding:32px 28px;

        background:rgba(255,255,255,.88);

        backdrop-filter:blur(18px);

        border-radius:28px;

        border:1px solid rgba(255,255,255,.4);

        box-shadow:
            0 15px 35px rgba(0,0,0,.06);
    }

    /* TITLE */
    .login-title{

        text-align:center;

        margin-bottom:24px;

        font-size:32px;

        font-weight:800;

        color:#2A211C;
    }

    /* LABEL */
    .form-label{

        font-weight:700;

        margin-bottom:8px;

        color:#2A211C;

        font-size:14px;
    }

    /* INPUT */
    .input-group-custom{
        position:relative;
    }

    .input-group-custom i{

        position:absolute;

        top:50%;
        left:16px;

        transform:translateY(-50%);

        color:#A58D7F;

        z-index:5;

        font-size:14px;
    }

    .form-control{

        height:52px;

        border-radius:14px;

        padding-left:46px;

        border:1px solid #E8DED5;

        background:#fff;

        font-size:14px;

        transition:.3s ease;
    }

    .form-control:focus{

        border-color:#8B5E3C;

        box-shadow:
            0 0 0 4px rgba(139,94,60,.10);
    }

    /* BUTTON */
    .btn-login{

        width:100%;

        height:52px;

        border:none;

        border-radius:14px;

        background:linear-gradient(
            135deg,
            #8B5E3C,
            #B17457
        );

        color:white;

        font-weight:700;

        font-size:15px;

        transition:.3s ease;
    }

    .btn-login:hover{

        transform:translateY(-2px);

        box-shadow:
            0 10px 22px rgba(139,94,60,.18);
    }

    /* LOGIN TEXT */
    .register-text{

        text-align:center;

        margin-top:20px;

        font-size:14px;

        color:#7A6A61;
    }

    .register-text a{

        color:#8B5E3C;

        text-decoration:none;

        font-weight:700;
    }

    .register-text a:hover{
        text-decoration:underline;
    }

    /* ERROR */
    .text-danger{
        font-size:13px;
    }

    /* MOBILE */
    @media(max-width:768px){

        .login-card{

            padding:28px 22px;

            border-radius:22px;
        }

        .login-title{
            font-size:28px;
        }

    }

</style>

<div class="login-card">

    {{-- TITLE --}}
    <h2 class="login-title">
        Daftar Akun
    </h2>

    <form method="POST" action="{{ route('register') }}">

        @csrf

        {{-- NAMA --}}
        <div class="mb-3">

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
        <div class="mb-3">

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
        <div class="mb-3">

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