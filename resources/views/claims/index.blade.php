<x-layouts.app title="Klaim saya — Kampus Lost & Found">

    <h1 class="page__title">Klaim saya</h1>
    <p class="page__subtitle">Status klaim yang pernah diajukan.</p>

    <div class="layout-main-aside" style="margin-top: var(--space-6)">

        <div class="stack">
            @forelse ($claims as $claim)
                <article class="card">
                    <div class="row" style="justify-content: space-between; align-items: flex-start">
                        <span>
                            <strong class="card__title">{{ $claim->item->name }}</strong><br>
                            <span class="card__meta">
                                Oleh {{ $claim->claimant_name }} &bull;
                                diajukan {{ $claim->created_at->translatedFormat('j F Y') }}
                            </span>
                        </span>
                        <x-badge :tone="$claim->status_tone">{{ $claim->status_label }}</x-badge>
                    </div>

                    @if ($claim->status === 'disetujui')
                        <p class="alert alert--success" style="margin-top: var(--space-4)">
                            Klaim disetujui. Ambil barang di posko {{ $claim->item->faculty }} pada jam kerja.
                        </p>
                    @elseif (in_array($claim->status, ['ditolak', 'ditolak_otomatis'], true))
                        {{-- AC-09.4 — pengklaim dapat melihat status ditolak beserta alasannya --}}
                        <p class="alert alert--danger" style="margin-top: var(--space-4)">
                            <span class="alert__title">Alasan penolakan</span>
                            <span>{{ $claim->decision_reason }}</span>
                        </p>
                    @endif

                    <div class="row" style="margin-top: var(--space-4)">
                        <x-button variant="ghost" size="small"
                                  :href="route('items.show', $claim->item)">Lihat barang</x-button>

                        @if ($claim->isPending())
                            <x-button variant="ghost" size="small"
                                      :href="route('claims.edit', $claim)">Ubah</x-button>

                            <form method="POST" action="{{ route('claims.destroy', $claim) }}">
                                @csrf
                                @method('DELETE')
                                <x-button variant="danger" size="small">Batalkan klaim</x-button>
                            </form>
                        @endif
                    </div>
                </article>
            @empty
                <x-empty-state title="Belum ada klaim">
                    Klaim yang Anda ajukan akan muncul di sini beserta statusnya.
                    <x-slot:action>
                        <x-button variant="primary" :href="route('items.index')">Cari barang</x-button>
                    </x-slot:action>
                </x-empty-state>
            @endforelse
        </div>

        <aside class="card card--flat">
            <h2 class="card__title">Arti status</h2>
            <dl style="margin: var(--space-4) 0 0; font-size: var(--text-label)">
                <dt style="font-weight: var(--weight-medium)">Menunggu verifikasi</dt>
                <dd style="margin: 0 0 var(--space-3); color: var(--color-text-muted)">
                    Petugas belum memutuskan.</dd>
                <dt style="font-weight: var(--weight-medium)">Menunggu pengambilan</dt>
                <dd style="margin: 0 0 var(--space-3); color: var(--color-text-muted)">
                    Klaim disetujui, barang siap diambil.</dd>
                <dt style="font-weight: var(--weight-medium)">Ditolak</dt>
                <dd style="margin: 0; color: var(--color-text-muted)">
                    Disertai alasan dari petugas.</dd>
            </dl>
        </aside>

    </div>

</x-layouts.app>
