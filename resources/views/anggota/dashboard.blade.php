@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-5">

    <div>

        <h2 class="fw-bold mb-2"
            style="
                color:#243020;
                font-size:34px;
            ">

            Dashboard Anggota

        </h2>

        <p class="text-muted mb-0 fs-5">
            Selamat datang kembali di Lentera Pustaka ✨
        </p>

    </div>

</div>

{{-- CARD TOTAL --}}
<div class="dashboard-card mb-4">

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <p class="card-label">
                Total Buku Tersedia
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

        {{-- YANG DIBENERIN CUMA INI --}}
        <a href="{{ route('bukus.index') }}"
           class="btn-lihat">

            <i class="bi bi-book me-2"></i>
            Lihat Semua

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

    color:var(--primary);

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

.btn-lihat{

    background:#A86E4D;

    color:white;

    text-decoration:none;

    border:none;

    border-radius:16px;

    padding:14px 22px;

    font-weight:700;

    display:inline-flex;
    align-items:center;
    justify-content:center;

    gap:10px;

    font-size:16px;
    line-height:1.2;

    transition:.2s;

    box-shadow:
    0 8px 18px rgba(124,79,56,.18);

}

.btn-lihat:hover{

    background:#9A6244;

    color:white;

    transform:translateY(-1px);

}

.stok-badge{

    background:rgba(124,79,56,.92);

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