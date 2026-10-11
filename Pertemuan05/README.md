# Pertemuan 5 — Basis Data, Model Data, Migration, Seeder, dan CRUD

**Proyek:** Kampus Lost & Found
**Mata Kuliah:** Praktik Aplikasi Web (INF60295) — Semester 5
**Dosen Pengampu:** Zaenal Mustofa, M.Kom.
**Program Studi:** Teknologi Informasi — S1, Fakultas Teknik, Universitas Negeri Yogyakarta
**Tanggal revisi:** 11 Oktober 2026

## Ringkasan

Antarmuka Pertemuan 4 dihubungkan dengan basis data. Data barang tidak lagi berupa array statis, dan form klaim menyimpan record sungguhan. Relasi one-to-many diterapkan antara barang temuan dan klaim.

## Penyesuaian Studi Kasus

Modul memakai studi kasus peminjaman ruang dengan tabel `rooms` dan `bookings`. Proyek ini memakai studi kasus pelaporan barang hilang, sehingga dipetakan sebagai berikut. Seluruh capaian yang diminta modul tetap terpenuhi.

| Modul | Proyek ini | Keterangan |
| --- | --- | --- |
| `rooms` | `items` | Barang temuan yang dilaporkan |
| `bookings` | `claims` | Pengajuan klaim atas barang |
| 1 Room — N Booking | 1 Item — N Claim | Relasi `hasMany` dan `belongsTo` |
| Validasi kapasitas peserta | Validasi jalur barang | Hanya barang jalur posko berstatus aktif yang dapat diklaim |
| Pencegahan bentrok jadwal | Pencegahan klaim ganda | Satu pengklaim tidak boleh memiliki dua klaim berjalan (AC-07.2) |

Lost & Found tidak memiliki dimensi waktu yang dapat bertabrakan, sehingga aturan bisnis pada Praktikum 6 digantikan padanannya yang setara dari acceptance criteria Pertemuan 2.

## Struktur Data

```
items (1) ──< claims (N)
```

Rincian kolom, tipe, dan aturan turunan ada pada `01-data-model.md`.

## Cara Menjalankan

```bash
php artisan migrate:fresh --seed
php artisan serve
```

Memeriksa isi tabel:

```bash
php artisan tinker
>>> App\Models\Item::count();
>>> App\Models\Claim::with('item')->get();
```

## CRUD yang Tersedia

| Entitas | Create | Read | Update | Delete |
| --- | --- | --- | --- | --- |
| Barang temuan | `/barang/tambah` | `/barang`, `/barang/{id}`, `/barang/kelola` | `/barang/{id}/ubah` | Tombol Hapus pada kelola barang |
| Klaim | `/klaim/buat?item={id}` | `/klaim`, `/posko`, `/posko/{id}` | `/klaim/{id}/ubah` | Tombol Batalkan klaim |

Keputusan petugas bukan operasi CRUD biasa, melainkan perubahan status yang memicu efek berantai: menyetujui satu klaim mengubah status barang menjadi menunggu pengambilan dan menolak otomatis seluruh klaim lain atas barang yang sama.

## Validasi dan Aturan Bisnis

| Aturan | Tempat | Dasar |
| --- | --- | --- |
| Nama, kategori, lokasi, fakultas, dan waktu penemuan wajib diisi | `ItemController::validateItem()` | — |
| Waktu penemuan tidak boleh di masa depan | `ItemController::validateItem()` | AC-02.4 |
| Ciri detail wajib, minimal 20 karakter | `ItemController::validateItem()` | AC-04.3 |
| Deskripsi kepemilikan wajib, minimal 25 karakter | `ClaimController::store()` | — |
| Hanya barang jalur posko berstatus aktif yang dapat diklaim | `ClaimController::store()` | AC-07.1, AC-03.4 |
| Satu pengklaim tidak boleh punya dua klaim berjalan | `ClaimController::store()` | AC-07.2 |
| Alasan wajib diisi saat menolak | `PoskoController::reject()` | AC-09.2 |
| Klaim yang sudah diputuskan tidak dapat diputuskan ulang | `PoskoController::approve()`, `reject()` | AC-09.3 |
| Klaim atas barang fakultas lain tidak dapat diakses | `PoskoController` | AC-08.3 |

## Daftar Artefak

| Berkas | Isi | Status |
| --- | --- | --- |
| `01-data-model.md` | Pemetaan field antarmuka ke kolom, struktur tabel, aturan turunan | Selesai |
| `02-migration-model/` | Salinan migration dan model | Lihat `database/migrations/` dan `app/Models/` |
| `03-seeder.md` | Isi data awal dan cara menjalankan | Selesai |
| `04-crud-room/` | CRUD barang | Lihat `app/Http/Controllers/ItemController.php` |
| `05-crud-booking/` | CRUD klaim | Lihat `app/Http/Controllers/ClaimController.php` |
| `06-test-checklist.md` | Empat belas skenario uji end-to-end | Perlu diisi hasilnya |
| `07-screenshots.pdf` | Bukti tabel sebelum dan sesudah operasi CRUD | **Perlu diambil** |
| `README.md` | Dokumen ini | Selesai |

Folder `02-migration-model/`, `04-crud-room/`, dan `05-crud-booking/` pada struktur modul tidak diduplikasi, karena berkas sumbernya sudah berada di lokasi standar Laravel dan menyalinnya justru menciptakan dua versi yang dapat berbeda. Tabel di atas menunjuk langsung ke lokasi aslinya.

## Catatan Penggunaan AI

| Aspek | Keterangan |
| --- | --- |
| Perangkat AI | Claude (Anthropic) |
| Bentuk bantuan | Menulis migration, model, seeder, controller, route, dan validasi berdasarkan acceptance criteria yang disusun penulis pada Pertemuan 2; menyusun dokumentasi |
| Keputusan yang ditetapkan penulis | Pemetaan studi kasus modul ke studi kasus kelompok; penetapan aturan klaim ganda sebagai padanan aturan bentrok jadwal |
| Pengujian | Dijalankan dan diperiksa penulis di browser dan pada tabel basis data |

## Commit

```
feat: add item and claim database schema
feat: implement item crud
feat: implement claim submission and posko verification
feat: add business rule for duplicate running claims
```
