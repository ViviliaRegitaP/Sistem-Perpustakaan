@extends('layouts.app')

@section('content')

<div class="card border-0 shadow-sm p-4"
    style="
        border-radius:32px;
        background:#FAF9F7;
    "
>

    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>

            <h2 class="fw-bold mb-2"
                style="
                    color:#2B2B2B;
                    font-size:28px;
                ">
                Daftar Buku
            </h2>

            <p class="text-muted mb-0"
                style="
                    font-size:16px;
                ">
                Cari dan lihat koleksi buku perpustakaan.
            </p>

        </div>

        <div
            class="d-flex align-items-center justify-content-center"
            style="
                width:64px;
                height:64px;
                border-radius:20px;
                background:#F3EEE8;
                color:#B07A4F;
                font-size:28px;
            "
        >
            <i class="bi bi-book"></i>
        </div>

    </div>



    <div
        class="table-responsive"
        style="
            border-radius:24px;
            overflow:hidden;
            border:1px solid #F1ECE6;
            background:white;
        "
    >

        <table
            class="table align-middle mb-0"
            style="min-width:1100px;"
        >

            <thead
                style="
                    background:#F5F5F0;
                "
            >

                <tr>

                    <th class="border-0 py-4 ps-4">
                        Kode
                    </th>

                    <th class="border-0 py-4">
                        Judul
                    </th>

                    <th class="border-0 py-4">
                        Penulis
                    </th>

                    <th class="border-0 py-4">
                        Penerbit
                    </th>

                    <th class="border-0 py-4 text-center">
                        Tahun
                    </th>

                    <th class="border-0 py-4 text-center">
                        Kategori
                    </th>

                    <th class="border-0 py-4 text-center">
                        Stok
                    </th>

                    <th class="border-0 py-4 text-center pe-4">
                        Aksi
                    </th>

                </tr>

            </thead>



            <tbody>

                @foreach($bukus as $index => $buku)

                    <tr
                        style="
                            border-bottom:1px solid #F5F1EC;
                        "
                    >

                        <td class="ps-4 py-4 fw-semibold">

                            BK{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}

                        </td>



                        <td
                            class="py-4 fw-semibold"
                            style="
                                color:#2B2B2B;
                                font-size:17px;
                            "
                        >

                            {{ $buku->judul }}

                        </td>



                        <td class="py-4">

                            {{ $buku->penulis }}

                        </td>



                        <td class="py-4">

                            {{ $buku->penerbit }}

                        </td>



                        <td class="text-center py-4">

                            {{ $buku->tahun_terbit }}

                        </td>



                        <td class="text-center py-4">

                            <span
                                style="
                                    background:#F3E7DA;
                                    color:#B07A4F;
                                    border-radius:999px;
                                    padding:10px 18px;
                                    font-size:14px;
                                    font-weight:600;
                                    white-space:nowrap;
                                    display:inline-block;
                                "
                            >

                                {{ $buku->kategori->nama_kategori }}

                            </span>

                        </td>



                        <td class="text-center py-4">

                            <span
                                class="d-inline-flex align-items-center justify-content-center"
                                style="
                                    width:42px;
                                    height:42px;
                                    border-radius:50%;
                                    background:#B07A4F;
                                    color:white;
                                    font-weight:700;
                                "
                            >

                                {{ $buku->stok }}

                            </span>

                        </td>



                        <td class="text-center pe-4 py-4">

                            <button
                                type="button"
                                onclick="openModal('{{ $buku->id }}', '{{ $buku->judul }}')"
                                class="btn border-0 fw-semibold"
                                style="
                                    background:#B07A4F;
                                    color:white;
                                    border-radius:16px;
                                    padding:12px 24px;
                                    min-width:120px;
                                "
                            >

                                <i class="bi bi-journal-plus me-2"></i>

                                Pinjam

                            </button>

                        </td>

                    </tr>

                @endforeach

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

                <form method="POST" action="{{ route('pinjam.buku') }}" id="formPinjam">
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
    document.addEventListener('DOMContentLoaded', () => {
        const pinjamModalEl = document.getElementById('pinjamModal');
        const pinjamModal = new bootstrap.Modal(pinjamModalEl);

        window.setTanggalKembali = function () {
            const tanggalPinjam = document.getElementById('tanggal_pinjam').value;
            let lamaPinjam = parseInt(document.getElementById('lama_pinjam').value || '1', 10);

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
        };

        window.openModal = function (id, judul) {
            document.getElementById('buku_id').value = id;
            document.getElementById('judul_buku').value = judul;

            window.setTanggalKembali();

            pinjamModal.show();
        };

        window.setTanggalKembali();

        const lamaPinjamInput = document.getElementById('lama_pinjam');
        if (lamaPinjamInput) {
            lamaPinjamInput.addEventListener('input', window.setTanggalKembali);
        }
    });
</script>


@endsection
