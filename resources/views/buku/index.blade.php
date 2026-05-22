@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

    <div>
        <h2 class="fw-bold mb-1" style="color:#243020;">
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
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($bukus as $buku)

                        <tr>

                            <td class="fw-semibold">
                                {{ $buku->kode_buku }}
                            </td>

                            <td class="fw-semibold">
                                {{ $buku->judul }}
                            </td>

                            <td>{{ $buku->penulis }}</td>

                            <td>{{ $buku->penerbit }}</td>

                            <td>{{ $buku->tahun_terbit }}</td>

                            <td>

                                <span class="badge-stock">
                                    {{ $buku->stok }}
                                </span>

                            </td>

                            <td>

                                <div class="d-flex gap-2">

                                    <a href="{{ route('bukus.edit', $buku) }}"
                                       class="btn btn-sm btn-primary-custom">
                                        <i class="bi bi-pencil"></i>
                                    </a>

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
                            <td colspan="7"
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
    border-radius:24px;
    background:white;
    box-shadow:0 10px 30px rgba(0,0,0,.05);
}

.custom-table thead th{
    border:none;
    color:#243020;
    font-weight:700;
    padding:18px 14px;
    background:#EFF3EA;
}

.custom-table tbody td{
    padding:18px 14px;
    border-color:#EEF1EA;
    color:#2f3b2f;
}

.custom-table tbody tr:hover{
    background:#FAFCF8;
}

/* Khusus halaman Data Buku: samakan ukuran tombol dengan dashboard admin */
.btn-primary-custom{
    background:linear-gradient(
        135deg,
        #6F8F6B,
        #97AC82
    );
    color:white;
    text-decoration:none;
    border:none;
    border-radius:16px;
    padding:14px 22px;
    font-weight:600;

    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;

    font-size:16px;
    line-height:1.2;

    transition:.2s;
}

.btn-primary-custom:hover{
    opacity:.92;
    color:white;
}

.btn-danger-custom{
    background:#C96B6B;
    color:white;
    border:none;
    border-radius:14px;
    padding:14px 22px;
    font-weight:600;

    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;

    font-size:16px;
    line-height:1.2;

    transition:.2s;
}

.btn-danger-custom:hover{
    background:#b85b5b;
    color:white;
}


.badge-stock{
    background:#6F8F6B;
    color:white;
    padding:8px 14px;
    border-radius:999px;
    font-size:13px;
    font-weight:600;
}

</style>

@endsection