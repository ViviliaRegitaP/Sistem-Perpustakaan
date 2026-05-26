@extends('layouts.app')

@section('content')

<div class="card border-0 shadow-sm p-4"
    style="
        border-radius:32px;
        background: rgba(255,255,255,.92);
        border:1px solid rgba(232,222,213,.9);
    ">

    {{-- ALERT --}}
    @if(session('success'))

        <div
            class="alert border-0 mb-4"
            style="
                background:#DFF5E8;
                color:#2D6A4F;
                border-radius:18px;
                padding:18px;
                font-weight:600;
            "
        >

            {{ session('success') }}

        </div>

    @endif

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Daftar Buku
            </h3>

            <p class="text-muted mb-0">
                Lihat koleksi buku perpustakaan.
            </p>

        </div>

    </div>

    {{-- SEARCH --}}
    <div class="mb-4">

        <input
            type="text"
            placeholder="Cari buku..."
            class="form-control rounded-4 py-3"
        >

    </div>

    {{-- FILTER --}}
    <div class="d-flex gap-2 flex-wrap mb-5">

        <button
            class="btn text-white rounded-pill px-4 py-2"
            style="background:#A47148;"
        >
            Semua
        </button>

        <button class="btn btn-light rounded-pill px-4 py-2">
            Novel
        </button>

        <button class="btn btn-light rounded-pill px-4 py-2">
            Filsafat
        </button>

        <button class="btn btn-light rounded-pill px-4 py-2">
            Karya Ilmiah
        </button>

        <button class="btn btn-light rounded-pill px-4 py-2">
            Biografi
        </button>

    </div>

    {{-- TABLE --}}
    <div class="table-responsive">

        <table class="table align-middle">

            <thead>

                <tr>

                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($bukus as $buku)

                    <tr>

                        {{-- KODE --}}
                        <td class="fw-bold">
                            {{ $buku->kode_buku }}
                        </td>

                        {{-- JUDUL --}}
                        <td class="fw-semibold">
                            {{ $buku->judul }}
                        </td>

                        {{-- PENULIS --}}
                        <td>
                            {{ $buku->penulis }}
                        </td>

                        {{-- PENERBIT --}}
                        <td>
                            {{ $buku->penerbit }}
                        </td>

                        {{-- TAHUN --}}
                        <td>
                            {{ $buku->tahun_terbit }}
                        </td>

                        {{-- KATEGORI --}}
                        <td>

                            <span
                                class="badge rounded-pill px-3 py-2"
                                style="
                                    background:#F5E6D8;
                                    color:#A47148;
                                    font-size:14px;
                                "
                            >

                                {{ $buku->kategori->nama }}

                            </span>

                        </td>

                        {{-- STOK --}}
                        <td>

                            <span
                                class="badge rounded-pill px-3 py-2"
                                style="
                                    background:#A47148;
                                    font-size:14px;
                                "
                            >

                                {{ $buku->stok }}

                            </span>

                        </td>

                        {{-- BUTTON --}}
                        <td>

                            <button
                                type="button"
                                onclick="openModal('{{ $buku->id }}', '{{ $buku->judul }}')"
                                class="btn text-white px-4 py-2 rounded-pill"
                                style="
                                    background:#A47148;
                                    font-weight:600;
                                "
                            >

                                📖 Pinjam

                            </button>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="text-center py-5 text-muted"
                        >

                            Belum ada buku.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- MODAL PINJAM (Bootstrap) --}}
