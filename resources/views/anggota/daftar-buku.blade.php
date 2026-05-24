@extends('layouts.app')

@section('content')

<div class="card border-0 shadow-sm p-5" style="border-radius:32px;">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-5">

        <div>

            <h2 class="fw-bold mb-2">
                Daftar Buku
            </h2>

            <p class="text-muted mb-0">
                Cari dan lihat koleksi buku perpustakaan.
            </p>

        </div>

        <div
            class="rounded-4 d-flex align-items-center justify-content-center"
            style="
                width:70px;
                height:70px;
                background:#EEF2EA;
                color:var(--primary);
                font-size:28px;
            "
        >
            <i class="bi bi-book"></i>
        </div>

    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success border-0 rounded-4 mb-4">

            {{ session('success') }}

        </div>

    @endif


    {{-- ALERT ERROR --}}
    @if(session('error'))

        <div class="alert alert-danger border-0 rounded-4 mb-4">

            {{ session('error') }}

        </div>

    @endif

    {{-- SEARCH --}}
<form method="GET" action="/daftar-buku">

    <div class="mb-4">

        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Cari buku..."
            value="{{ request('search') }}"
        >

    </div>

    {{-- FILTER KATEGORI --}}
    <div class="d-flex gap-2 flex-wrap mb-4">

        {{-- SEMUA --}}
        <a
            href="/daftar-buku"
            class="btn-kategori
            {{ !request('kategori') ? 'active-kategori' : '' }}"
        >

            Semua

        </a>

        @foreach($kategoris as $kategori)

            <a
                href="/daftar-buku?kategori={{ $kategori->id }}"
                class="btn-kategori
                {{ request('kategori') == $kategori->id ? 'active-kategori' : '' }}"
            >

                {{ $kategori->nama_kategori ?? $kategori->nama }}

            </a>

        @endforeach

    </div>

</form>

    {{-- TABLE --}}
    <div class="table-responsive">

        <table class="table align-middle">

            <thead>

                <tr style="background:rgba(241,212,179,.38);">

                    <th class="py-3 border-0">Kode</th>
                    <th class="py-3 border-0">Judul</th>
                    <th class="py-3 border-0">Penulis</th>
                    <th class="py-3 border-0">Penerbit</th>
                    <th class="py-3 border-0">Tahun</th>
                    <th class="py-3 border-0">Kategori</th>
                    <th class="py-3 border-0">Stok</th>
                    <th class="py-3 border-0">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($bukus as $buku)

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
                            {{ $buku->tahun_terbit }}
                        </td>

                        <td>
                            {{ optional($buku->kategori)->nama_kategori ?? '-' }}
                        </td>

                        <td>

                            <span
                                class="badge rounded-pill px-3 py-2"
                                style="
                                    background:rgba(124,79,56,.92);
                                    font-size:14px;
                                "
                            >
                                {{ $buku->stok }}
                            </span>

                        </td>

                        <td>

                            <form action="/pinjam/{{ $buku->id }}" method="POST">

                                @csrf

                                <button
                                    type="submit"
                                    class="btn-pinjam">

                                    <i class="bi bi-journal-plus me-2"></i>
                                    Pinjam

                                </button>

                            </form>

                        </td>
                 </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="text-center py-5 text-muted"
                        >

                            Belum ada buku tersedia.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<style>

.btn-pinjam{

    background:var(--gradient-btn);

    color:white;

    border:none;

    border-radius:14px;

    padding:10px 18px;

    font-weight:600;

    display:inline-flex;

    align-items:center;

    gap:8px;

    transition:.2s;

}

.btn-pinjam:hover{

    opacity:.92;

    color:white;

}

.btn-kategori{

    padding:10px 18px;

    border-radius:14px;

    text-decoration:none;

    background:#F3F3F3;

    color:#333;

    font-weight:600;

}

.active-kategori{

    background:var(--gradient-btn);

    color:white !important;

    box-shadow:
    0 8px 18px rgba(124,79,56,.18);

}

</style>

@endsection