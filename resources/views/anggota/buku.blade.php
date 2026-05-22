@extends('layouts.app')

@section('content')

<div class="card border-0 shadow-sm p-4" style="border-radius:32px; background: rgba(255,255,255,.92); border:1px solid rgba(232,222,213,.9);">

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

<thead style="background:rgba(241,212,179,.38);">

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
                                style="background: rgba(124,79,56,.92);"
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