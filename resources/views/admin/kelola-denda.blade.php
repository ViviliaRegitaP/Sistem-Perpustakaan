@extends('layouts.app')

@section('content')

<div class="card border-0 denda-card">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1 title-text">
                Kelola Denda
            </h2>

            <p class="subtitle-text mb-0">
                Kelola keterlambatan dan pembayaran anggota.
            </p>

        </div>

        <div class="icon-box">
            <i class="bi bi-wallet2"></i>
        </div>

    </div>

    {{-- ALERT --}}
    @if(session('success'))

        <div class="alert alert-success rounded-4 border-0 mb-4">
            {{ session('success') }}
        </div>

    @endif

    {{-- TABLE --}}
    <div class="table-responsive">

        <table class="table align-middle custom-table">

            <thead>

                <tr>

                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Terlambat</th>
                    <th>Total Denda</th>
                    <th>Dibayar</th>
                    <th>Sisa</th>
                    <th>Status</th>
                    <th width="340">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @php
                    $adaDenda = false;
                @endphp

                @foreach($peminjamans as $pinjam)

                    @php

                        $hari = floor(
                            \Carbon\Carbon::now()
                                ->diffInDays(
                                    $pinjam->tanggal_kembali,
                                    false
                                )
                        );

                        $telat = abs($hari);

                    @endphp

                    @if($telat > 0)

                        @php

                            $adaDenda = true;

                            $fine = $pinjam->fine;

                            $denda = $fine?->jumlah_denda ?? ($telat * 2000);

                            $dibayar = $fine?->dibayar ?? 0;

                            $sisa = $fine?->sisa_denda ?? $denda;

                            $fineStatus = $fine?->status ?? 'UNPAID';

                            $statusText = match($fineStatus){
                                'UNPAID' => 'Belum Bayar',
                                'PARTIALLY_PAID' => 'Dicicil',
                                'PAID' => 'Lunas',
                                default => 'Belum Bayar',
                            };

                            $badgeStyle = match($fineStatus){
                                'UNPAID' => 'background:#FEE2E2; color:#DC2626;',
                                'PARTIALLY_PAID' => 'background:#FFEDD5; color:#B45309;',
                                'PAID' => 'background:#DCFCE7; color:#16A34A;',
                                default => 'background:#FEE2E2; color:#DC2626;',
                            };

                        @endphp

                        <tr>

                            {{-- ANGGOTA --}}
                            <td class="fw-semibold">
                                {{ $pinjam->user->name }}
                            </td>

                            {{-- BUKU --}}
                            <td class="book-title">
                                {{ $pinjam->buku->judul }}
                            </td>

                            {{-- TERLAMBAT --}}
                            <td>
                                <span class="late-text">
                                    {{ $telat }} Hari
                                </span>
                            </td>

                            {{-- TOTAL DENDA --}}
                            <td>
                                <span class="fine-text">
                                    Rp{{ number_format($denda,0,',','.') }}
                                </span>
                            </td>

                            {{-- DIBAYAR --}}
                            <td>
                                Rp{{ number_format($dibayar,0,',','.') }}
                            </td>

                            {{-- SISA --}}
                            <td>
                                Rp{{ number_format($sisa,0,',','.') }}
                            </td>

                            {{-- STATUS --}}
                            <td>

                                <span
                                    class="status-badge"
                                    style="{{ $badgeStyle }}"
                                >
                                    {{ $statusText }}
                                </span>

                            </td>

                            {{-- AKSI --}}
                            <td>

                                @if($fine)

                                    <div class="d-flex flex-column gap-2">

                                        {{-- LUNAS --}}
                                        <form
                                            method="POST"
                                            action="{{ route('denda.update', $fine->fines_id) }}"
                                        >

                                            @csrf
                                            @method('PUT')

                                            <input
                                                type="hidden"
                                                name="status"
                                                value="PAID"
                                            >

                                            <button
                                                type="submit"
                                                class="btn action-btn lunas-btn"
                                            >
                                                Lunas
                                            </button>

                                        </form>

                                        {{-- BELUM BAYAR --}}
                                        <form
                                            method="POST"
                                            action="{{ route('denda.update', $fine->fines_id) }}"
                                        >

                                            @csrf
                                            @method('PUT')

                                            <input
                                                type="hidden"
                                                name="status"
                                                value="UNPAID"
                                            >

                                            <button
                                                type="submit"
                                                class="btn action-btn unpaid-btn"
                                            >
                                                Belum Bayar
                                            </button>

                                        </form>

                                        {{-- CICIL --}}
                                        <form
                                            method="POST"
                                            action="{{ route('denda.update', $fine->fines_id) }}"
                                        >

                                            @csrf
                                            @method('PUT')

                                            <input
                                                type="hidden"
                                                name="status"
                                                value="PARTIALLY_PAID"
                                            >

                                            <div class="d-flex gap-2">

                                                <input
                                                    type="number"
                                                    name="dibayar"
                                                    min="1"
                                                    max="{{ $denda }}"
                                                    required
                                                    class="form-control cicil-input"
                                                    placeholder="Nominal"
                                                >

                                                <button
                                                    type="submit"
                                                    class="btn action-btn cicil-btn"
                                                >
                                                    Cicil
                                                </button>

                                            </div>

                                        </form>

                                    </div>

                                @else

                                    <span class="text-muted">
                                        Belum ada data denda
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endif

                @endforeach

                {{-- EMPTY --}}
                @if(!$adaDenda)

                    <tr>

                        <td colspan="8">

                            <div class="empty-state">

                                <div class="empty-icon">
                                    <i class="bi bi-check-circle"></i>
                                </div>

                                <h5 class="mb-2">
                                    Tidak Ada Denda
                                </h5>

                                <p class="mb-0">
                                    Semua anggota mengembalikan buku tepat waktu.
                                </p>

                            </div>

                        </td>

                    </tr>

                @endif

            </tbody>

        </table>

    </div>

