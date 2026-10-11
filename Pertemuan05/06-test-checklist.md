# Checklist Uji End-to-End

Kampus Lost & Found • Purbaya Dwipananda Arrizky (24051130060) • Praktik Aplikasi Web (INF60295) • Teknologi Informasi, Fakultas Teknik UNY • 2026

Setiap baris diuji dari browser, lalu diperiksa kembali pada tabel database
melalui phpMyAdmin, DBeaver, atau `php artisan tinker`.

| No. | Skenario                                 | Bukti yang dicek                                                                       | Hasil         |
| --- | ---------------------------------------- | -------------------------------------------------------------------------------------- | ------------- | ----- |
| 1   | Daftar barang tampil di `/barang`        | Jumlah kartu sama dengan jumlah baris `items` berstatus aktif                          | Belum / Sudah | Sudah |
| 2   | Tambah barang lewat `/barang/tambah`     | Record baru terbentuk, `route` terisi otomatis dari kategori                           | Belum / Sudah | Sudah |
| 3   | Edit barang                              | Nilai berubah di tabel `items`                                                         | Belum / Sudah | Sudah |
| 4   | Hapus barang                             | Record hilang, klaim terkaitnya ikut terhapus                                          | Belum / Sudah | Sudah |
| 5   | Kirim klaim valid                        | Record `claims` terbentuk dengan status `menunggu`                                     | Belum / Sudah | Sudah |
| 6   | Deskripsi kurang dari 25 karakter        | Validasi menolak dan menandai field                                                    | Belum / Sudah | Sudah |
| 7   | Klaim ganda oleh pengklaim yang sama     | Aturan bisnis menolak, pesan menyebut barang yang sedang diklaim                       | Belum / Sudah | Sudah |
| 8   | Klaim pada barang jalur penemu           | Tombol Ajukan klaim tidak tersedia; akses langsung dialihkan                           | Belum / Sudah | Sudah |
| 9   | Setujui klaim                            | Status klaim `disetujui`, barang `menunggu_pengambilan`, klaim lain `ditolak_otomatis` | Belum / Sudah | Sudah |
| 10  | Tolak tanpa alasan                       | Validasi menolak dengan pesan pada field alasan                                        | Belum / Sudah | Sudah |
| 11  | Buka kembali klaim yang sudah diputuskan | Tombol Setujui dan Tolak hilang, jejak keputusan tampil                                | Belum / Sudah | Sudah |
| 12  | Klaim fakultas lain                      | Tidak muncul di `/posko`; akses langsung mengembalikan 404                             | Belum / Sudah | Sudah |
| 13  | Edit dan hapus klaim                     | Perubahan tersimpan; record hilang setelah dihapus                                     | Belum / Sudah | Sudah |
| 14  | Responsif mobile pada 390 px             | Form dan tabel tidak meluber, tombol utama melebar penuh                               | Belum / Sudah | Sudah |

## Skenario aturan bisnis klaim ganda

Padanan tabel bentrok jadwal pada modul, disesuaikan dengan studi kasus Lost & Found.

| Kasus | Pengklaim | Klaim berjalan                     | Klaim baru                                 | Hasil                                  |
| ----- | --------- | ---------------------------------- | ------------------------------------------ | -------------------------------------- |
| A     | Dinda     | Tidak ada                          | Dompet cokelat                             | Diterima                               |
| B     | Dinda     | Kunci motor Honda, status menunggu | Dompet cokelat                             | Ditolak                                |
| C     | Dinda     | Kunci motor Honda, status ditolak  | Dompet cokelat                             | Diterima                               |
| D     | Rangga    | Tidak ada                          | Kunci motor Honda yang sudah diklaim Dinda | Diterima, keduanya menunggu verifikasi |

Kasus D sengaja diizinkan: dua orang boleh mengklaim barang yang sama, dan petugas yang
memutuskan siapa pemiliknya. Begitu satu klaim disetujui, klaim lain berubah menjadi
ditolak otomatis sesuai AC-09.1.
