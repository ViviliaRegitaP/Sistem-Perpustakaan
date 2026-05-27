# TODO

- [ ] Perbaiki perhitungan hari terlambat dan total denda di `kelola-denda` agar tidak menghasilkan desimal.
- [ ] Samakan logic pembulatan integer antara tampilan (`resources/views/admin/kelola-denda.blade.php`) dan proses penyimpanan (`app/Http/Controllers/FineController.php`).
- [ ] Pastikan format rupiah tetap rapi dan nilai tampilannya sesuai contoh: 1 Hari → Rp2.000, 5 Hari → Rp10.000, 7 Hari → Rp14.000.

