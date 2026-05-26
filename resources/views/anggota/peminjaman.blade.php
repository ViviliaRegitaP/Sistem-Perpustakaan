@extends('layouts.app')

@section('content')

<div class="card border-0 data-card">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3
                class="fw-bold mb-1"
                style="color:#2B2B2B;"
            >
                Peminjaman Saya
            </h3>

            <p
                class="text-muted mb-0"
                style="font-size:15px;"
            >
                Informasi buku yang sedang dipinjam.
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
            <i class="bi bi-journal-bookmark"></i>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="table-responsive">

        <table
            class="table align-middle custom-table"
        >

            <thead>

                <tr>

                    <th>Buku</th>
                    <th>Pinjam</th>
                    <th>Kembali</th>
                    <th>Sisa</th>
                    <th>Denda</th>
                    <th class="text-center">Status</th>

                </tr>

            </thead>

            <tbody>

                @forelse($peminjamans as $pinjam)

                    @php

                        $hari = floor(
                            \Carbon\Carbon::now()
                            ->diffInDays(
                                $pinjam->tanggal_kembali,
                                false
                            )
                        );

                        $denda = 0;

                        if($hari < 0){

                            $denda = abs($hari) * 2000;

                        }

                        $bg = match($pinjam->status) {

                            'Pending' => '#6B7280',

                            'Ditolak' => '#DC2626',

                            'Dipinjam' => '#9B6B43',

                            default => '#16A34A',

                        };

                    @endphp

                    <tr>

                        {{-- BUKU --}}
                        <td class="judul-buku">

                            {{ $pinjam->buku->judul }}

                        </td>

                        {{-- PINJAM --}}
                        <td class="text-muted">

                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}

                        </td>

                        {{-- KEMBALI --}}
                        <td class="text-muted">

                            {{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d M Y') }}

                        </td>

                        {{-- SISA --}}
                        <td>

                            @if($hari > 0)

                                <span class="text-success fw-semibold">
                                    {{ $hari }} hari
                                </span>

                            @elseif($hari == 0)

                                <span
                                    style="
                                        color:#D97706;
                                        font-weight:600;
                                    "
                                >
                                    Hari ini
                                </span>

                            @else

                                <span class="text-danger fw-semibold">
                                    Terlambat {{ abs($hari) }} hari
                                </span>

                            @endif

                        </td>

                        {{-- DENDA --}}
                        <td>

                            @if($denda > 0)

                                <span class="text-danger fw-bold">
                                    Rp{{ number_format($denda,0,',','.') }}
                                </span>

                            @else

                                <span class="text-muted">
                                    Rp0
                                </span>

                            @endif

                        </td>

                        {{-- STATUS --}}
                        <td class="text-center">

                            <span
                                class="badge rounded-pill status-badge"
                                style="
                                    background:{{ $bg }};
                                "
                            >
                                {{ $pinjam->status }}
                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="text-center py-5 text-muted"
                        >
                            Belum ada peminjaman buku.
                        </td>

                    </tr>

                @endforelse

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
    width:34%;
}

.status-badge{
    color:white;
    font-size:13px;
    font-weight:600;
    padding:10px 18px;
    min-width:125px;
}

</style>

@endsection