# Seeder dan Data Awal

Kampus Lost & Found • Purbaya Dwipananda Arrizky (24051130060) • Praktik Aplikasi Web (INF60295) • Teknologi Informasi, Fakultas Teknik UNY • 2026

## A. Berkas

| Berkas | Isi |
| --- | --- |
| `database/seeders/ItemSeeder.php` | Delapan barang temuan dengan kategori, jalur, dan masa tayang bervariasi |
| `database/seeders/ClaimSeeder.php` | Tiga klaim mewakili state menunggu, menunggu lebih dari 24 jam, dan ditolak |
| `database/seeders/DatabaseSeeder.php` | Memanggil keduanya berurutan |

## B. Barang temuan

| Nama | Kategori | Jalur | Fakultas | Masa tayang |
| --- | --- | --- | --- | --- |
| Dompet cokelat | Dompet | Posko | Fakultas Teknik | 30 hari |
| Kunci motor Honda | Kunci | Posko | Fakultas Teknik | 30 hari |
| Powerbank hitam | Elektronik | Posko | Fakultas Teknik | 30 hari |
| Kacamata bulat | Lain-lain | Penemu | Fakultas Teknik | 7 hari |
| Botol minum biru | Lain-lain | Penemu | Fakultas Teknik | 7 hari |
| Flashdisk 32GB | Elektronik | Posko | Fakultas Teknik | 30 hari |
| Dompet kartu abu-abu | Dompet | Posko | Fakultas Teknik | 30 hari |
| Jam tangan digital | Elektronik | Posko | Fakultas Ilmu Pendidikan | 30 hari |

Barang terakhir sengaja ditempatkan di fakultas berbeda agar AC-08.3 dapat diperagakan:
klaim atas barang tersebut tidak boleh muncul pada daftar petugas Fakultas Teknik.

## C. Klaim awal

| Pengklaim | Barang | Status | Tujuan peragaan |
| --- | --- | --- | --- |
| Dinda Pramesti | Kunci motor Honda | Menunggu, 3 jam | State normal pada H-05 dan H-06 |
| Rangga Saputra | Dompet cokelat | Menunggu, 30 jam | Tanda Perlu ditinjau (AC-07.2) |
| Ayu Lestari | Powerbank hitam | Ditolak beserta alasan | State ditolak pada H-05 (AC-09.4) |

Ciri tersembunyi dan deskripsi pengklaim pada data Rangga sengaja dibuat cocok,
sedangkan pada data Ayu sengaja dibuat berbeda, agar perbandingan dua panel pada
H-07 dapat diperiksa dalam dua arah.

## D. Menjalankan

```bash
php artisan migrate:fresh --seed
```

Memeriksa hasil:

```bash
php artisan tinker
>>> App\Models\Item::count();
=> 8
>>> App\Models\Claim::count();
=> 3
>>> App\Models\Item::first()->claims;
```
