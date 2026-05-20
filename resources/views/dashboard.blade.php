@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

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
       style="
            background:linear-gradient(135deg,#6F8F6B,#97AC82);
            color:white;
            border-radius:16px;
            padding:14px 22px;
            font-weight:600;
            border:none;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            font-size:16px;
            line-height:1.2;
            text-decoration:none;
       ">
        <i class="bi bi-search" style="font-size:18px;"></i>
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
                            color:#6F8F6B;
                       ">
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
                            color:#6F8F6B;
                       ">
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
                            color:#6F8F6B;
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

                                <span
                                    class="badge"
                                    style="
                                        background:#6F8F6B;
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

                            <td colspan="5"
                                class="text-center py-5 text-muted">

                                Belum ada buku tersedia.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection