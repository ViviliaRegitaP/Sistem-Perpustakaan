@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-5">

    <div>

        <h2 class="fw-bold mb-2"
            style="
                color:#243020;
                font-size:34px;
            ">

            Profil Saya

        </h2>

        <p class="text-muted mb-0 fs-5">
            Kelola informasi akun kamu.
        </p>

    </div>

</div>

<div class="row g-4">

    {{-- PROFILE CARD --}}
    <div class="col-lg-4">

        <div class="profile-side-card">

            <div class="profile-avatar">

                <i class="bi bi-person"></i>

            </div>

            <h3 class="fw-bold mb-2">
                {{ Auth::user()->name }}
            </h3>

            <p class="text-muted mb-4">
                {{ Auth::user()->email }}
            </p>

            <div class="profile-badge">
                Anggota Lentera Pustaka
            </div>

        </div>

    </div>

    {{-- FORM --}}
    <div class="col-lg-8">

        <div class="profile-form-card">

            <h4 class="fw-bold mb-4">
                Edit Informasi
            </h4>

            <form method="POST"
                  action="{{ route('profile.update') }}">

                @csrf
                @method('PATCH')

                {{-- NAMA --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Nama
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', auth()->user()->name) }}"
                        class="form-control custom-input"
                        required
                    >

                </div>

                {{-- EMAIL --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', auth()->user()->email) }}"
                        class="form-control custom-input"
                        required
                    >

                </div>

                {{-- BUTTON --}}
                <button
                    type="submit"
                    class="save-btn">

                    <i class="bi bi-check-circle me-2"></i>

                    Simpan Perubahan

                </button>

            </form>

        </div>

    </div>

</div>

<style>

.profile-side-card{

    background:white;

    border-radius:30px;

    padding:40px 30px;

    text-align:center;

    border:1px solid #EEF1EB;

    box-shadow:
    0 10px 30px rgba(0,0,0,.03);

}

.profile-avatar{

    width:110px;
    height:110px;

    margin:auto;
    margin-bottom:25px;

    border-radius:30px;

    background:linear-gradient(
        135deg,
        #6F8F6B,
        #97AC82
    );

    display:flex;
    align-items:center;
    justify-content:center;

    color:white;

    font-size:46px;

}

.profile-badge{

    background:#EEF2E8;

    color:#6F8F6B;

    padding:12px 18px;

    border-radius:16px;

    font-weight:600;

    display:inline-block;

}

.profile-form-card{

    background:white;

    border-radius:30px;

    padding:40px;

    border:1px solid #EEF1EB;

    box-shadow:
    0 10px 30px rgba(0,0,0,.03);

}

.custom-input{

    height:58px;

    border-radius:18px;

    border:1.5px solid #DCE3D5;

    padding:0 20px;

    font-size:16px;

}

.custom-input:focus{

    border-color:#6F8F6B;

    box-shadow:none;

}

.save-btn{

    height:58px;

    border:none;

    padding:0 28px;

    border-radius:18px;

    background:linear-gradient(
        135deg,
        #6F8F6B,
        #97AC82
    );

    color:white;

    font-weight:700;

    font-size:16px;

    transition:.2s;

}

.save-btn:hover{

    opacity:.92;

}

</style>

@endsection