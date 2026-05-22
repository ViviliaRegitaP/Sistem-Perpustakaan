# TODO - Perbaikan Sidebar & Dashboard (Data Buku Acak/Tidak Lengkap)

## Informasi yang sudah didapat
- Sidebar/menu di `resources/views/layouts/app.blade.php` menampilkan link berbeda untuk admin vs anggota.
- Dashboard anggota (`/dashboard`) diambil via closure di `routes/web.php` dan mengirim variabel: `$totalBuku`, `$totalStok`, `$recent`.
- Dashboard anggota (`resources/views/dashboard.blade.php`) menggunakan `$recent` dengan `@forelse`.
- Ada indikasi bahwa beberapa tampilan memakai query langsung `\App\Models\Buku::...` tanpa parameter yang konsisten.
- Relasi kategori di `app/Models/Buku.php` menggunakan `belongsTo(Kategori::class, 'kategori_id')`.

## Root cause yang paling mungkin
- Layout/komponen menampilkan CSS/HTML yang bentrok (misal `style` tumpang tindih atau markup `<td>`/`<tr>` tidak sesuai).
- Di hasil pencarian terlihat ada potongan markup rusak pada dashboard anggota sebelumnya (kemungkinan file lain yang masih tersisa/terpotong atau class `.dashboard-card`/`card`/badge menimpa gaya global).

## Plan Perubahan (urut)
1. **Validasi markup**: cek penuh `resources/views/dashboard.blade.php` dan pastikan tag `table/thead/tbody/tr/td` dan `@forelse` tidak ada yang terlepas/berantakan.
2. **Hapus query langsung yang tidak konsisten** (jika ada di view tertentu untuk dashboard anggota/admin): gunakan data yang sudah dikirim dari controller/route.
3. **Perbaiki relasi kategori**: pastikan `kategori_id` tidak null dan relasi `.kategori` sudah tepat; jika perlu tambahkan eager-loading pada `$recent` agar informasi kategori tidak acak saat query.
4. **Rapikan fallback**: sederhanakan expression kategori di view supaya tidak mengandalkan query tambahan per baris.
5. **Rapikan CSS**: kurangi penggunaan selector global seperti `.card{ ... }` atau `.badge{ ... }` agar tidak menimpa komponen lain. Gunakan scoped styles dengan prefix (misal `.dashboard-page ...`).
6. **Validasi sidebar aktif state**: pastikan `request()->is('daftar-buku')` & `request()->is('bukus*')` sesuai dengan route yang dipakai (`/daftar-buku`, `bukus.index` biasanya `/bukus`).
7. Jalankan migrasi/cek seeder (opsional) bila data kategori tidak masuk.

## Dependent files yang kemungkinan akan diedit
- `resources/views/dashboard.blade.php`
- `resources/views/layouts/app.blade.php`
- `routes/web.php`
- (opsional) `app/Models/Buku.php` dan/atau view admin

## Follow-up steps setelah edit
- Refresh halaman dashboard untuk admin dan anggota.
- Cek urutan tabel “buku terbaru” (harusnya berdasarkan `latest()` = `created_at`).
- Cek kolom kategori/penulis/stok tampil lengkap dan tidak tertukar.

