@extends('layouts.app')

@section('content')

<div class="card border-0 shadow-sm rounded-5 p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Daftar Buku</h3>
            <p class="text-muted mb-0">
                Lihat koleksi buku perpustakaan.
            </p>
        </div>

    </div>

    <div class="table-responsive">

        <table class="table align-middle">

            <thead style="background:#EEF2EA;">

                <tr>
                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                </tr>

            </thead>

            <tbody>

                @forelse($bukus as $buku)

                    <tr>

                        <td>{{ $buku->kode_buku }}</td>

                        <td class="fw-semibold">
                            {{ $buku->judul }}
                        </td>

                        <td>{{ $buku->penulis }}</td>

                        <td>{{ $buku->penerbit }}</td>

                        <td>{{ $buku->tahun_terbit }}</td>

                        <td>

                            <span
                                class="badge rounded-pill px-3 py-2"
                                style="background:#7C9B72;"
                            >
                                {{ $buku->stok }}
                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center py-5 text-muted">

                            Belum ada buku.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection