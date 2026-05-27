@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

    <div>
        <h2 class="fw-bold mb-1" style="color:#243020; font-family:'Cormorant Garamond', serif; font-size:34px;">
            Kelola User
        </h2>
        <p class="text-muted mb-0">Kelola data pengguna aplikasi.</p>
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-circle me-2"></i>
        Tambah User
    </a>

</div>

<div class="card border-0 data-card">
    <div class="card-body p-4">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table align-middle custom-table">
                <thead>
                    <tr>
                        <th class="text-center" width="70">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th class="text-center" width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($users as $user)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($users->currentPage()-1)*$users->perPage() }}</td>
                            <td class="fw-semibold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">

                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary-custom">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger-custom" onclick="return confirm('Hapus user ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Belum ada data user.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <div>
            {{ $users->links() }}
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
    background:var(--gradient-btn);
    color:white;
    text-decoration:none;
    border:none;
    border-radius:16px;
    padding:10px 16px;
    font-weight:600;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    font-size:15px;
    transition:.2s;
}
.btn-primary-custom:hover{ opacity:.92; color:white; }
.btn-danger-custom{
    background:#C96B6B;
    color:white;
    border:none;
    border-radius:14px;
    padding:10px 16px;
    font-weight:600;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    font-size:15px;
    transition:.2s;
}
.btn-danger-custom:hover{ background:#b85b5b; color:white; }
</style>

@endsection

