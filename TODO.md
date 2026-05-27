- [ ] Memperbarui `app/Http/Controllers/FineController.php` agar query denda hanya berdasarkan `tanggal_kembali < sekarang` tanpa filter status
- [ ] Memastikan Blade `resources/views/anggota/denda.blade.php` tetap pakai perhitungan Carbon diffInDays dan UI tidak berubah
- [ ] Memastikan Blade `resources/views/admin/kelola-denda.blade.php` tetap pakai perhitungan Carbon diffInDays dan UI tidak berubah
- [ ] Jalankan verifikasi manual: buka `/denda` dan `/kelola-denda` untuk memastikan data muncul saat tanggal_kembali sudah lewat

