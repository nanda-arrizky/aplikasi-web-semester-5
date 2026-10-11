<x-layouts.app title="Ajukan klaim — Kampus Lost & Found">

    <a class="backlink" href="{{ route('items.show', $item) }}">&larr; Kembali ke detail barang</a>
    <h1 class="page__title">Ajukan klaim</h1>

    <div class="layout-main-aside" style="margin-top: var(--space-6)">

        <form class="stack" method="POST" action="{{ route('claims.store') }}">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">

            <div class="card card--flat row" style="justify-content: space-between">
                <span>
                    <strong>{{ $item->name }}</strong><br>
                    <span class="card__meta">
                        {{ $item->location }} &bull; {{ $item->found_at->translatedFormat('j F Y') }}
                    </span>
                </span>
                <x-badge tone="route">{{ $item->route_label }}</x-badge>
            </div>

            @error('item_id')
                <div class="alert alert--danger" role="alert">{{ $message }}</div>
            @enderror

            <x-field
                name="claimant_name"
                label="Nama lengkap Anda"
                required
                placeholder="Nama sesuai kartu mahasiswa" />

            <x-field
                name="ownership_description"
                label="Deskripsi kepemilikan"
                textarea
                required
                placeholder="Tulis sedetail yang Anda ingat"
                hint="Tuliskan ciri yang hanya diketahui pemiliknya, misalnya isi, goresan, atau tanda khusus." />

            <p class="field__hint">
                Deskripsi ini hanya dibaca petugas posko dan tidak ditampilkan kepada pengguna lain.
            </p>

            <div class="row">
                <x-button variant="primary">Kirim klaim</x-button>
                <x-button variant="secondary" :href="route('items.show', $item)">Batal</x-button>
            </div>
        </form>

        <aside class="card">
            <h2 class="card__title">Setelah klaim dikirim</h2>
            <ol style="margin: var(--space-4) 0 0; padding-left: var(--space-4);
                       font-size: var(--text-label); color: var(--color-text-muted)">
                <li style="margin-bottom: var(--space-2)">Petugas memeriksa deskripsi Anda.</li>
                <li style="margin-bottom: var(--space-2)">Petugas menghubungi untuk konfirmasi.</li>
                <li>Status terbaca di halaman Klaim saya.</li>
            </ol>
        </aside>

    </div>

</x-layouts.app>