<div
    class="modal fade"
    id="pinjamModal"
    tabindex="-1"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div
            class="modal-content"
            style="
                border:none;
                border-radius:28px;
                background: rgba(255,255,255,.92);
                border:1px solid rgba(232,222,213,.9);
                box-shadow: 0 10px 35px rgba(0,0,0,.08);
            "
        >
            <div class="modal-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div
                        class="mx-auto mb-3 d-flex justify-content-center align-items-center"
                        style="
                            width:80px;
                            height:80px;
                            border-radius:24px;
                            background:#A47148;
                            color:white;
                            font-size:34px;
                        "
                    >
                        📚
                    </div>

                    <h3 class="fw-bold" style="color:#5C3B28;">Form Peminjaman</h3>
                    <p class="text-muted mb-0">Lengkapi data peminjaman buku.</p>
                </div>

                <form method="POST" action="/pinjam-buku" id="formPinjam">
                    @csrf

                    <input type="hidden" name="buku_id" id="buku_id">

                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Nama Anggota</label>
                        <input
                            type="text"
                            id="nama_anggota"
                            readonly
                            class="form-control rounded-4"
                            value="{{ Auth::user()->name ?? '' }}"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Judul Buku</label>
                        <input type="text" id="judul_buku" readonly class="form-control rounded-4">
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Tanggal Pinjam</label>
                        <input
                            type="date"
                            id="tanggal_pinjam"
                            name="tanggal_pinjam"
                            readonly
                            class="form-control rounded-4"
                            value="{{ date('Y-m-d') }}"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Lama Pinjam (hari)</label>
                        <input
                            type="number"
                            name="lama_pinjam"
                            id="lama_pinjam"
                            min="1"
                            max="7"
                            value="1"
                            class="form-control rounded-4"
                            required
                        >
                        <div class="text-muted small mt-2">Maksimal peminjaman 7 hari</div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-semibold mb-2">Tanggal Kembali</label>
                        <input
                            type="date"
                            name="tanggal_kembali"
                            id="tanggal_kembali"
                            class="form-control rounded-4"
                            readonly
                        >
                    </div>

                    <div class="p-3 rounded-4 mb-4" style="background:#FFF7ED; border:1px solid #FED7AA;">
                        <ul class="mb-0 text-muted small" style="padding-left:18px;">
                            <li class="fw-semibold" style="color:#8B5E3C;">Maksimal peminjaman 7 hari</li>
                            <li>Denda keterlambatan Rp2.000/hari</li>
                        </ul>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="button" class="btn btn-light w-50 rounded-pill" data-bs-dismiss="modal">Batal</button>

                        <button
                            type="submit"
                            class="btn text-white w-50 rounded-pill"
                            style="background:#A47148; font-weight:700; border:none;"
                        >
                            Konfirmasi Pinjam
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT (Bootstrap modal + hitung tanggal kembali otomatis) --}}
<script>
    const pinjamModalEl = document.getElementById('pinjamModal');
    const pinjamModal = new bootstrap.Modal(pinjamModalEl);

    function setTanggalKembali() {
        const tanggalPinjam = document.getElementById('tanggal_pinjam').value;
        let lamaPinjam = parseInt(document.getElementById('lama_pinjam').value || '1', 10);

        // validasi client 1..7
        if (Number.isNaN(lamaPinjam)) lamaPinjam = 1;
        if (lamaPinjam < 1) lamaPinjam = 1;
        if (lamaPinjam > 7) lamaPinjam = 7;

        document.getElementById('lama_pinjam').value = lamaPinjam;

        const [y, m, d] = tanggalPinjam.split('-').map(Number);
        const date = new Date(y, m - 1, d);
        date.setDate(date.getDate() + lamaPinjam);

        const yyyy = date.getFullYear();
        const mm = String(date.getMonth() + 1).padStart(2, '0');
        const dd = String(date.getDate()).padStart(2, '0');

        document.getElementById('tanggal_kembali').value = `${yyyy}-${mm}-${dd}`;
    }

    document.addEventListener('DOMContentLoaded', () => {
        setTanggalKembali();

        const lamaPinjamInput = document.getElementById('lama_pinjam');
        if (lamaPinjamInput) {
            lamaPinjamInput.addEventListener('input', setTanggalKembali);
        }
    });

    function openModal(id, judul) {
        document.getElementById('buku_id').value = id;
        document.getElementById('judul_buku').value = judul;

        // reset tanggal kembali setiap buka modal
        setTanggalKembali();

        pinjamModal.show();
    }
</script>

@endsection