# TODO - Fix Login/Logout Page Expired (419)

## Step 1 (done: partial)
- Cek routes: login/logout memang POST + @csrf.
- Cek AuthenticatedSessionController: session regenerate/invalidate sudah ada.
- Cek config: session driver default = database, cookie same_site = lax.
- Kernel.php tidak ada (menggunakan Laravel bootstrap middleware baru), jadi kita fokus ke routes & middleware default.

## Step 2 (done)
- Pastikan logout selalu route('logout') dan pakai @csrf.

## Step 3 (next)
- Perbaiki sumber 419 yang paling mungkin: session cookie/redirect loop karena "dashboard" route name/tampilan.

## Step 4
- Uji manual:
  - Login -> dashboard (tanpa 419)
  - Logout -> login (tanpa 419)
  - Daftar -> login (redirect benar)


