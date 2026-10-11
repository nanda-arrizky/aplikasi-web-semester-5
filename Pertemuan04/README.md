# Pertemuan 4 — Design System, Struktur Proyek, Komponen UI, dan Implementasi Antarmuka Awal

**Proyek:** Kampus Lost & Found
**Mata Kuliah:** Praktik Aplikasi Web (INF60295) — Semester 5
**Dosen Pengampu:** Zaenal Mustofa, M.Kom.
**Program Studi:** Teknologi Informasi — S1, Fakultas Teknik, Universitas Negeri Yogyakarta
**Tanggal revisi:** 11 Oktober 2026

## Ringkasan

Pertemuan ini menerjemahkan wireframe dan prototipe Pertemuan 3 menjadi halaman web yang dapat dijalankan. Aturan visual ditetapkan sebagai design token, komponen antarmuka dibuat sebagai Blade component yang dapat digunakan ulang, dan delapan halaman dari sitemap diimplementasikan.

Stack: **Laravel 13.17** dengan **PHP 8.3**. Styling memakai CSS custom properties tanpa framework, sehingga aplikasi berjalan tanpa proses build.

## Anggota dan Kontribusi

| Nama | NIM | Kontribusi |
| --- | --- | --- |
| Purbaya Dwipananda Arrizky | 24051130060 | Seluruh pekerjaan. Proyek dikerjakan mandiri atas persetujuan dosen pengampu. |

## Cara Menjalankan

```bash
# 1. Pasang dependensi PHP
composer install

# 2. Siapkan berkas lingkungan
cp .env.example .env
php artisan key:generate

# 3. Pilih basis data — lihat bagian Konfigurasi Database di bawah

# 4. Jalankan migration dan isi data awal
php artisan migrate --seed

# 5. Jalankan server
php artisan serve
```

Buka `http://127.0.0.1:8000`.

### Konfigurasi database

**Opsi A — MySQL** (sesuai modul). Buat database `kampus_lost_found` lewat phpMyAdmin atau Laragon, lalu isi `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kampus_lost_found
DB_USERNAME=root
DB_PASSWORD=
```

**Opsi B — SQLite** (tanpa pemasangan tambahan). Isi `.env`:

```
DB_CONNECTION=sqlite
```

Lalu buat berkasnya: `touch database/database.sqlite` — atau di PowerShell, `New-Item database/database.sqlite`.

Setelah mengubah `.env`, jalankan `php artisan config:clear`.

### Bahasa tanggal

Agar nama bulan tampil dalam bahasa Indonesia, ubah `.env`:

```
APP_LOCALE=id
```

## Halaman yang Diimplementasikan

| ID | Halaman | Route | Berkas |
| --- | --- | --- | --- |
| H-01 | Beranda | `/` | `resources/views/home.blade.php` |
| H-02 | Cari barang | `/barang` | `resources/views/items/index.blade.php` |
| H-03 | Detail barang | `/barang/{id}` | `resources/views/items/show.blade.php` |
| H-04 | Form klaim | `/klaim/buat?item={id}` | `resources/views/claims/create.blade.php` |
| H-05 | Klaim saya | `/klaim` | `resources/views/claims/index.blade.php` |
| H-06 | Daftar klaim posko | `/posko` | `resources/views/posko/index.blade.php` |
| H-07 | Detail klaim | `/posko/{id}` | `resources/views/posko/show.blade.php` |
| H-08 | Not found | fallback | `resources/views/errors/404.blade.php` |
| — | Kelola barang | `/barang/kelola` | `resources/views/items/manage.blade.php` |
| — | Tambah barang | `/barang/tambah` | `resources/views/items/create.blade.php` |
| — | Ubah barang | `/barang/{id}/ubah` | `resources/views/items/edit.blade.php` |

Modul mensyaratkan minimal dua halaman; sebelas halaman diimplementasikan karena lingkup Pertemuan 5 dikerjakan pada proyek yang sama.

## Struktur Proyek

| Folder | Isi |
| --- | --- |
| `public/css/app.css` | Design token dan seluruh gaya komponen |
| `resources/views/components/` | Komponen UI yang dapat digunakan ulang |
| `resources/views/components/layouts/` | Layout halaman |
| `resources/views/{items,claims,posko,errors}/` | Halaman aplikasi, dinamai sesuai sitemap |
| `app/Models/` | Item dan Claim |
| `app/Http/Controllers/` | ItemController, ClaimController, PoskoController |
| `database/migrations/` | Skema tabel items dan claims |
| `database/seeders/` | Data awal |
| `Pertemuan04/`, `Pertemuan05/` | Dokumentasi |

## Daftar Artefak

| Berkas | Isi | Status |
| --- | --- | --- |
| `01-design-tokens.md` | Warna, tipografi, jarak, radius, layout | Selesai |
| `02-component-inventory.md` | Tujuh komponen beserta state dan kriteria pemeriksaan | Selesai |
| `03-ui-screenshots.pdf` | Tangkapan layar desktop dan mobile | **Perlu diambil** |
| `04-test-checklist.md` | Sepuluh butir pemeriksaan dan cara memunculkan tiap state | Perlu diisi hasilnya |
| `05-keputusan-implementasi.md` | Sepuluh keputusan teknis dan perubahan dari prototipe | Selesai |
| `README.md` | Dokumen ini | Selesai |

## Catatan Penggunaan AI

| Aspek | Keterangan |
| --- | --- |
| Perangkat AI | Claude (Anthropic) |
| Bentuk bantuan | Menulis design token, komponen Blade, halaman, controller, model, migration, dan seeder berdasarkan wireframe serta acceptance criteria yang disusun penulis pada pertemuan sebelumnya; menyusun dokumentasi |
| Keputusan yang ditetapkan penulis | Pemilihan nada biru jenuh atas pertimbangan afordansi; keputusan tidak menampilkan foto pada postingan publik karena merusak dasar verifikasi; pemetaan studi kasus modul ke studi kasus kelompok |
| Pengujian | Dijalankan dan diperiksa penulis di browser |

## Commit

```
feat: add design tokens and reusable blade components
feat: implement item search, detail, and claim pages
docs: add design token and component inventory for pertemuan 4
```
