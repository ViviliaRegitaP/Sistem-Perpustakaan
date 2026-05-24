@extends('layouts.app')

@section('content')

<div class="card border-0 shadow-sm p-5"
     style="border-radius:32px;">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-5">

        <div>

            <h2 class="fw-bold mb-2">
                Peminjaman Saya
            </h2>

            <p class="text-muted mb-0">
                Daftar buku yang sedang dipinjam.
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
            <i class="bi bi-journal-text"></i>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="table-responsive">

        <table class="table align-middle">

            <thead>

                <tr style="background:rgba(241,212,179,.38);">

                    <th class="py-3 border-0">Judul Buku</th>
                    <th class="py-3 border-0">Tanggal Pinjam</th>
                    <th class="py-3 border-0">Status</th>

                </tr>

            </thead>

            <tbody>

                @forelse($peminjamans as $pinjam)

                    <tr>

                        <td class="fw-semibold">

                            {{ $pinjam->buku->judul }}

                        </td>

                        <td>

                            {{ $pinjam->tanggal_pinjam }}

                        </td>

                        <td>

                            <span
                                class="badge rounded-pill px-3 py-2"
                                style="
                                    background:rgba(124,79,56,.92);
                                    font-size:14px;
                                "
                            >

                                {{ $pinjam->status }}

                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="3"
                            class="text-center py-5 text-muted"
                        >

                            Belum ada peminjaman.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection