@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')

<div class="d-flex align-items-start justify-content-center">

    <div class="col-12 col-lg-8">

        <div
            class="card border-0"
            style="
                background: rgba(255,255,255,.78);
                backdrop-filter: blur(10px);
                box-shadow: 0 10px 30px rgba(17,24,39,.06);
                border-radius: 24px;
            "
        >

            <div class="card-body p-4 p-lg-5">

                <div
                    class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4"
                >

                    <div>

                        <h1 class="h3 fw-bold mb-1">
                            Edit Kategori
                        </h1>

                        <div
                            class="small"
                            style="color: #7A6A61;"
                        >
                            <i class="bi bi-pencil-square me-1"></i>
                            Perbarui data kategori
                        </div>

                    </div>

                </div>

                <form
                    action="{{ route('kategori.update', $kategori) }}"
                    method="POST"
                    novalidate
                    id="kategoriFormEdit"
                >

                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        <div class="col-12">

                            <label class="form-label fw-semibold">
                                Nama Kategori
                            </label>

                            <input
                                type="text"
                                name="nama_kategori"
                                class="form-control @error('nama_kategori') is-invalid @enderror"
                                value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                placeholder="Masukkan nama kategori"
                                required
                                style="
                                    height: 56px;
                                    border-radius: 16px;
                                    border: 1px solid #E8DED5;
                                    background: rgba(255,255,255,.9);
                                "
                            >

                            @error('nama_kategori')

                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                        <div
                            class="col-12 d-flex align-items-center justify-content-end"
                        >

                            <div class="d-flex gap-2 flex-wrap">

                                <a
                                    href="{{ route('kategori.index') }}"
                                    class="btn px-4"
                                    style="
                                        height: 52px;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;

                                        background: rgba(44,52,27,.08);

                                        color: #2A211C;

                                        border:1px solid rgba(44,52,27,.10);

                                        border-radius: 16px;

                                        font-weight:700;
                                    "
                                >

                                    <i class="bi bi-arrow-left me-2"></i>

                                    Kembali

                                </a>

                                <button
                                    type="submit"
                                    class="btn px-4"
                                    id="btnSaveEdit"
                                    style="
                                        height: 52px;

                                        display:flex;
                                        align-items:center;
                                        justify-content:center;

                                        background: linear-gradient(
                                            135deg,
                                            #7C4F38 0%,
                                            #B17457 100%
                                        );

                                        color:#fff;

                                        border:none;

                                        border-radius:16px;

                                        font-weight:700;

                                        box-shadow:
                                        0 10px 20px rgba(124,79,56,.18);
                                    "
                                >

                                    <i class="bi bi-check2-circle me-2"></i>

                                    Update

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

        const form = document.getElementById('kategoriFormEdit');
        const btn = document.getElementById('btnSaveEdit');

        if (!form || !btn) return;

        form.addEventListener('submit', () => {

            btn.disabled = true;

            btn.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>Mengupdate...';

        });

    });

</script>

@endsection