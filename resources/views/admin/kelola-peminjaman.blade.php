@extends('layouts.app')

@section('content')

<div class="dashboard-page">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1
                class="fw-bold mb-1"
                style="
                    color:#243020;
                    font-size:34px;
                    letter-spacing:-1px;
                "
            >
                Kelola Peminjaman
            </h1>

            <p
                class="text-muted mb-0"
                style="
                    font-size:15px;
                "
            >
                Kelola peminjaman anggota perpustakaan.
            </p>

        </div>

        {{-- ICON --}}
        <div
            class="rounded-4 d-flex align-items-center justify-content-center"
            style="
                width:64px;
                height:64px;
                background:#F5F1EC;
                color:#9A6B4D;
                font-size:24px;
            "
        >
            <i class="bi bi-journal-check"></i>
        </div>

    </div>



    {{-- ALERT --}}
    @if(session('success'))

        <div
            class="alert border-0 mb-4"
            style="
                background:#EEF7F0;
                color:#1E7A34;
                border-radius:16px;
                font-size:14px;
            "
        >
            {{ session('success') }}
        </div>

    @endif



    {{-- FILTER --}}
    <div class="d-flex gap-2 flex-wrap mb-4">

        <a
            href="/kelola-peminjaman"
            class="btn rounded-pill px-3 py-2"
            style="
                background:#F5F1EC;
                color:#444;
                font-size:14px;
                font-weight:600;
                border:none;
            "
        >
            Semua
        </a>

        <a
            href="/kelola-peminjaman?status=Pending"
            class="btn rounded-pill px-3 py-2"
            style="
                background:#FFF4DB;
                color:#C58A00;
                font-size:14px;
                font-weight:600;
                border:none;
            "
        >
            Pending
        </a>

        <a
            href="/kelola-peminjaman?status=Dipinjam"
            class="btn rounded-pill px-3 py-2"
            style="
                background:#F3E7DE;
                color:#9A6B4D;
                font-size:14px;
                font-weight:600;
                border:none;
            "
        >
            Dipinjam
        </a>

        <a
            href="/kelola-peminjaman?status=Dikembalikan"
            class="btn rounded-pill px-3 py-2"
            style="
                background:#E9F8EE;
                color:#16A34A;
                font-size:14px;
                font-weight:600;
                border:none;
            "
        >
            Dikembalikan
        </a>

        <a
            href="/kelola-peminjaman?status=Ditolak"
            class="btn rounded-pill px-3 py-2"
            style="
                background:#FDECEC;
                color:#DC2626;
                font-size:14px;
                font-weight:600;
                border:none;
            "
        >
            Ditolak
        </a>

    </div>



    {{-- CARD --}}
    <div
        class="card border-0 shadow-sm"
        style="
            border-radius:30px;
            overflow:hidden;
            border:1px solid #F1ECE6;
        "
    >

        <div class="card-body p-0">

            {{-- TABLE --}}
            <div class="table-responsive">

                <table
                    class="table align-middle mb-0"
                    style="
                        font-size:15px;
                    "
                >

                    <thead>

                        <tr
                            style="
                                background:#F6F6F2;
                                border-bottom:1px solid #EFE7DE;
                            "
                        >

                            <th class="border-0 py-3 px-4">
                                Anggota
                            </th>

                            <th class="border-0 py-3">
                                Buku
                            </th>

                            <th class="border-0 py-3">
                                Pinjam
                            </th>

                            <th class="border-0 py-3">
                                Kembali
                            </th>

                            <th class="border-0 py-3">
                                Status
                            </th>

                            <th class="border-0 py-3 text-end pe-4">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($peminjamans as $pinjam)

                            @php

                                $bg = match($pinjam->status) {

                                    'Pending' => '#F59E0B',
                                    'Dipinjam' => '#A56A3D',
                                    'Ditolak' => '#DC2626',
                                    'Dikembalikan' => '#16A34A',

                                    default => '#6B7280',

                                };

                            @endphp

                            <tr
                                style="
                                    border-bottom:1px solid #F3EEE8;
                                "
                            >

                                {{-- ANGGOTA --}}
                                <td class="py-4 px-4 fw-semibold">

                                    {{ $pinjam->user->name }}

                                </td>


                                {{-- BUKU --}}
                                <td
                                    class="py-4 fw-semibold"
                                    style="
                                        color:#2B2B2B;
                                    "
                                >

                                    {{ $pinjam->buku->judul }}

                                </td>


                                {{-- TANGGAL --}}
                                <td class="py-4 text-muted">

                                    {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}

                                </td>

                                <td class="py-4 text-muted">

                                    {{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d M Y') }}

                                </td>



                                {{-- STATUS --}}
                                <td class="py-4">

                                    <span
                                        class="badge rounded-pill px-3 py-2"
                                        style="
                                            background:{{ $bg }};
                                            color:white;
                                            font-size:12px;
                                            font-weight:600;
                                            min-width:110px;
                                        "
                                    >

                                        {{ $pinjam->status }}

                                    </span>

                                </td>



                                {{-- AKSI --}}
                                <td class="py-4 pe-4">

                                    <div
                                        class="d-flex justify-content-end align-items-center gap-2 flex-wrap"
                                    >

                                        @if($pinjam->status == 'Pending')

                                            {{-- SETUJUI --}}
                                            <form
                                                action="/peminjaman/{{ $pinjam->id }}/setujui"
                                                method="POST"
                                            >
                                                @csrf

                                                <button
                                                    class="btn border-0 rounded-pill"
                                                    style="
                                                        background:#16A34A;
                                                        color:white;
                                                        min-width:95px;
                                                        height:38px;
                                                        font-size:13px;
                                                        font-weight:600;
                                                    "
                                                >
                                                    Setujui
                                                </button>

                                            </form>



                                            {{-- TOLAK --}}
                                            <form
                                                action="/peminjaman/{{ $pinjam->id }}/tolak"
                                                method="POST"
                                            >
                                                @csrf

                                                <button
                                                    class="btn border-0 rounded-pill"
                                                    style="
                                                        background:#DC2626;
                                                        color:white;
                                                        min-width:85px;
                                                        height:38px;
                                                        font-size:13px;
                                                        font-weight:600;
                                                    "
                                                >
                                                    Tolak
                                                </button>

                                            </form>

                                        @elseif($pinjam->status == 'Dipinjam')

                                            {{-- KEMBALIKAN --}}
                                            <form
                                                action="/kembalikan/{{ $pinjam->id }}"
                                                method="POST"
                                            >
                                                @csrf

                                                <button
                                                    class="btn border-0 rounded-pill"
                                                    style="
                                                        background:#2563EB;
                                                        color:white;
                                                        min-width:130px;
                                                        height:38px;
                                                        font-size:13px;
                                                        font-weight:600;
                                                    "
                                                >
                                                    Kembalikan
                                                </button>

                                            </form>

                                        @else

                                            {{-- HAPUS --}}
                                            <form
                                                action="/peminjaman/{{ $pinjam->id }}"
                                                method="POST"
                                                onsubmit="return confirm('Hapus data ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    class="btn border-0 rounded-pill"
                                                    style="
                                                        background:#EEEEEE;
                                                        color:#666;
                                                        min-width:95px;
                                                        height:38px;
                                                        font-size:13px;
                                                        font-weight:600;
                                                    "
                                                >
                                                    Hapus
                                                </button>

                                            </form>

                                        @endif

                                    </div>

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

    </div>

</div>

@endsection