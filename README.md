# Inventaris Laboratorium - UTS PBO

Aplikasi pengelolaan inventaris sederhana menggunakan **Laravel 13**, PHP 8.3+, Blade Template, dan session sebagai penyimpanan data. Aplikasi ini tidak menggunakan database dan mengikuti alur **Route -> Controller -> Blade**.

## Fitur

- Menampilkan daftar barang beserta kode, nama, kategori, lokasi, jumlah, kondisi, dan aksi.
- Menambah data dengan validasi dan pemeriksaan kode duplikat.
- Melihat detail barang berdasarkan kode.
- Mengubah informasi barang dengan nilai awal dari data tersimpan.
- Menghapus barang dengan konfirmasi pada browser.
- Pencarian sederhana berdasarkan kode, nama, kategori, lokasi, atau kondisi.
- Pesan sukses/informasi dan penanganan data yang tidak ditemukan.

## Persyaratan

- PHP >= 8.3 beserta ekstensi PHP yang dipersyaratkan Laravel 13.
- Composer.
- Laravel Framework 13.x (dipasang melalui Composer berdasarkan `composer.json`).

## Cara menjalankan

1. Ekstrak folder proyek.
2. Buka terminal pada folder proyek.
3. Pasang dependency:

   ```bash
   composer install
   ```

4. Salin `.env.example` menjadi `.env` (Windows PowerShell: `Copy-Item .env.example .env`; macOS/Linux: `cp .env.example .env`).
5. Buat application key:

   ```bash
   php artisan key:generate
   ```

6. Pastikan `.env` berisi `SESSION_DRIVER=file`.
7. Pastikan folder `storage/framework/sessions`, `storage/framework/views`, dan `storage/logs` dapat ditulisi oleh PHP.
8. Jalankan server:

   ```bash
   php artisan serve
   ```

9. Buka `http://127.0.0.1:8000/example`.

> Tidak perlu menjalankan migrasi karena aplikasi tidak menggunakan database. Data disimpan per session browser dan data contoh diinisialisasi saat session pertama kali membuka halaman daftar.

## Daftar route

| HTTP | URI | Nama route | Controller |
|---|---|---|---|
| GET | `/example` | `example.index` | `index` |
| GET | `/example/create` | `example.create` | `create` |
| POST | `/example` | `example.store` | `store` |
| GET | `/example/{kode}` | `example.show` | `show` |
| GET | `/example/{kode}/edit` | `example.edit` | `edit` |
| PUT/PATCH | `/example/{kode}` | `example.update` | `update` |
| DELETE | `/example/{kode}` | `example.destroy` | `destroy` |

Route statis `/example/create` didaftarkan sebelum route dinamis `/example/{kode}`. Untuk melihat route aktual setelah dependency terpasang, jalankan:

```bash
php artisan route:list
```

## Struktur file penting

```text
app/Http/Controllers/Controller.php
app/Http/Controllers/ExampleController.php
bootstrap/app.php
config/session.php
routes/web.php
resources/views/layouts/app.blade.php
resources/views/examples/index.blade.php
resources/views/examples/create.blade.php
resources/views/examples/edit.blade.php
resources/views/examples/show.blade.php
resources/views/examples/_form.blade.php
public/css/app.css
```

## Pengujian

Setelah dependency terpasang, jalankan:

```bash
php artisan test
```

Test feature disediakan untuk halaman daftar, proses tambah, penolakan kode duplikat, dan penanganan kode yang tidak ditemukan. Lakukan juga uji manual untuk edit, detail, hapus, validasi, dan pencarian.

## Catatan penyimpanan

Data hanya disimpan pada session file masing-masing pengunjung. Data tidak menjadi arsip permanen lintas perangkat/browser dan dapat hilang saat session kedaluwarsa atau data session dibersihkan. Pendekatan ini dipilih untuk memenuhi instruksi UTS yang melarang kewajiban database.
