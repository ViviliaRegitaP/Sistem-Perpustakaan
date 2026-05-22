@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="dashboard-page">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">


    <div>

        <h3 class="fw-bold mb-1" style="color:#243020;">
            Dashboard Anggota
        </h3>

        <p class="text-muted mb-0">
            Selamat datang di Lentera Pustaka.
        </p>

    </div>

    <a href="{{ route('bukus.index') }}"
       class="btn-primary-custom">
        <i class="bi bi-search"></i>
        Cari Buku
    </a>


</div>


{{-- CARD --}}
<div class="row g-4 mb-4">

    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100"
             style="border-radius:24px;">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                    <p class="text-muted mb-2">
                        Total Buku
                    </p>

                    <h2 class="fw-bold"
                        style="color:#243020;">
                        {{ $totalBuku }}
                    </h2>

                </div>

                <div
                    style="
                        width:74px;
                        height:74px;
                        border-radius:22px;
                        background:#EEF3EA;

                        display:flex;
                        align-items:center;
                        justify-content:center;
                    "
                >
                    <i class="bi bi-book"
                       style="
                            font-size:34px;
                            color:var(--primary);
                       " >
                    </i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100"
             style="border-radius:24px;">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                    <p class="text-muted mb-2">
                        Total Stok
                    </p>

                    <h2 class="fw-bold"
                        style="color:#243020;">
                        {{ $totalStok }}
                    </h2>

                </div>

                <div
                    style="
                        width:74px;
                        height:74px;
                        border-radius:22px;
                        background:#EEF3EA;

                        display:flex;
                        align-items:center;
                        justify-content:center;
                    "
                >
                    <i class="bi bi-stack"
                       style="
                            font-size:34px;
                            color:var(--primary);
                       " >
                    </i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100"
             style="border-radius:24px;">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                    <p class="text-muted mb-2">
                        Buku Dipinjam
                    </p>

                    <h2 class="fw-bold"
                        style="color:#243020;">
                        0
                    </h2>

                </div>

                <div
                    style="
                        width:74px;
                        height:74px;
                        border-radius:22px;
                        background:#EEF3EA;

                        display:flex;
                        align-items:center;
                        justify-content:center;
                    "
                >
                    <i class="bi bi-journal-check"
                       style="
                            font-size:34px;
                            color:var(--primary);
                       ">
                    </i>
                </div>

            </div>

        </div>

    </div>

</div>

{{-- BUKU TERBARU --}}
<div class="card border-0 shadow-sm"
     style="border-radius:28px;">

    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h4 class="fw-bold mb-1"
                    style="color:#243020;">
                    Buku Tersedia
                </h4>

                <p class="text-muted mb-0">
                    Daftar buku yang tersedia di perpustakaan.
                </p>

            </div>

        </div>

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Kategori</th>
                        <th>Stok</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($recent as $buku)

                        <tr>

                            <td class="fw-semibold">
                                {{ $buku->kode_buku }}
                            </td>

                            <td>
                                {{ $buku->judul }}
                            </td>

                            <td>
                                {{ $buku->penulis }}
                            </td>

                            <td>
                                {{ $buku->penerbit }}
                            </td>


                            <td>
                                {{ optional($buku->kategori)->nama_kategori ?? '-' }}
                            </td>



                            <td>

                                <span
                                    class="badge"
                                    style="
                        background:rgba(124,79,56,.92);
                                        padding:10px 14px;
                                        border-radius:12px;
                                    "
                                >
                                    {{ $buku->stok }}
                                </span>

                            </td>


                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center py-5 text-muted">

                                Belum ada buku tersedia.


                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<style>
/* Dashboard Anggota - theme cream/beige (scoped) */

.dashboard-page a.btn-primary-custom,
.dashboard-page .btn-primary-custom{

    background: var(--gradient-btn);
    color:white;
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
    text-decoration:none;
}

a.btn-primary-custom:hover,
.btn-primary-custom:hover{
    transform: translateY(-1px);
    opacity:.95;
    color:white;
}


.dashboard-page .dashboard-card,
.dashboard-page .card{

    border-radius:30px;
}

/* Card panels inside dashboard */
.card{
    background: rgba(255,255,255,.92) !important;
    border:1px solid rgba(232,222,213,.9) !important;
    box-shadow: 0 12px 30px rgba(0,0,0,.04) !important;
}

/* Icon bg + text colors (inline override) */
.dashboard-page .badge{

    background: rgba(124,79,56,.92) !important;
    color:white !important;
    border-radius:999px !important;
    font-weight:700 !important;
}

.dashboard-page .table thead th{

    border:none !important;
    color:#2A211C !important;
    background: rgba(241,212,179,.38) !important;
    font-weight:850 !important;
}

.dashboard-page .table tbody td{

    border-color: rgba(232,222,213,.8) !important;
    color:#2A211C !important;
}


.dashboard-page .table tbody tr:hover{

    background:#FAF7F2;
}

</style>

</div>

@endsection

