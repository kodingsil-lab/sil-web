# Workflow Local -> Repo -> Hosting

Repo ini dipakai sebagai sumber utama untuk kode custom WordPress:

- `wp-content/themes/sil-portfolio`
- `wp-content/plugins/sil-core`

Supaya hasil lokal dan live tetap sama, workflow yang dipakai bukan hanya `git push`, karena WordPress juga bergantung pada:

- database
- folder `wp-content/uploads`
- konfigurasi environment seperti `wp-config.php`

## Prinsip kerja

1. Perbaikan dilakukan di lokal.
2. Kode custom di-commit dan di-push ke repo.
3. Untuk deploy ke hosting, kirim:
   - theme/plugin terbaru dari repo
   - database export terbaru
   - uploads terbaru bila ada media baru

## Yang masuk Git

- theme custom
- plugin custom
- file workflow/deploy

## Yang tidak masuk Git

- WordPress core
- `wp-config.php`
- `wp-content/uploads`
- `node_modules`
- cache dan file sementara

## Workflow harian yang disarankan

### 1. Saat mengubah tampilan / fitur

Lakukan perubahan di lokal, lalu:

```powershell
git add .
git commit -m "Deskripsi perubahan"
git push origin main
```

### 2. Saat ingin deploy ke hosting

Jalankan script berikut dari root project:

```powershell
.\scripts\create-release-package.ps1
```

Script ini akan:

- build CSS final theme
- export database lokal ke folder `deploy`
- membuat ZIP theme
- membuat ZIP plugin
- membuat ZIP uploads

Hasilnya akan ada di folder `deploy/`.

## Isi folder deploy

Biasanya akan berisi:

- `database-YYYYMMDD-HHMMSS.sql`
- `sil-portfolio-theme-YYYYMMDD-HHMMSS.zip`
- `sil-core-plugin-YYYYMMDD-HHMMSS.zip`
- `uploads-YYYYMMDD-HHMMSS.zip`

## Cara pakai di hosting

### Opsi A: update kode saja

Pakai saat hanya ada perubahan theme/plugin, tanpa perubahan media besar dan tanpa perubahan konten admin penting.

1. Upload ZIP theme ke hosting, lalu ekstrak ke:
   - `wp-content/themes/sil-portfolio`
2. Upload ZIP plugin ke hosting, lalu ekstrak ke:
   - `wp-content/plugins/sil-core`

### Opsi B: samakan live dengan lokal

Pakai saat Anda ingin kondisi live benar-benar mengikuti lokal.

1. Backup hosting terlebih dahulu.
2. Upload theme terbaru.
3. Upload plugin terbaru.
4. Import file SQL terbaru ke database hosting.
5. Sinkronkan folder `uploads`.
6. Pastikan `wp-config.php` hosting mengarah ke database yang benar.
7. Login admin dan cek permalink, homepage, portfolio, dan halaman kontak.

## Catatan penting

- `git push` saja tidak cukup untuk membuat site live sama persis dengan lokal.
- Kalau Anda mengubah halaman, menu, ACF/native options, post, media, atau setting WordPress, perubahan itu tersimpan di database.
- Kalau Anda upload gambar baru, file itu tersimpan di `wp-content/uploads`.

## Rekomendasi aman

- Pakai repo ini untuk source of truth kode.
- Pakai paket `deploy/` untuk sinkronisasi konten dan media.
- Selalu backup hosting sebelum import database atau overwrite uploads.
