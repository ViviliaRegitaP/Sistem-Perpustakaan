@extends('layouts.app')

@section('content')

<div class="dashboard-page">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-5">

        <div>
            <h2 class="fw-bold mb-2" style="color:#243020;font-size:34px;">
                Kelola Denda
            </h2>

            <p class="text-muted mb-0 fs-5">
                Kelola data denda anggota perpustakaan.
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
                            <th>Nama Anggota</th>
                            <th>Judul Buku</th>
                            <th>Denda</th>
                            <th>Baru Bayar</th>
                            <th>Sisa Denda</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($fines as $fine)

                            <tr>

                                <td class="fw-semibold">
                                    {{ $fine->peminjaman->user->name }}
                                </td>

                                <td>
                                    {{ $fine->peminjaman->buku->judul }}
                                </td>

                                <td>
                                    Rp {{ number_format($fine->jumlah_denda) }}
                                </td>

                                <td class="dibayar">
                                    Rp {{ number_format($fine->dibayar) }}
                                </td>

                                <td class="sisa">
                                    Rp {{ number_format($fine->sisa_denda) }}
                                </td>

                                {{-- PAYMENT FORM --}}
                                <td>
                                    <form class="pay-form d-flex gap-2 align-items-center"
                                        data-id="{{ $fine->fines_id }}">

                                        @csrf

                                        <input type="number"
                                            name="bayar"
                                            class="form-control form-control-sm bayar-input"
                                            style="width:120px;"
                                            step="1000"
                                            min="1000"
                                            placeholder="Cicilan">

                                        <button type="submit" class="btn btn-sm btn-primary">
                                            Bayar
                                        </button>

                                    </form>
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
                                <td colspan="7" class="text-center py-5 text-muted">
                                    Belum ada data denda.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script>
document.querySelectorAll('.pay-form').forEach(form => {

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const id = this.dataset.id;
        const bayar = this.querySelector('.bayar-input').value;

        if (!bayar) {
            alert('Masukkan nominal');
            return;
        }

        const res = await fetch(`/api/denda/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ bayar })
        });

        const data = await res.json();

        if (!res.ok) {
            alert(data.message || 'Error');
            return;
        }

        const row = this.closest('tr');

        row.querySelector('.dibayar').innerText = `Rp ${data.dibayar}`;
        row.querySelector('.sisa').innerText = `Rp ${data.sisa_denda}`;

        const badge = row.querySelector('.badge');
        badge.className = `badge bg-${data.status_color}`;
        badge.innerText = data.status_label;
    });

});
</script>

@endsection