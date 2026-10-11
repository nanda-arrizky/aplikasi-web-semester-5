# Inventaris Komponen UI

Kampus Lost & Found • Purbaya Dwipananda Arrizky (24051130060) • Praktik Aplikasi Web (INF60295) • Teknologi Informasi, Fakultas Teknik UNY • 2026

Komponen dibuat sebagai Blade anonymous component di `resources/views/components/`.
Setiap komponen memakai design token dan tidak menuliskan nilai visual sendiri.

## A. Daftar komponen

| Komponen | Berkas | Parameter | Dipakai di |
| --- | --- | --- | --- |
| Button | `components/button.blade.php` | `variant`, `size`, `href`, `block`, `disabled` | Seluruh halaman |
| Form field | `components/field.blade.php` | `name`, `label`, `type`, `value`, `placeholder`, `hint`, `optional`, `required`, `textarea`, `rows` | H-02, H-04, form barang, H-07 |
| Select | `components/select.blade.php` | `name`, `label`, `options`, `value`, `empty`, `hint`, `optional`, `required` | H-02, form barang |
| Status badge | `components/badge.blade.php` | `tone` | H-02, H-03, H-05, H-06, kelola barang |
| Item card | `components/item-card.blade.php` | `item` | H-02 |
| Empty state | `components/empty-state.blade.php` | `title`, slot `action` | H-02, H-05, H-06, kelola barang |
| Layout | `components/layouts/app.blade.php` | `title`, slot | Seluruh halaman |

## B. State setiap komponen

### Button

| State | Perwujudan | Kriteria pemeriksaan |
| --- | --- | --- |
| default | `btn--primary` latar `#2563EB`, teks putih | Label berupa kata kerja: Cari, Ajukan klaim, Kirim klaim, Setujui klaim |
| hover | Latar menggelap ke `#1D4FD7` | Perubahan terlihat tanpa menggeser tata letak |
| focus | Cincin fokus `--focus-ring` | Terlihat saat navigasi keyboard dengan Tab |
| disabled | Opasitas 0,45 dan kursor terlarang | Dipakai pada tombol Lapor Kehilangan di beranda |
| secondary | Latar putih, garis tepi abu | Aksi pendamping: Batal, Lihat, Ubah |
| danger | Latar `--color-danger-soft` | Aksi merusak: Hapus, Tolak klaim, Batalkan klaim |

### Form field

| State | Perwujudan | Kriteria pemeriksaan |
| --- | --- | --- |
| empty | Placeholder abu, teks bantuan di bawah | Label selalu ada, tidak mengandalkan placeholder sebagai label |
| focus | Garis tepi biru dan cincin fokus | Terlihat jelas pada latar putih |
| filled | Teks berwarna `--color-text` | Nilai lama dipertahankan melalui `old()` saat validasi gagal |
| error | Garis tepi merah, pesan di bawah field, `aria-invalid` dan `aria-describedby` | Pesan menjelaskan cara memperbaiki, bukan sekadar menyatakan salah |

Penanda opsional melekat pada label dalam bentuk kata "(opsional)". Tidak ada keterangan
tambahan di bawah kolom, karena satu penanda sudah cukup dan pengulangan justru menambah
beban baca.

### Item card

| State | Perwujudan | Kriteria pemeriksaan |
| --- | --- | --- |
| normal | Kartu putih, dapat diklik, chip jalur di kanan bawah | Nama barang, lokasi, tanggal, dan jalur terbaca sekaligus |
| hover | Garis tepi menguat | Menandakan kartu dapat diklik |
| unavailable | Opasitas 0,6 dan tidak dapat diklik | Dipakai untuk barang berstatus menunggu pengambilan |

Kartu tidak memuat foto. Menampilkan foto pada postingan publik akan menghapus dasar
verifikasi dua tahap, karena siapa pun dapat menyebutkan ciri yang terlihat di gambar.

### Status badge

| State | Tone | Teks |
| --- | --- | --- |
| pending | `badge--pending` | Menunggu verifikasi |
| approved | `badge--approved` | Menunggu pengambilan |
| rejected | `badge--rejected` | Ditolak |
| review | `badge--review` | Perlu ditinjau |
| route | `badge--route` | Jalur posko / Jalur penemu |

Setiap badge memuat teks. Warna berfungsi mempercepat pemindaian, bukan menggantikan teks.

## C. Pengurangan pengulangan

| Komponen | Jumlah pemakaian | Perkiraan baris yang dihemat |
| --- | --- | --- |
| Button | 28 pemakaian di 11 halaman | Sekitar 110 baris |
| Form field | 19 pemakaian | Sekitar 150 baris, terutama penanganan error dan `old()` |
| Status badge | 14 pemakaian | Sekitar 40 baris |
| Layout | 11 halaman | Sekitar 300 baris header, navigasi, dan footer |

Komponen yang paling banyak mengurangi pengulangan adalah `field`, karena satu komponen
menangani label, isian, pesan error, penanda opsional, atribut aksesibilitas, dan
pemulihan nilai lama sekaligus.
