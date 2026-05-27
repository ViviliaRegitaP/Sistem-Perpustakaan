- [ ] Buat ulang tabel admin `kelola-denda` sesuai spesifikasi (kolom dibayar/sisa dihapus; kolom sesuai: Anggota, Buku, Terlambat, Total Denda, Status, Aksi).
- [ ] Pastikan `Total Denda` selalu dihitung ulang: `hariTerlambat * 2000` dari `tanggal_kembali` (tanpa bergantung `fine->jumlah_denda`).
- [ ] Status hanya 2: Belum Bayar (badge merah) dan Lunas (badge hijau).
- [ ] Hapus tombol Cicil, hapus status ganda, dan hapus logika yang bertumpuk.
- [ ] Aksi hanya: tampil tombol `Lunas` bila belum lunas, jika lunas tampil text `Sudah Dibayar`.
- [ ] Pastikan 1 row hanya ada 1 badge status.
- [ ] Jalankan pengecekan cepat: tidak ada colspan/tabel rusak dan view tidak error.

