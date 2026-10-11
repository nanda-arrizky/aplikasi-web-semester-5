<x-layouts.app title="Beranda — Kampus Lost & Found">

    <section class="hero">
        <h1 class="hero__title">Barang hilang di kampus, satu tempat untuk mencarinya</h1>
        <p class="hero__text">
            Laporan penemuan dari seluruh fakultas, tersimpan dan dapat dicari kembali.
        </p>
    </section>

    {{-- Dua pintu layanan dengan porsi sepadan: menemukan dan kehilangan
         sama pentingnya bagi berjalannya layanan. --}}
    <div class="grid-two">
        <section class="door">
            <h2 class="door__title">Saya menemukan barang</h2>
            <p class="door__text">
                Laporkan barang temuan agar pemiliknya dapat menemukannya kembali.
            </p>
            <div class="row">
                <x-button variant="secondary" :href="route('items.create')">Buat laporan</x-button>
            </div>
        </section>

        <section class="door">
            <h2 class="door__title">Saya kehilangan barang</h2>
            <p class="door__text">
                Buat laporan kehilangan agar dapat dicocokkan dengan barang temuan.
            </p>
            <div class="row">
                <x-button variant="secondary" href="#" disabled>Buat laporan</x-button>
                <x-badge tone="review">Di luar lingkup Pertemuan 4</x-badge>
            </div>
        </section>
    </div>

    <section style="margin-top: var(--space-8)">
        <h2 class="page__title" style="font-size: var(--text-section)">
            Atau telusuri barang yang sudah dilaporkan
        </h2>
        <form class="search-bar" method="GET" action="{{ route('items.index') }}"
              style="margin-top: var(--space-3)">
            <input class="field__control" type="search" name="location"
                   placeholder="Cari berdasarkan lokasi, misalnya Gedung LPTK"
                   aria-label="Cari lokasi penemuan">
            <x-button variant="primary">Cari barang</x-button>
        </form>
    </section>

    <hr class="section-rule">

    <section>
        <h2 class="page__title" style="font-size: var(--text-section)">Dua jalur penanganan</h2>
        <div class="grid-two" style="margin-top: var(--space-4)">
            <article class="card card--flat">
                <x-badge tone="route">Jalur posko</x-badge>
                <p style="margin-top: var(--space-3)">
                    Dompet, elektronik, dan kunci dititipkan ke posko fakultas.
                    Klaim diverifikasi petugas sebelum barang diserahkan.
                </p>
            </article>
            <article class="card card--flat">
                <x-badge tone="route">Jalur penemu</x-badge>
                <p style="margin-top: var(--space-3)">
                    Barang kategori lain-lain tetap dipegang penemu.
                    Kontaknya ditampilkan pada postingan agar dapat dihubungi langsung.
                </p>
            </article>
        </div>
    </section>

</x-layouts.app>
