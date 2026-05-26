@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
<div class="d-flex align-items-start justify-content-center">
    <div class="col-12 col-lg-8">

        <div class="card border-0"
            style="background: rgba(255,255,255,.78);
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(17,24,39,.06);">

            <div class="card-body p-4">

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                    <h1 class="h4 fw-bold mb-0">Tambah Buku</h1>

                    <div class="small" style="color: var(--muted);">
                        <i class="bi bi-plus-circle me-1"></i>
                        Input data buku
                    </div>
                </div>

                <form action="{{ route('bukus.store') }}" method="POST" novalidate id="bukuFormCreate">
                    @csrf

                    <div class="row g-3">

                        {{-- TAHUN TERBIT --}}
                        <div class="col-md-6">
                            <label class="form-label">Tahun Terbit</label>

                            <input type="number"
                                name="tahun_terbit"
                                class="form-control @error('tahun_terbit') is-invalid @enderror"
                                value="{{ old('tahun_terbit') }}"
                                required
                                min="1800"
                                max="2100">

                            @error('tahun_terbit')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- JUDUL --}}
                        <div class="col-md-12">
                            <label class="form-label">Judul</label>

                            <input type="text"
                                name="judul"
                                class="form-control @error('judul') is-invalid @enderror"
                                value="{{ old('judul') }}"
                                required>

                            @error('judul')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- PENULIS --}}
                        <div class="col-md-6">
                            <label class="form-label">Penulis</label>

                            <input type="text"
                                name="penulis"
                                class="form-control @error('penulis') is-invalid @enderror"
                                value="{{ old('penulis') }}"
                                required>

                            @error('penulis')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- PENERBIT --}}
                        <div class="col-md-6">
                            <label class="form-label">Penerbit</label>

                            <input type="text"
                                name="penerbit"
                                class="form-control @error('penerbit') is-invalid @enderror"
                                value="{{ old('penerbit') }}"
                                required>

                            @error('penerbit')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- STOK --}}
                        <div class="col-md-6">
                            <label class="form-label">Stok</label>

                            <input type="number"
                                name="stok"
                                class="form-control @error('stok') is-invalid @enderror"
                                value="{{ old('stok') }}"
                                required
                                min="0">

                            @error('stok')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- KATEGORI --}}
                        <div class="col-md-12">

                            <label class="form-label">Kategori</label>

                            <select name="kategori_id"
                                class="form-control @error('kategori_id') is-invalid @enderror">

                                <option value="" disabled selected>
                                    Pilih kategori
                                </option>

                                @isset($categories)
                                    @foreach ($categories as $category)

                                        <option value="{{ $category->id }}"
                                            {{ old('kategori_id') == $category->id ? 'selected' : '' }}>

                                            {{ $category->nama_kategori }}

                                        </option>

                                    @endforeach
                                @endisset

                            </select>

                            @error('kategori_id')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- BUTTON --}}
                        <div class="col-md-12 d-flex justify-content-end">

                            <div class="d-flex gap-2">

                                <a href="{{ route('bukus.index') }}"
                                    class="btn"
                                    style="background: rgba(44,52,27,.10);
                                    color: var(--text);
                                    border:1px solid rgba(44,52,27,.12);
                                    font-weight:800;">

                                    <i class="bi bi-x-circle me-1"></i>
                                    Batal

                                </a>

                                <button type="submit"
                                    id="btnSaveCreate"
                                    class="btn fw-semibold"
                                    style="background: #8B5E3C;
                                    color:#fff;
                                    border:0;
                                    font-weight:900;">

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

        const form = document.getElementById('bukuFormCreate');
        const btn = document.getElementById('btnSaveCreate');

        if (!form || !btn) return;

        form.addEventListener('submit', () => {

            btn.disabled = true;

            btn.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';

        });

    });
</script>
@endsection