</div>

<style>

.denda-card{
    border-radius:30px;
    background:#FFFFFF;
    padding:32px;
    border:1px solid #EEE7DF;
    box-shadow:0 8px 30px rgba(0,0,0,.03);
}

/* HEADER */

.title-text{
    color:#243224;
    font-size:26px;
}

.subtitle-text{
    color:#7A7A7A;
    font-size:15px;
}

.icon-box{
    width:64px;
    height:64px;
    border-radius:20px;
    background:#F5EFE8;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#A56A3D;
    font-size:28px;
}

/* TABLE */

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
    padding:24px 22px;
    border-color:#F1ECE6;
    vertical-align:middle;
    color:#2F3B2F;
    font-size:15px;
}

.custom-table tbody tr:hover{
    background:#FCFCFA;
}

/* TEXT */

.book-title{
    font-weight:600;
    color:#2B2B2B;
}

.late-text{
    color:#DC2626;
    font-weight:700;
}

.fine-text{
    color:#B45309;
    font-weight:700;
}

/* STATUS */

.status-badge{
    padding:10px 18px;
    border-radius:999px;
    font-size:13px;
    font-weight:700;
    display:inline-block;
}

/* BUTTON */

.action-btn{
    border:none;
    border-radius:999px;
    font-weight:700;
    padding:10px 18px;
    width:100%;
}

.lunas-btn{
    background:#DCFCE7;
    color:#16A34A;
}

.unpaid-btn{
    background:#FEE2E2;
    color:#DC2626;
}

.cicil-btn{
    background:#FFEDD5;
    color:#B45309;
    min-width:100px;
}

.cicil-input{
    border-radius:999px;
    font-weight:700;
}

/* EMPTY */

.empty-state{
    padding:70px 20px;
    text-align:center;
}

.empty-icon{
    width:70px;
    height:70px;
    margin:auto;
    margin-bottom:18px;
    border-radius:50%;
    background:#F0FDF4;
    color:#16A34A;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:32px;
}

.empty-state h5{
    color:#2B2B2B;
    font-weight:700;
}

.empty-state p{
    color:#8A8A8A;
    font-size:15px;
}

</style>

@endsection
