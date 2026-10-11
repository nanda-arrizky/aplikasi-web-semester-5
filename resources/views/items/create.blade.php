<x-layouts.app title="Tambah barang temuan — Posko">

    <a class="backlink" href="{{ route('items.manage') }}">&larr; Kembali ke kelola barang</a>
    <h1 class="page__title">Tambah barang temuan</h1>

    <form class="card stack" method="POST" action="{{ route('items.store') }}"
          style="margin-top: var(--space-6); max-width: 760px">
        @csrf

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

            <div class="row">
                <x-button variant="primary">Simpan barang</x-button>
                <x-button variant="secondary" :href="route('items.manage')">Batal</x-button>
            </div>
    </form>

</x-layouts.app>
