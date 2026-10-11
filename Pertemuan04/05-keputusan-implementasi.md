# Keputusan Implementasi

Kampus Lost & Found • Purbaya Dwipananda Arrizky (24051130060) • Praktik Aplikasi Web (INF60295) • Teknologi Informasi, Fakultas Teknik UNY • 2026

Keputusan teknis yang diambil saat menerjemahkan wireframe Pertemuan 3 menjadi kode,
beserta alasan dan alternatif yang ditolak.

| No. | Keputusan | Alternatif | Alasan |
| --- | --- | --- | --- |
| 1 | CSS ditulis manual sebagai custom properties di `public/css/app.css`, bukan memakai Tailwind yang sudah terpasang | Memakai Tailwind 4 beserta `@theme` | Rubrik menilai kejelasan design token. CSS variables lebih terbaca sebagai bukti design system daripada rangkaian kelas utilitas. Selain itu Tailwind memerlukan `npm install` dan proses build, satu lapis tambahan yang dapat gagal saat penilaian |
| 2 | Stylesheet diletakkan di `public/` dan dipanggil dengan `asset()`, bukan di `resources/` melalui Vite | Pipeline Vite | Aplikasi cukup dijalankan dengan `php artisan serve` tanpa proses build. Dosen dapat membuka proyek tanpa menjalankan Node |
| 3 | Komponen dibuat sebagai Blade anonymous component | Class-based component atau Livewire | Anonymous component cukup untuk kebutuhan tampilan, tanpa menambah berkas kelas. Livewire berada di luar lingkup modul |
| 4 | Jalur penanganan dan masa tayang diturunkan dari kategori di model, bukan diisi manual pada form | Kolom pilihan terpisah pada form | AC-03.3 dan AC-03.4 menetapkan jalur sebagai konsekuensi kategori. Menjadikannya isian manual membuka peluang data tidak konsisten |
| 5 | Nama tabel memakai `items` dan `claims`, bukan `rooms` dan `bookings` seperti contoh modul | Mengikuti penamaan modul | Studi kasus kelompok adalah pelaporan barang hilang. Relasi one-to-many yang diminta modul tetap terpenuhi: satu barang memiliki banyak klaim |
| 6 | Aturan bisnis bentrok jadwal pada modul digantikan aturan klaim ganda | Membuat aturan jadwal buatan | Lost & Found tidak memiliki dimensi waktu yang dapat bertabrakan. AC-07.2 dari Pertemuan 2 adalah padanan yang setara: satu pengklaim tidak boleh memiliki dua klaim berjalan sekaligus |
| 7 | Fakultas petugas disimulasikan sebagai konstanta di `PoskoController` | Menunggu autentikasi pada pertemuan berikutnya | AC-08.3 perlu dapat diperagakan sekarang. Konstanta memungkinkan pembatasan lintas fakultas diuji tanpa modul autentikasi |
| 8 | Paginasi tidak dipakai; seluruh hasil ditampilkan | `paginate()` bawaan Laravel | Tampilan paginasi bawaan Laravel bergantung pada kelas Tailwind yang tidak dipakai di proyek ini, sehingga akan tampil tanpa gaya. Jumlah data contoh juga belum memerlukan paginasi |
| 9 | Tombol Lapor Kehilangan pada beranda digambar namun dinonaktifkan | Menghapus tombol, atau menghubungkannya ke halaman kosong | Tombol merupakan bagian struktur beranda yang sudah disepakati pada Pertemuan 3. Menonaktifkannya dengan penanda di luar lingkup lebih jujur daripada tautan yang membawa ke halaman kosong |
| 10 | Kartu barang tidak memuat foto | Menambahkan unggahan foto | Foto pada postingan publik menghapus dasar verifikasi dua tahap, karena ciri yang terlihat di gambar dapat disebutkan siapa pun |

## Perubahan dari prototipe Pertemuan 3

| Bagian | Pada prototipe | Pada implementasi | Alasan |
| --- | --- | --- | --- |
| Keterangan lokasi opsional | Tertulis "Boleh dikosongkan" di bawah kolom | Hanya kata "(opsional)" pada label | Menghindari pengulangan penanda yang sama dua kali |
| Pencarian pada beranda | Kolom teks bebas | Terhubung ke filter lokasi pada H-02 | Memanfaatkan filter yang sudah ada alih-alih membuat mesin pencari terpisah |
| Panel aksi H-03 | Kolom samping tetap | Berpindah ke bawah pada layar di bawah 820 px | Tombol utama perlu berada dalam jangkauan ibu jari |
| Tabel klaim H-06 | Empat kolom | Lima kolom dengan kolom aksi | Tombol Tinjau perlu tempat tersendiri agar baris tetap terbaca |

## Pemetaan struktur folder

Modul menyebut struktur `assets/ styles/ scripts/ components/ pages/ docs/` yang ditujukan
untuk proyek HTML statis. Pada proyek Laravel, padanannya sebagai berikut.

| Modul | Proyek ini |
| --- | --- |
| `assets/` | `public/` |
| `styles/` | `public/css/app.css` |
| `scripts/` | Belum diperlukan; tidak ada JavaScript kustom |
| `components/` | `resources/views/components/` |
| `pages/` | `resources/views/{home, items, claims, posko, errors}/` |
| `docs/` | `Pertemuan04/` dan `Pertemuan05/` |
