@extends('layouts.app')

@section('content')

    <div class="container-fluid px-4">
        <div class="page-header">
            <div>
                <h2 class="page-title">Kelola User</h2>
                <p class="page-subtitle">Manajemen data user sistem perpustakaan.</p>
            </div>

            <a href="{{ route('admin.users.create') }}" class="btn-brand">
                <i class="bi bi-plus-circle"></i>
                Tambah User
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success rounded-4 border-0 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="page-card">
            <div class="table-responsive">
                    <table class="table align-middle table-brand mb-0">
                    <thead>
                        <tr>
                            <th style="width:60px;">#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th style="width:220px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td class="fw-semibold">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-brand-secondary" style="padding:10px 14px; border-radius:16px; font-size:14px;">
                                            <i class="bi bi-pencil"></i>
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-brand-secondary" style="padding:10px 14px; border-radius:16px; font-size:14px; border-color:rgba(220,53,69,.25); background:rgba(220,53,69,.08); color:#B42318;">
                                                <i class="bi bi-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>

    </div>

@endsection


