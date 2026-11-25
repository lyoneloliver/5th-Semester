# Toko Online — CodeIgniter 4

Project tugas PBKK menggunakan pola MVC.

## Kebutuhan
- PHP 8.1 atau lebih baru
- Composer
- MySQL / MariaDB
- Ekstensi PHP: intl, mbstring, mysqli, json, xml

## Instalasi
1. Buat project CI4 baru atau gunakan folder ini sebagai source project.
2. Jalankan `composer install`.
3. Salin `.env.example` menjadi `.env`.
4. Buat database sesuai nama pada `.env`, lalu import `database/schema.sql`.
5. Jalankan `php spark serve`.
6. Buka `http://localhost:8080`.

## Struktur MVC
- `app/Controllers`: menerima request dan mengatur alur aplikasi.
- `app/Models`: komunikasi dengan database.
- `app/Views`: tampilan HTML/Bootstrap.
- `database/schema.sql`: struktur dan data awal database.

## Catatan
Folder `vendor/` tidak disertakan. Composer akan mengunduh dependency saat `composer install`.
