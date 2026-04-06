# Checklist Deploy Hosting

## Sebelum deploy

- pastikan perubahan di lokal sudah dites
- pastikan `git status` bersih
- jalankan `.\scripts\create-release-package.ps1`
- backup file dan database hosting

## Upload ke hosting

- upload ZIP theme
- upload ZIP plugin
- upload ZIP uploads jika ada media baru
- import SQL terbaru jika ada perubahan konten/admin

## Setelah deploy

- cek homepage
- cek menu sidebar
- cek portfolio archive
- cek detail portfolio
- cek halaman kontak
- cek dark mode
- cek gambar profil dan featured image
- cek permalink bila ada URL yang gagal
