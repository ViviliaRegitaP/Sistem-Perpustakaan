@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="d-flex align-items-start justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card border-0" style="background: rgba(255,255,255,.78); backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(17,24,39,.06);">
            <div class="card-body p-4">

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                    <h1 class="h4 fw-bold mb-0">Edit User</h1>
                    <div class="small" style="color: var(--muted);">
                        <i class="bi bi-pencil-square me-1"></i>
                        Perbarui data pengguna
                    </div>
                </div>

                <form action="{{ route('users.update', $user) }}" method="POST" novalidate id="userFormEdit">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <div class="col-md-12">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>

                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>

                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Password Baru (Opsional)</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">

                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                        </div>

                        <div class="col-md-12 d-flex justify-content-end">
                            <div class="d-grid d-md-flex gap-2">
                                <a href="{{ route('users.index') }}" class="btn" style="background: rgba(44,52,27,.10); color: var(--text); border:1px solid rgba(44,52,27,.12); font-weight:800;">
                                    <i class="bi bi-x-circle me-1"></i>
                                    Batal
                                </a>

                                <button type="submit" class="btn fw-semibold" style="background:#B07A4F; color:#fff; border:0; font-weight:900; border-radius:16px; padding:12px 24px;" id="btnSaveEdit" onmouseenter="this.style.background='#9B6B43'" onmouseleave="this.style.background='#B07A4F'">
                                    <i class="bi bi-check2-circle me-1"></i>
                                    Update
                                </button>
                            </div>
                        </div>

                    </div>
                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const form = document.getElementById('userFormEdit');
                        const btn = document.getElementById('btnSaveEdit');
                        if (!form || !btn) return;

                        form.addEventListener('submit', () => {
                            btn.disabled = true;
                            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Loading...';
                        });
                    });
                </script>

            </div>
        </div>
    </div>
</div>

@endsection

