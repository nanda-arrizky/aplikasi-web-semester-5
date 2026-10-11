# Checklist Uji Antarmuka

Kampus Lost & Found • Purbaya Dwipananda Arrizky (24051130060) • Praktik Aplikasi Web (INF60295) • Teknologi Informasi, Fakultas Teknik UNY • 2026

Diisi setelah aplikasi dijalankan pada browser desktop dan mobile view.

| No. | Pemeriksaan                                              | Hasil         | Catatan                                     |
| --- | -------------------------------------------------------- | ------------- | ------------------------------------------- | ----- |
| 1   | Halaman dapat dijalankan dari instruksi README           | Belum / Sudah |                                             | Sudah |
| 2   | Tidak ada error pada console browser                     | Belum / Sudah |                                             | Sudah |
| 3   | Warna, tipografi, jarak, dan radius mengikuti token      | Belum / Sudah | Periksa tidak ada nilai hex di luar `:root` | Sudah |
| 4   | Navigasi dari hasil ke detail dan form berjalan          | Belum / Sudah | H-02 → H-03 → H-04 → H-05                   | Sudah |
| 5   | State kosong, error, dan sukses dapat ditampilkan        | Belum / Sudah | Lihat cara memunculkannya di bawah          | Sudah |
| 6   | Tampilan desktop dan mobile tidak terpotong atau meluber | Belum / Sudah | Uji pada 1440 px dan 390 px                 |
| 7   | Tombol dan field memiliki label yang jelas               | Belum / Sudah | Label tombol berupa kata kerja              | Sudah |
| 8   | Kontras teks dan latar dapat dibaca                      | Belum / Sudah | Teks putih di atas `#2563EB`                | Sudah |
| 9   | Kode komponen tidak diduplikasi tanpa alasan             | Belum / Sudah | Lihat inventaris komponen                   | Sudah |
| 10  | Perubahan sudah di-commit dan didorong ke repositori     | Belum / Sudah |                                             | Belum |

## Cara memunculkan setiap state

| State                                  | Cara                                                                       | Acceptance criteria |
| -------------------------------------- | -------------------------------------------------------------------------- | ------------------- |
| Hasil pencarian kosong                 | Buka `/barang`, pilih kategori Dompet dan isi lokasi dengan teks acak      | AC-06.4             |
| Lokasi opsional tidak mengurangi hasil | Bandingkan jumlah hasil saat lokasi diisi dan dikosongkan                  | AC-06.2             |
| Detail jalur penemu                    | Buka barang berkategori Lain-lain, misalnya Botol minum biru               | AC-03.4             |
| Ciri tersembunyi tidak tampil          | Periksa H-02 dan H-03, tidak ada blok ciri detail                          | AC-03.2, AC-04.2    |
| Validasi form klaim                    | Kirim form klaim dengan deskripsi kurang dari 25 karakter                  | —                   |
| Klaim ganda ditolak                    | Ajukan klaim kedua dengan nama pengklaim yang sama                         | AC-07.2             |
| Klaim bertanda Perlu ditinjau          | Buka `/posko`, klaim Rangga Saputra sudah menunggu 30 jam                  | AC-07.2             |
| Alasan penolakan wajib                 | Tekan Tolak klaim dengan kolom alasan kosong                               | AC-09.2             |
| Tombol hilang setelah diputuskan       | Buka kembali klaim yang sudah disetujui                                    | AC-09.3             |
| Alasan terbaca pengklaim               | Buka `/klaim`, lihat klaim Ayu Lestari                                     | AC-09.4             |
| Klaim fakultas lain tidak tampil       | Jam tangan digital milik Fakultas Ilmu Pendidikan tidak muncul di `/posko` | AC-08.3             |
| Not found                              | Buka alamat yang tidak ada, misalnya `/halaman-salah`                      | —                   |
