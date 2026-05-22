@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-5">

    <div>

        <h2 class="fw-bold mb-2"
            style="
                color:#243020;
                font-size:34px;
            ">

            Dashboard Admin

        </h2>

        <p class="text-muted mb-0 fs-5">
            Kelola data buku perpustakaan.
        </p>

    </div>

    <a href="{{ route('bukus.create') }}"
       class="btn-primary-custom">

        <i class="bi bi-plus-circle me-2"></i>
        Tambah Buku

    </a>

</div>

{{-- CARD --}}
<div class="row g-4 mb-4">

    {{-- TOTAL BUKU --}}
    <div class="col-md-6">

        <div class="dashboard-card">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <p class="card-label">
                        Total Buku
                    </p>

                    <h1 class="card-number">
                        {{ \App\Models\Buku::count() }}
                    </h1>

                </div>

                <div class="dashboard-icon">
                    <i class="bi bi-book-half"></i>
                </div>

            </div>

        </div>

    </div>

    {{-- TOTAL STOK --}}
    <div class="col-md-6">

        <div class="dashboard-card">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <p class="card-label">
                        Total Stok
                    </p>

                    <h1 class="card-number">
                        {{ \App\Models\Buku::sum('stok') }}
                    </h1>

                </div>

                <div class="dashboard-icon">
                    <i class="bi bi-stack"></i>
                </div>

            </div>

        </div>

    </div>

</div>

{{-- BUKU TERBARU --}}
<div class="dashboard-card">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                Data Buku Terbaru
            </h4>

            <p class="text-muted mb-0">
                Kelola data buku perpustakaan.
            </p>

        </div>

        <a href="{{ route('bukus.index') }}"
           class="btn-primary-custom">

            <i class="bi bi-book me-2"></i>
            Kelola Buku

        </a>

    </div>

    <div class="table-responsive">

        <table class="table align-middle">

            <thead>

                <tr>

                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Stok</th>

                </tr>

            </thead>

            <tbody>

                @foreach(\App\Models\Buku::latest()->take(5)->get() as $buku)

                    <tr>

                        <td class="fw-semibold">
                            {{ $buku->kode_buku }}
                        </td>

                        <td class="fw-bold">
                            {{ $buku->judul }}
                        </td>

                        <td>
                            {{ $buku->penulis }}
                        </td>

                        <td>

                            <span class="stok-badge">

                                {{ $buku->stok }}

                            </span>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

<style>

.dashboard-card{

    background:white;

    border-radius:28px;

    padding:30px;

    border:1px solid #EEF1EB;

    box-shadow:
    0 10px 30px rgba(0,0,0,.03);

}

.dashboard-icon{

    width:70px;
    height:70px;

    border-radius:22px;

    background:#EEF2E8;

    display:flex;
    align-items:center;
    justify-content:center;

    color:#6F8F6B;

    font-size:28px;

}

.card-label{

    color:#7A8575;

    font-size:15px;

    margin-bottom:10px;

}

.card-number{

    font-size:54px;

    font-weight:800;

    color:#243020;

}

.btn-primary-custom{

    background:linear-gradient(
        135deg,
        #6F8F6B,
        #97AC82
    );

    color:white;

    text-decoration:none;

    border:none;

    border-radius:16px;

    padding:14px 22px;

    font-weight:600;

    display:inline-flex;
    align-items:center;
    justify-content:center;

    gap:10px;

    font-size:16px;
    line-height:1.2;

    transition:.2s;

}

.btn-primary-custom:hover{

    opacity:.92;
    color:white;

}


.stok-badge{

    background:#6F8F6B;

    color:white;

    padding:8px 14px;

    border-radius:12px;

    font-weight:700;

}

table thead th{

    border:none !important;

    color:#7A8575;

    font-weight:700;

}

table tbody td{

    padding:20px 14px !important;

    border:none !important;

}

</style>

@endsection