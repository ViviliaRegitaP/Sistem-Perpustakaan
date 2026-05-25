@extends('layouts.app')

@section('content')

<div class="dashboard-page">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-5">

        <div>
            <h2 class="fw-bold mb-2" style="color:#243020;font-size:34px;">
                Denda Saya
            </h2>

            <p class="text-muted mb-0 fs-5">
                Pantau status denda dan keterlambatan buku.
            </p>
        </div>

    </div>

    {{-- CARD --}}
    <div class="card border-0 shadow-sm" style="border-radius:28px;">

        <div class="card-body p-4">

            <h4 class="fw-bold mb-4" style="color:#243020;">
                Data Denda
            </h4>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                            <th>Denda</th>
                            <th>Baru Bayar</th>
                            <th>Sisa Denda</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($fines as $fine)

                            <tr>

                                <td class="fw-semibold">
                                    {{ $fine->peminjaman->buku->judul }}
                                </td>

                                <td>
                                    Rp {{ number_format($fine->jumlah_denda) }}
                                </td>

                                <td>
                                    Rp {{ number_format($fine->dibayar) }}
                                </td>

                                <td>
                                    Rp {{ number_format($fine->sisa_denda) }}
                                </td>

                                {{-- STATUS --}}
                                <td>
                                    <span class="badge bg-{{ $fine->status_color }}">
                                        {{ $fine->status_label }}
                                    </span>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    Tidak ada denda.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection