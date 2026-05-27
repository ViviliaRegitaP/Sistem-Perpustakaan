@extends('layouts.app')

@section('content')

<div class="card border-0 data-card">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3
                class="fw-bold mb-1"
                style="color:#2B2B2B;"
            >
                Denda Saya
            </h3>

            <p
                class="text-muted mb-0"
                style="font-size:15px;"
            >
                Informasi keterlambatan dan denda buku.
            </p>

        </div>

        <div
            class="d-flex align-items-center justify-content-center"
            style="
                width:58px;
                height:58px;
                border-radius:18px;
                background:#F3EEE8;
                color:#9B6B43;
                font-size:24px;
            "
        >
            <i class="bi bi-wallet2"></i>
        </div>

    </div>

    <div class="table-responsive">

        <table class="table align-middle custom-table">

            <thead>

                <tr>

                    <th>Buku</th>
                    <th>Terlambat</th>
                    <th>Denda</th>
                    <th class="text-center">Status</th>

                </tr>

            </thead>

            <tbody>

                @php
                    $adaDenda = false;
                @endphp

                @foreach($peminjamans as $pinjam)

                    @php

                        $telat = floor(
                            \Carbon\Carbon::parse(
                                $pinjam->tanggal_kembali
                            )->diffInDays(now(), false)
                        );

                        $denda = 0;

                        if($telat > 0){

                            $denda = $telat * 2000;

                            $adaDenda = true;

                        }

                    @endphp


                    @if($telat > 0)

                        <tr>

                            <td class="judul-buku">

                                {{ $pinjam->buku->judul }}

                            </td>

                            <td>

                                <span class="text-danger fw-semibold">

                                    {{ $telat }} hari

                                </span>

                            </td>

                            <td>

                                <span class="text-danger fw-bold">

                                    Rp{{ number_format($denda,0,',','.') }}

                                </span>

                            </td>

                            <td class="text-center">

                                <span
                                    class="badge rounded-pill status-badge"
                                    style="background:#DC2626;"
                                >
                                    Belum Bayar
                                </span>

                            </td>

                        </tr>

                    @endif

                @endforeach

                @if(!$adaDenda)

                    <tr>

                        <td
                            colspan="4"
                            class="empty-state"
                        >

                            <div class="empty-icon">
                                <i class="bi bi-emoji-smile"></i>
                            </div>

                            <div class="empty-title">
                                Tidak ada denda
                            </div>

                            <div class="empty-subtitle">
                                Semua peminjaman kamu masih aman ✨
                            </div>

                        </td>

                    </tr>

                @endif

            </tbody>

        </table>

    </div>

</div>

<style>

.data-card{
    border-radius:28px;
    background:#FFFFFF;
    border:1px solid #EEE7E1;
    box-shadow:0 10px 30px rgba(0,0,0,.03);
    padding:30px;
}

.custom-table{
    margin-bottom:0;
}

.custom-table thead th{
    background:#F4F6F0;
    border:none;
    padding:18px 22px;
    color:#374151;
    font-size:15px;
    font-weight:700;
}

.custom-table tbody td{
    padding:26px 22px;
    border-color:#F3EEE8;
    vertical-align:middle;
    font-size:15px;
    color:#2F3B2F;
}

.custom-table tbody tr:hover{
    background:#FCFCFA;
}

.judul-buku{
    font-weight:600;
    color:#2B2B2B;
    font-size:16px;
}

.status-badge{
    color:white;
    font-size:13px;
    font-weight:600;
    padding:10px 18px;
    min-width:130px;
}

.empty-state{
    text-align:center;
    padding:70px 20px !important;
}

.empty-icon{
    width:70px;
    height:70px;
    margin:auto;
    margin-bottom:18px;
    border-radius:20px;
    background:#F7F3EE;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#B07A4F;
    font-size:30px;
}

.empty-title{
    font-size:18px;
    font-weight:700;
    color:#2B2B2B;
    margin-bottom:6px;
}

.empty-subtitle{
    color:#7B7B7B;
    font-size:14px;
}

</style>

@endsection