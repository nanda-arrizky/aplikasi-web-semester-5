<x-layouts.app :title="$item->name . ' — Kampus Lost & Found'">

    <a class="backlink" href="{{ route('items.index') }}">&larr; Kembali ke hasil pencarian</a>

    <div class="layout-main-aside">

        <article class="card">
            <h1 class="page__title">{{ $item->name }}</h1>

            <div class="row" style="margin-top: var(--space-2)">
                <x-badge tone="route">{{ $item->route_label }}</x-badge>
                @if ($item->status !== 'aktif')
                    <x-badge tone="pending">{{ $item->status_label }}</x-badge>
                @endif
            </div>

            <div class="detail-list" style="margin-top: var(--space-6)">
                <div class="detail-list__row">
                    <span class="detail-list__key">Kategori</span>
                    <span class="detail-list__value">{{ $item->category }}</span>
                </div>
                <div class="detail-list__row">
                    <span class="detail-list__key">Lokasi penemuan</span>
                    <span class="detail-list__value">{{ $item->location }}</span>
                </div>
                <div class="detail-list__row">
                    <span class="detail-list__key">Fakultas</span>
                    <span class="detail-list__value">{{ $item->faculty }}</span>
                </div>
                <div class="detail-list__row">
                    <span class="detail-list__key">Waktu penemuan</span>
                    <span class="detail-list__value">{{ $item->found_at->translatedFormat('j F Y') }}</span>
                </div>
                <div class="detail-list__row">
                    <span class="detail-list__key">Masa tayang</span>
                    <span class="detail-list__value">
                        Sampai {{ $item->expires_at?->translatedFormat('j F Y') ?? 'tidak dibatasi' }}
                    </span>
                </div>
            </div>

            {{-- AC-03.2 dan AC-04.2 — ciri detail tidak ditampilkan dalam bentuk apa pun.
                 Keberadaannya diberitahukan agar proses verifikasi tidak terasa sewenang-wenang. --}}
            <p class="card--flat" style="margin-top: var(--space-6); padding: var(--space-4);
               border-radius: var(--radius-md); font-size: var(--text-label);
               color: var(--color-text-muted)">
                Ciri detail barang ini disimpan dan sengaja tidak ditampilkan di halaman ini,
                agar hanya pemilik sebenarnya yang dapat menyebutkannya.
            </p>
        </article>

        <aside class="card action-panel">
            @if ($item->isPoskoRoute())
                @if ($item->isClaimable())
                    <h2 class="card__title">Barang ini milik Anda?</h2>
                    <p class="card__meta" style="margin: var(--space-3) 0 var(--space-4)">
                        Ajukan klaim dan tuliskan ciri yang hanya diketahui pemiliknya.
                    </p>
                    <x-button variant="primary" block
                              :href="route('claims.create', ['item' => $item->id])">
                        Ajukan klaim
                    </x-button>
                @else
                    <h2 class="card__title">Barang sudah diklaim</h2>
                    <p class="card__meta" style="margin-top: var(--space-3)">
                        Barang ini berstatus {{ strtolower($item->status_label) }}
                        dan tidak lagi menerima klaim baru.
                    </p>
                @endif
            @else
                {{-- AC-03.4 — jalur penemu: kontak ditampilkan, tombol klaim tidak tersedia --}}
                <h2 class="card__title">Hubungi penemu</h2>
                <p class="card__meta" style="margin: var(--space-3) 0 var(--space-4)">
                    Barang ini dipegang penemunya dan tidak dititipkan ke posko.
                    Hubungi langsung untuk mengatur serah terima.
                </p>
                <p class="card card--flat" style="padding: var(--space-3); margin: 0">
                    <strong>{{ $item->finder_contact ?? 'Kontak belum dicantumkan' }}</strong>
                </p>
            @endif
        </aside>

    </div>

</x-layouts.app>
