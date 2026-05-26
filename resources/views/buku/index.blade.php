@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

    <div>

        <h2 class="fw-bold mb-1"
            style="
                color:#2A211C;
                font-family:'Cormorant Garamond', serif;
                font-size:34px;
            ">

            Data Buku

        </h2>

        <p class="text-muted mb-0">
            Kelola seluruh data buku perpustakaan.
        </p>

    </div>

    <a href="{{ route('bukus.create') }}"
       class="btn btn-primary-custom">

        <i class="bi bi-plus-circle me-2"></i>
        Tambah Buku

    </a>

</div>

<div class="card border-0 data-card">

    <div class="card-body p-4">

        <div class="table-responsive">

            <table class="table align-middle custom-table">

                <thead>

                    <tr>

                        <th class="text-center">Kode</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Kategori</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center" width="140">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($bukus as $buku)

                        <tr>

                            {{-- KODE --}}
                            <td class="fw-semibold text-center">

                                {{ $buku->kode_buku }}

                            </td>


                            {{-- JUDUL --}}
                            <td class="fw-semibold">

                                {{ $buku->judul }}

                            </td>


                            {{-- PENULIS --}}
                            <td>

                                {{ $buku->penulis }}

                            </td>


                            {{-- PENERBIT --}}
                            <td>

                                {{ $buku->penerbit }}

                            </td>


                            {{-- TAHUN --}}
                            <td class="text-center">

                                {{ $buku->tahun_terbit }}

                            </td>


                            {{-- KATEGORI --}}
                            <td class="text-center">

                                <span class="badge-kategori">

                                    {{ $buku->kategori->nama_kategori ?? '-' }}

                                </span>

                            </td>


                            {{-- STOK --}}
                            <td class="text-center">

                                <span class="badge-stock">

                                    {{ $buku->stok }}

                                </span>

                            </td>


                            {{-- AKSI --}}
                            <td>

                                <div class="d-flex justify-content-center gap-2">

                                    {{-- EDIT --}}
                                    <a href="{{ route('bukus.edit', $buku) }}"
                                       class="btn btn-sm btn-primary-custom">

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    {{-- DELETE --}}
                                    <form
                                        action="{{ route('bukus.destroy', $buku) }}"
                                        method="POST"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger-custom"
                                            onclick="return confirm('Hapus buku ini?')"
                                        >

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8"
                                class="text-center py-5 text-muted">

                                Belum ada data buku.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<style>

.data-card{
    border-radius:28px;
    background:rgba(255,255,255,.95);
    box-shadow:0 10px 30px rgba(0,0,0,.04);
    border:1px solid #EEE7E1;
}


/* TABLE */
.custom-table{
    margin-bottom:0;
}

.custom-table thead th{
    border:none;
    background:#F4F6F0;
    color:#243020;
    font-weight:700;
    padding:18px 16px;
    font-size:15px;
}

.custom-table tbody td{
    padding:20px 16px;
    border-color:#F1ECE7;
    color:#2F3B2F;
    vertical-align:middle;
}

.custom-table tbody tr:hover{
    background:#FCFCFA;
}


/* BUTTON */
.btn-primary-custom{
    background:var(--gradient-btn);
    color:white;
    border:none;
    border-radius:16px;
    padding:10px 18px;
    font-weight:600;

    display:inline-flex;
    align-items:center;
    justify-content:center;

    transition:.2s;
}

.btn-primary-custom:hover{
    opacity:.92;
    color:white;
}

.btn-danger-custom{
    background:#D46A6A;
    color:white;
    border:none;
    border-radius:16px;
    padding:10px 18px;
    font-weight:600;

    display:inline-flex;
    align-items:center;
    justify-content:center;

    transition:.2s;
}

.btn-danger-custom:hover{
    background:#C85B5B;
    color:white;
}


/* BADGE STOK */
.badge-stock{
    display:inline-flex;
    align-items:center;
    justify-content:center;

    min-width:40px;
    height:40px;

    background:var(--gradient-btn);
    color:white;

    border-radius:999px;

    font-size:13px;
    font-weight:700;
}


/* BADGE KATEGORI */
.badge-kategori{

    display:inline-flex;
    align-items:center;
    justify-content:center;

    min-width:115px;
    padding:8px 16px;

    background:#F3E6D9;
    color:#9C6644;

    border-radius:999px;

    font-size:13px;
    font-weight:700;

    white-space:nowrap;
    text-align:center;
}


/* RESPONSIVE */
@media(max-width:768px){

    .custom-table thead th,
    .custom-table tbody td{
        padding:14px 10px;
        font-size:14px;
    }

    .badge-kategori{
        min-width:auto;
        padding:7px 12px;
        font-size:12px;
    }

}

</style>

@endsection