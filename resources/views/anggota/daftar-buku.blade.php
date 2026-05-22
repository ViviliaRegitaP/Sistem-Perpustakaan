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
                    <th class="py-3 border-0">Stok</th>

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

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
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

@endsection