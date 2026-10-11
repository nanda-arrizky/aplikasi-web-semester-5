<x-layouts.app title="Ubah barang temuan — Posko">

    <a class="backlink" href="{{ route('items.manage') }}">&larr; Kembali ke kelola barang</a>
    <h1 class="page__title">Ubah barang temuan</h1>

    <form class="card stack" method="POST" action="{{ route('items.update', $item) }}"
          style="margin-top: var(--space-6); max-width: 760px">
        @csrf
        @method('PUT')

            <x-field name="name" label="Nama barang" required
                     placeholder="Misalnya Dompet cokelat" :value="$item->name ?? null" />

            <x-select name="category" label="Kategori" required
                      empty="Pilih kategori"
                      :options="array_combine($categories, $categories)"
                      :value="$item->category ?? null"
                      hint="Dompet, Elektronik, dan Kunci otomatis masuk jalur posko. Lain-lain masuk jalur penemu." />

            <x-field name="location" label="Lokasi penemuan" required
                     placeholder="Misalnya Gedung LPTK lantai 2" :value="$item->location ?? null" />

            <x-field name="faculty" label="Fakultas" required
                     placeholder="Fakultas Teknik" :value="$item->faculty ?? 'Fakultas Teknik'" />

            <x-field name="found_at" label="Waktu penemuan" type="date" required
                     :value="isset($item) ? $item->found_at->format('Y-m-d') : null" />

            <x-field name="hidden_traits" label="Ciri detail tersembunyi" textarea required
                     :value="$item->hidden_traits ?? null"
                     placeholder="Ciri yang hanya diketahui pemilik sebenarnya"
                     hint="Tidak pernah ditampilkan kepada mahasiswa. Menjadi dasar verifikasi petugas." />

            <x-field name="finder_contact" label="Kontak penemu" optional
                     :value="$item->finder_contact ?? null"
                     placeholder="Diisi hanya untuk kategori Lain-lain"
                     hint="Ditampilkan pada postingan untuk barang jalur penemu." />

            <x-select name="status" label="Status barang"
                      :options="[
                          'aktif' => 'Aktif',
                          'menunggu_pengambilan' => 'Menunggu pengambilan',
                          'sudah_diserahkan' => 'Sudah diserahkan',
                          'arsip' => 'Arsip',
                      ]"
                      :value="$item->status" />

            <div class="row">
                <x-button variant="primary">Simpan perubahan</x-button>
                <x-button variant="secondary" :href="route('items.manage')">Batal</x-button>
            </div>
    </form>

</x-layouts.app>
