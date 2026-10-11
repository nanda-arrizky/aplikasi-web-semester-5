# Model Data dan Pemetaan Antarmuka

Kampus Lost & Found • Purbaya Dwipananda Arrizky (24051130060) • Praktik Aplikasi Web (INF60295) • Teknologi Informasi, Fakultas Teknik UNY • 2026

## A. Pemetaan field antarmuka ke kolom database

Diambil dari halaman H-03 Detail Barang dan H-04 Form Klaim pada Pertemuan 4.

| Antarmuka | Field | Kolom database | Tipe | Wajib |
| --- | --- | --- | --- | --- |
| Detail barang | Nama barang | `items.name` | varchar(255) | Ya |
| Detail barang | Kategori | `items.category` | varchar(255) | Ya |
| Detail barang | Lokasi penemuan | `items.location` | varchar(255) | Ya |
| Detail barang | Fakultas | `items.faculty` | varchar(255) | Ya |
| Detail barang | Waktu penemuan | `items.found_at` | date | Ya |
| Detail barang | Jalur penanganan | `items.route` | varchar(255) | Ya, diturunkan dari kategori |
| Detail barang | Kontak penemu | `items.finder_contact` | varchar(255) | Hanya jalur penemu |
| Tidak tampil | Ciri tersembunyi | `items.hidden_traits` | text | Ya |
| Detail barang | Status barang | `items.status` | varchar(255) | Ya, bawaan `aktif` |
| Detail barang | Masa tayang | `items.expires_at` | date | Diturunkan dari kategori |
| Form klaim | Nama pengklaim | `claims.claimant_name` | varchar(255) | Ya |
| Form klaim | Deskripsi kepemilikan | `claims.ownership_description` | text | Ya, minimal 25 karakter |
| Klaim saya | Status klaim | `claims.status` | varchar(255) | Ya, bawaan `menunggu` |
| Klaim saya | Alasan penolakan | `claims.decision_reason` | text | Wajib saat menolak |
| Detail klaim | Nama pemutus | `claims.decided_by` | varchar(255) | Terisi saat diputuskan |
| Detail klaim | Waktu keputusan | `claims.decided_at` | timestamp | Terisi saat diputuskan |

Field `hidden_traits` berada pada tabel yang sama dengan data publik namun tidak pernah
diteruskan ke view mahasiswa. Pemisahannya dijaga di lapisan controller dan view,
sesuai AC-04.2.

## B. Struktur tabel

```
items
- id                (PK)
- name              varchar
- category          varchar   Dompet | Elektronik | Kunci | Lain-lain
- location          varchar
- faculty           varchar
- found_at          date
- route             varchar   posko | penemu
- finder_contact    varchar   nullable
- hidden_traits     text
- status            varchar   aktif | menunggu_pengambilan | sudah_diserahkan | arsip
- expires_at        date      nullable
- timestamps

claims
- id                     (PK)
- item_id                (FK -> items.id, cascade on delete)
- claimant_name          varchar
- ownership_description  text
- status                 varchar   menunggu | disetujui | ditolak | ditolak_otomatis
- decision_reason        text      nullable
- decided_by             varchar   nullable
- decided_at             timestamp nullable
- timestamps
```

Relasi: satu Item dapat memiliki banyak Claim.
`Item::claims()` memakai `hasMany`, `Claim::item()` memakai `belongsTo`.

Indeks tambahan: `items(category, status)` untuk penyaringan pada H-02,
`items(faculty)` dan `claims(item_id, status)` untuk daftar klaim petugas.

## C. Aturan turunan

| Aturan | Tempat penerapan | Dasar |
| --- | --- | --- |
| Dompet, Elektronik, dan Kunci masuk jalur posko; Lain-lain masuk jalur penemu | `Item::routeForCategory()` | AC-03.3, AC-03.4 |
| Masa tayang 30 hari untuk barang berharga, 7 hari untuk Lain-lain | `Item::lifespanForCategory()` | AC-X.1, AC-X.2 |
| Kontak penemu hanya disimpan untuk jalur penemu | `ItemController::withDerivedFields()` | AC-03.4 |
| Hanya barang jalur posko berstatus aktif yang dapat diklaim | `Item::isClaimable()` | AC-07.1 |
| Satu pengklaim tidak boleh memiliki dua klaim berjalan | `ClaimController::store()` | AC-07.2 |
| Klaim yang menunggu lebih dari 24 jam ditandai Perlu ditinjau | `Claim::needsReview()` | AC-07.2 |
| Menyetujui satu klaim menolak otomatis klaim lain atas barang yang sama | `PoskoController::approve()` | AC-09.1 |
| Alasan wajib diisi saat menolak | `PoskoController::reject()` | AC-09.2 |
| Klaim atas barang fakultas lain tidak ditampilkan | `PoskoController::index()` | AC-08.3 |
