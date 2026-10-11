# Design Token

Kampus Lost & Found • Purbaya Dwipananda Arrizky (24051130060) • Praktik Aplikasi Web (INF60295) • Teknologi Informasi, Fakultas Teknik UNY • 2026

Seluruh nilai visual aplikasi didefinisikan sebagai CSS custom properties pada blok `:root`
di `public/css/app.css`. Tidak ada nilai warna, jarak, atau radius yang ditulis langsung di
luar blok tersebut; setiap komponen merujuk `var(--nama-token)`.

Token diturunkan dari wireframe Pertemuan 3 dan dari perbandingan dua nada biru yang
diputuskan pada awal Pertemuan 4.

## A. Warna merek

| Token | Nilai | Contoh penggunaan |
| --- | --- | --- |
| `--color-primary` | `#2563EB` | Tombol utama pada setiap halaman, satu per layar |
| `--color-primary-hover` | `#1D4FD7` | Keadaan hover tombol utama |
| `--color-primary-soft` | `#DBEAFE` | Latar chip jalur, panel aksen, pesan informasi |
| `--color-primary-border` | `#7AAEEA` | Garis tepi chip dan panel aksen |
| `--color-primary-text` | `#14427A` | Teks di atas latar lembut, nama aplikasi, tautan |
| `--color-on-primary` | `#FFFFFF` | Teks di atas tombol utama |

Nada biru jenuh dipilih dibanding biru pucat karena afordansi aksi utama lebih jelas,
dan kontras teks putih di atas `#2563EB` melewati ambang keterbacaan dengan margin lebar.

## B. Warna netral

| Token | Nilai | Contoh penggunaan |
| --- | --- | --- |
| `--color-text` | `#2B2B28` | Judul dan isi halaman |
| `--color-text-muted` | `#6E6C66` | Label field, keterangan, teks bantuan |
| `--color-border` | `#DAD8D0` | Garis tepi kartu, field, baris tabel |
| `--color-border-strong` | `#B9B7AD` | Garis tepi tombol sekunder dan keadaan hover |
| `--color-surface` | `#FFFFFF` | Latar kartu dan panel |
| `--color-background` | `#F7F6F2` | Latar halaman |

## C. Warna status

| Token | Nilai | Contoh penggunaan |
| --- | --- | --- |
| `--color-success` / `-soft` / `-border` | `#166534` / `#DCFCE7` / `#86C79B` | Klaim disetujui, pesan berhasil |
| `--color-warning` / `-soft` / `-border` | `#92400E` / `#FEF3C7` / `#E0B860` | Klaim bertanda Perlu ditinjau |
| `--color-danger` / `-soft` / `-border` | `#B3261E` / `#FCE9E6` / `#D4A99E` | Klaim ditolak, pesan validasi, tombol hapus |

Warna tidak pernah menjadi satu-satunya pembeda status. Setiap badge selalu memuat teks
status, sehingga tetap terbaca oleh pengguna dengan gangguan persepsi warna.

## D. Tipografi

| Token | Nilai | Contoh penggunaan |
| --- | --- | --- |
| `--font-sans` | Inter, Segoe UI, system-ui | Seluruh teks aplikasi |
| `--text-display` | 32 px | Judul beranda |
| `--text-title` | 26 px | Judul halaman |
| `--text-section` | 18 px | Judul bagian |
| `--text-body` | 15 px | Isi halaman, isian field |
| `--text-label` | 13 px | Label field, keterangan, meta kartu |
| `--text-caption` | 12 px | Chip status, teks bantuan |

Hanya tiga bobot yang dipakai: `400` reguler, `500` medium untuk label dan tombol,
`700` tebal untuk judul.

## E. Jarak

Skala kelipatan empat, sesuai anjuran modul.

| Token | Nilai | Contoh penggunaan |
| --- | --- | --- |
| `--space-1` | 4 px | Jarak label ke field |
| `--space-2` | 8 px | Jarak antar elemen dalam satu baris |
| `--space-3` | 12 px | Padding dalam field, jarak antar tombol |
| `--space-4` | 16 px | Jarak antar kartu |
| `--space-6` | 24 px | Padding kartu, jarak antar bagian |
| `--space-8` | 32 px | Jarak atas halaman |
| `--space-12` | 48 px | Jarak bawah halaman, padding state kosong |

## F. Radius, garis, dan bayangan

| Token | Nilai | Contoh penggunaan |
| --- | --- | --- |
| `--radius-sm` | 6 px | Cincin fokus |
| `--radius-md` | 8 px | Tombol, field, panel pesan |
| `--radius-lg` | 12 px | Kartu dan tabel |
| `--radius-pill` | 999 px | Badge status |
| `--border-width` | 1 px | Seluruh garis tepi |
| `--shadow-card` | `0 1px 2px rgba(43,43,40,.04)` | Kartu, satu lapis sangat tipis |
| `--focus-ring` | `0 0 0 3px rgba(37,99,235,.28)` | Keadaan fokus keyboard |

## G. Layout

| Token | Nilai | Contoh penggunaan |
| --- | --- | --- |
| `--container-max` | 1200 px | Lebar maksimum isi halaman |
| `--tap-target` | 44 px | Tinggi minimum tombol dan field |

Titik putus responsif tunggal pada 820 px. Di bawah nilai itu seluruh grid berubah menjadi
satu kolom dan tombol utama melebar penuh agar mudah dijangkau ibu jari.
