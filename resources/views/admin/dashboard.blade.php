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
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Kategori</th>
                        <th>Stok</th>

                    </tr>

            </thead>

            <tbody>

                @foreach(\App\Models\Buku::orderBy('id', 'asc')->get() as $buku)

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
                            {{ $buku->penerbit }}
                        </td>

                        <td>
                            {{ $buku->tahun_terbit }}
                        </td>

                        <td>
                            {{ optional($buku->kategori)->nama_kategori ?? '-' }}
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
/* Admin Dashboard (tema cream/beige, coklat soft) */

a.btn-primary-custom{
    background: var(--gradient-btn);
    color:white;
    text-decoration:none;
    border:none;
    border-radius:18px;
    padding:14px 22px;
    font-weight:650;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    font-size:16px;
    line-height:1.2;
    transition: all .2s ease;
    box-shadow: 0 14px 28px rgba(124,79,56,.18);
}

a.btn-primary-custom:hover{
    transform: translateY(-1px);
    opacity:.95;
    color:white;
}

.dashboard-card{
    background: rgba(255,255,255,.9);
    border-radius:30px;
    padding:30px;
    border:1px solid rgba(232,222,213,.9);
    box-shadow: 0 12px 30px rgba(0,0,0,.04);
}

.dashboard-icon{
    width:74px;
    height:74px;
    border-radius:26px;
    background: rgba(241,212,179,.45);
    display:flex;
    align-items:center;
    justify-content:center;
    color: var(--primary);
    font-size:28px;
}

.card-label{
    color:#7A6A61;
    font-size:15px;
    margin-bottom:10px;
    font-weight:600;
}

.card-number{
    font-size:56px;
    font-weight:800;
    color:#2A211C;
}

.stok-badge{
    background: rgba(124,79,56,.92);
    color:white;
    padding:8px 14px;
    border-radius:999px;
    font-weight:700;
    letter-spacing: .2px;
}

table thead th{
    border:none !important;
    color:#7A6A61;
    font-weight:800;
}

table tbody td{
    padding:20px 14px !important;
    border:none !important;
    color:#2A211C;
}

table tbody tr{
    transition: background .2s ease, transform .2s ease;
}

table tbody tr:hover{
    background:#FAF7F2;
}

</style>

@endsection
