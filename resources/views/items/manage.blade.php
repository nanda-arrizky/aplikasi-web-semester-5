<x-layouts.app title="Kelola barang temuan — Posko">

    <div class="row" style="justify-content: space-between">
        <span>
            <h1 class="page__title">Kelola barang temuan</h1>
            <p class="page__subtitle">{{ $items->count() }} barang terdaftar.</p>
        </span>
        <x-button variant="primary" :href="route('items.create')">Tambah barang</x-button>
    </div>

    @if ($items->isEmpty())
        <x-empty-state title="Belum ada barang terdaftar">
            Jalankan <code>php artisan db:seed</code> untuk mengisi data contoh,
            atau tambahkan barang secara manual.
        </x-empty-state>
    @else
        <div class="table-wrap" style="margin-top: var(--space-6)">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Jalur</th>
                        <th>Status</th>
                        <th>Klaim</th>
                        <th><span class="field__optional">Aksi</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td><strong>{{ $item->name }}</strong></td>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->location }}</td>
                            <td><x-badge tone="route">{{ $item->route_label }}</x-badge></td>
                            <td><x-badge tone="pending">{{ $item->status_label }}</x-badge></td>
                            <td>{{ $item->claims_count }}</td>
                            <td>
                                <div class="row" style="flex-wrap: nowrap">
                                    <x-button variant="ghost" size="small"
                                              :href="route('items.show', $item)">Lihat</x-button>
                                    <x-button variant="ghost" size="small"
                                              :href="route('items.edit', $item)">Ubah</x-button>
                                    <form method="POST" action="{{ route('items.destroy', $item) }}">
                                        @csrf
                                        @method('DELETE')
                                        <x-button variant="danger" size="small">Hapus</x-button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</x-layouts.app>
