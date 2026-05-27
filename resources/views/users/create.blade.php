@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')

<div class="d-flex align-items-start justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card border-0" style="background: rgba(255,255,255,.78); backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(17,24,39,.06);">
            <div class="card-body p-4">

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                    <h1 class="h4 fw-bold mb-0">Tambah User</h1>
                    <div class="small" style="color: var(--muted);">
                        <i class="bi bi-plus-circle me-1"></i>
                        Input data pengguna
                    </div>
                </div>

                <form action="{{ route('users.store') }}" method="POST" novalidate id="userFormCreate">
                    @csrf

                    <div class="row g-3">

                        <div class="col-md-12">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>

                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>

                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>

                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <div class="col-md-12 d-flex justify-content-end">
                            <div class="d-flex gap-2">
                                <a href="{{ route('users.index') }}" class="btn" style="background: rgba(44,52,27,.10); color: var(--text); border:1px solid rgba(44,52,27,.12); font-weight:800;">
                                    <i class="bi bi-x-circle me-1"></i>
                                    Batal
                                </a>

                                <button type="submit" id="btnSaveCreate" class="btn fw-semibold" style="background: #8B5E3C; color:#fff; border:0; font-weight:900;">
                                    <i class="bi bi-save me-1"></i>
                                    Simpan
                                </button>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('userFormCreate');
        const btn = document.getElementById('btnSaveCreate');
        if (!form || !btn) return;

        form.addEventListener('submit', () => {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
        });
    });
</script>

@endsection

