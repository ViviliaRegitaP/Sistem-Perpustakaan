@extends('layouts.app')

@section('title', 'Data Kategori')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

    <div>
        <h2 class="fw-bold mb-1" style="color:#243020;">
            Data Kategori
        </h2>

        <p class="text-muted mb-0">
            Kelola data kategori buku perpustakaan.
        </p>
    </div>

    <a href="{{ route('kategori.create') }}"
       class="btn btn-primary-custom">
        <i class="bi bi-plus-circle me-2"></i>
        Tambah Kategori
    </a>

</div>

<div class="card border-0 data-card">

    <div class="card-body p-4">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">

            <table class="table align-middle custom-table">

                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Kategori</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($kategori as $item)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold">
                                {{ $item->nama_kategori }}
                            </td>

                            <td>
                                <div class="d-flex gap-2">

                                    <a href="{{ route('kategori.edit', $item->id_kategori) }}"
                                       class="btn btn-sm btn-primary-custom">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('kategori.destroy', $item->id_kategori) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger-custom"
                                                onclick="return confirm('Hapus kategori ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                Belum ada data kategori.
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
.btn-primary-custom{
    background:linear-gradient(135deg,#6F8F6B,#97AC82);
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
</style>

@endsection