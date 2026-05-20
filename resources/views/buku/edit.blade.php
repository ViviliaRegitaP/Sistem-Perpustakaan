@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
    <div class="d-flex align-items-start justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card border-0" style="background: rgba(255,255,255,.78); backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(17,24,39,.06);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <h1 class="h4 fw-bold mb-0">Edit Buku</h1>
                        <div class="small" style="color: var(--muted);"><i class="bi bi-pencil-square me-1"></i>Perbarui data buku</div>
                    </div>

                    <form action="{{ route('bukus.update', $buku) }}" method="POST" novalidate id="bukuFormEdit">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="kode_buku" class="form-control @error('kode_buku') is-invalid @enderror" value="{{ old('kode_buku', $buku->kode_buku) }}" required id="kode_buku" placeholder="Kode Buku">
                                    <label for="kode_buku"><i class="bi bi-card-text me-1"></i>Kode Buku</label>
                                </div>
                                @error('kode_buku')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" class="form-control @error('tahun_terbit') is-invalid @enderror" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required min="1800" max="2100">
                                @error('tahun_terbit')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Judul</label>
                                <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $buku->judul) }}" required>
                                @error('judul')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Penulis</label>
                                <input type="text" name="penulis" class="form-control @error('penulis') is-invalid @enderror" value="{{ old('penulis', $buku->penulis) }}" required>
                                @error('penulis')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Penerbit</label>
                                <input type="text" name="penerbit" class="form-control @error('penerbit') is-invalid @enderror" value="{{ old('penerbit', $buku->penerbit) }}" required>
                                @error('penerbit')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Stok</label>
                                <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $buku->stok) }}" required min="0">
                                @error('stok')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 d-flex align-items-end justify-content-md-end">
                                <div class="d-grid d-md-flex gap-2">
                                    <a href="{{ route('bukus.index') }}" class="btn" style="background: rgba(44,52,27,.10); color: var(--text); border:1px solid rgba(44,52,27,.12); font-weight:800;">
                                        <i class="bi bi-x-circle me-1"></i>Batal
                                    </a>
                                    <button type="submit" class="btn fw-semibold" style="background: var(--secondary,#4F46E5); color:#fff; border:0; font-weight:900;" id="btnSaveEdit">
                                        <i class="bi bi-check2-circle me-1"></i>Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const form = document.getElementById('bukuFormEdit');
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

