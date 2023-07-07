<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## APLIKASI SIHONOR - MANAGEMENT HONOR GURU BERDASARKAN JTM

Development By : 
Rafael Nuansa Ramadhon
Mip Saripudin 

Dibuat dengan Laravel 10 

## Dokumentasi Instalasi Lokal

### Langkah 1: Unduh dan Ekstrak Source Code
1. Unduh source code aplikasi.
2. Ekstrak source code ke dalam folder yang diinginkan di komputer Anda.

### Langkah 2: Instalasi Dependensi
1. Buka terminal di direktori aplikasi.
2. Jalankan perintah `composer install` atau `composer update` untuk menginstal dependensi PHP.
3. Setelah itu, jalankan perintah `npm install` untuk menginstal dependensi JavaScript.

### Langkah 3: Konfigurasi .env
1. Duplikat file `.env.example` dan beri nama `.env`.
2. Buka file `.env` dan sesuaikan pengaturan database, appname, dan url sesuai dengan kebutuhan Anda.

### Langkah 4: Migrasi Database dan Seed
1. Jalankan perintah `php artisan migrate:fresh --seed` untuk merefresh database dan memuat data seeder yang terdapat dalam migration.

### Langkah 5: Konfigurasi Storage
1. Hapus folder `storage` yang berada di `app-honor/public/storage`.
2. Jalankan perintah `php artisan storage:link` untuk membuat symlink ke folder storage.

### Langkah 6: Menjalankan Aplikasi
1. Jalankan perintah `php artisan serve` untuk menjalankan aplikasi di lingkungan lokal.

## Persiapan untuk Production / Hosting

### Menghasilkan Asset untuk Produksi
1. Buka terminal di direktori proyek aplikasi.
2. Jalankan perintah `npm run build` untuk menghasilkan semua asset development seperti CSS dan JS.

### Mengunggah ke Hosting
1. Kompres proyek aplikasi ke dalam file zip.
2. Unggah file zip ke hosting Anda.

### Tindakan Tambahan untuk Shared Hosting
1. Jika Anda menggunakan shared hosting, gunakan terminal atau cron job untuk membuat symlink yang menggantikan perintah `php artisan storage`.
