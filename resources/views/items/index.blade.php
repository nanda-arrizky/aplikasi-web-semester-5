<x-layouts.app title="Cari barang temuan — Kampus Lost & Found">

    <h1 class="page__title">Cari barang temuan</h1>
    <p class="page__subtitle">Telusuri barang yang sudah dilaporkan dari seluruh fakultas.</p>

    <div class="layout-split" style="margin-top: var(--space-6)">

        {{-- Panel filter --}}
        <form class="card stack" method="GET" action="{{ route('items.index') }}">
            <h2 class="card__title">Filter</h2>

            <x-select
                name="category"
                label="Kategori"
                empty="Semua kategori"
                :options="array_combine($categories, $categories)"
                :value="$filters['category'] ?? null" />

            {{-- AC-06.2 — lokasi opsional. Penanda opsional melekat pada label,
                 tanpa keterangan tambahan di bawah kolom. --}}
            <x-field
                name="location"
                label="Lokasi"
                optional
                placeholder="Semua fakultas"
                :value="$filters['location'] ?? null" />

            <div class="grid-two" style="gap: var(--space-2)">
                <x-field name="from" label="Dari tanggal" type="date"
                         :value="$filters['from'] ?? null" />
                <x-field name="to" label="Sampai" type="date"
                         :value="$filters['to'] ?? null" />
            </div>

            <x-button variant="primary" block>Cari</x-button>

            <a class="field__hint" href="{{ route('items.index') }}">Atur ulang filter</a>
        </form>

        {{-- Hasil --}}
        <div>
            <div class="row" style="justify-content: space-between; margin-bottom: var(--space-4)">
                <strong>{{ $items->count() }} barang ditemukan</strong>
                <span class="card__meta">Terbaru lebih dulu</span>
            </div>

            @if ($items->isEmpty())
                {{-- AC-06.4 — hasil kosong disertai saran menghapus salah satu filter --}}
                <x-empty-state title="Tidak ada barang yang cocok">
                    Coba hapus salah satu filter, misalnya rentang tanggal, lalu cari lagi.
                    <x-slot:action>
                        <x-button variant="secondary" :href="route('items.index')">
                            Hapus semua filter
                        </x-button>
                    </x-slot:action>
                </x-empty-state>
            @else
                <div class="grid-cards">
                    @foreach ($items as $item)
                        <x-item-card :item="$item" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</x-layouts.app>
