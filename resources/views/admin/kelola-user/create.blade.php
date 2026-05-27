@extends('layouts.app')

@section('content')

    <div class="container-fluid px-4">
        <div class="page-header">
            <div>
                <h2 class="page-title">Tambah User</h2>
                <p class="page-subtitle">Isi data user baru sistem.</p>
            </div>

            <a href="{{ route('admin.users.index') }}" class="btn-brand-secondary">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>

        <div class="page-card">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label-brand">Nama</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control input-brand"
                        value="{{ old('name') }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label-brand">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control input-brand"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label-brand">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control input-brand"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label-brand">Konfirmasi Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control input-brand"
                        required
                    >
                </div>

                <button type="submit" class="btn-brand w-100">
                    <i class="bi bi-save"></i>
                    Simpan
                </button>
            </form>
        </div>

    </div>

@endsection


