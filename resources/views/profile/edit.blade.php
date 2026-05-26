@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-5">

    <div>

        <h2 class="fw-bold mb-2"
            style="
                color:#243020;
                font-size:34px;
            ">

            Edit Profil

        </h2>

        <p class="text-muted mb-0 fs-5">
            Perbarui informasi akun kamu.
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

                @if(Auth::user()->email == 'admin@perpus.com')

                    <div class="small" style="color:#A56A43; font-weight:700; margin-top:8px;">
                        Admin tidak dapat mengedit profil.
                    </div>

                @else

                    <button
                        type="submit"
                        class="save-btn">

                        <i class="bi bi-check-circle me-2"></i>

                        Simpan Perubahan

                    </button>

                @endif


            </form>

        </div>

    </div>

</div>

<style>
    /* Tema Edit Profil - konsisten dengan Login Lentera Pustaka */

    .profile-side-card,
    .profile-form-card{
        background: rgba(247,243,238,.9);
        border-radius:34px;
        padding:40px 30px;
        text-align:center;
        border:1px solid rgba(165,106,67,.18);
        box-shadow: 0 10px 28px rgba(0,0,0,.03);
        backdrop-filter: blur(10px);
    }

    .profile-side-card{
        padding:40px 30px;
    }

    .profile-avatar{
        width:110px;
        height:110px;
        margin:auto;
        margin-bottom:25px;
        border-radius:32px;
        background: linear-gradient(135deg,#A56A43 0%, #C8845A 100%);
        display:flex;
        align-items:center;
        justify-content:center;
        color:#F7F3EE;
        font-size:46px;
        box-shadow: 0 18px 32px rgba(165,106,67,.18);
    }

    .profile-badge{
        background: rgba(234,220,203,.65);
        color:#A56A43;
        padding:12px 18px;
        border-radius:16px;
        font-weight:700;
        display:inline-block;
        border:1px solid rgba(165,106,67,.18);
    }

    .profile-form-card{
        padding:40px;
        text-align:left;
    }

    .custom-input{
        height:58px;
        border-radius:18px;
        border:1.5px solid rgba(165,106,67,.22);
        padding:0 20px;
        font-size:16px;
        background: rgba(255,255,255,.75);
    }

    .custom-input:focus{
        border-color:#A56A43;
        box-shadow:none;
        background: rgba(255,255,255,.9);
    }

    .save-btn{
        height:58px;
        border:none;
        padding:0 28px;
        border-radius:18px;
        background: linear-gradient(135deg,#A56A43 0%, #C8845A 100%);
        color:#F7F3EE;
        font-weight:800;
        font-size:16px;
        transition:.2s;
        width: fit-content;
        display:flex;
        align-items:center;
        justify-content:center;
        gap:10px;
    }

    .save-btn:hover{
        background: linear-gradient(135deg,#8E5636 0%, #B9744B 100%);
        transform: translateY(-1px);
        color:#F7F3EE;
    }

    /* Sidebar active warna coklat untuk konsistensi tema */
    .menu a.active{
        background: linear-gradient(135deg,#A56A43 0%, #C8845A 100%);
        color:white;
        box-shadow: 0 18px 32px rgba(165,106,67,.22);
    }

    .menu a:hover{
        background: rgba(165,106,67,.12);
        color:#2A211C;
    }

</style>

@endsection

