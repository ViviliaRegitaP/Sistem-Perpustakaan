@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-5">

    <div>

        <h2 class="fw-bold mb-2"
            style="
                color:#243020;
                font-size:34px;
            ">

            Kelola Peminjaman

        </h2>

        <p class="text-muted mb-0 fs-5">
            Kelola data peminjaman anggota perpustakaan.
        </p>

    </div>

</div>

{{-- ALERT SUCCESS --}}
@if(session('success'))

    <div class="alert alert-success border-0 rounded-4 mb-4">

        {{ session('success') }}

    </div>

@endif

{{-- CARD --}}
<div class="dashboard-card">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                Data Peminjaman
            </h4>

            <p class="text-muted mb-0">
                Semua data buku yang dipinjam anggota.
            </p>

        </div>

    </div>

    <div class="table-responsive">

        <table class="table align-middle">

            <thead>

                <tr>

                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($peminjamans as $pinjam)

                    <tr>

                        <td class="fw-semibold">

                            {{ $pinjam->user->name }}

                        </td>

                        <td>

                            {{ $pinjam->buku->judul }}

                        </td>

                        <td>

                            {{ $pinjam->tanggal_pinjam }}

                        </td>

                        <td>

                            {{ $pinjam->tanggal_kembali }}

                        </td>

                        <td>

                            @if($pinjam->status == 'Dikembalikan')

                                <span class="badge-status-kembali">

                                    Dikembalikan

                                </span>

                            @elseif(now()->gt($pinjam->tanggal_kembali))

                                <span class="badge-status-telat">

                                    Telat

                                </span>

                            @else

                                <span class="stok-badge">

                                    Dipinjam

                                </span>

                            @endif

                        </td>

                        <td>

                            @if($pinjam->status == 'Dipinjam')

                                <form
                                    action="/kembalikan/{{ $pinjam->id }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn-kembali"
                                    >

                                        Kembalikan

                                    </button>

                                </form>

                            @else

                                <span class="text-success fw-semibold">

                                    Sudah Kembali

                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="text-center py-5 text-muted"
                        >

                            Belum ada data peminjaman.

                        </td>

                    </tr>

                @endforelse

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

.stok-badge{

    background:rgba(124,79,56,.92);

    color:white;

    padding:8px 14px;

    border-radius:12px;

    font-weight:700;

}

.badge-status-telat{

    background:#DC3545;

    color:white;

    padding:8px 14px;

    border-radius:12px;

    font-weight:700;

}

.badge-status-kembali{

    background:#198754;

    color:white;

    padding:8px 14px;

    border-radius:12px;

    font-weight:700;

}

.btn-kembali{

    background:var(--gradient-btn);

    color:white;

    border:none;

    border-radius:12px;

    padding:10px 16px;

    font-weight:600;

}

.btn-kembali:hover{

    opacity:.92;

    color:white;

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