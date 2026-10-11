<x-layouts.app title="Klaim menunggu verifikasi — Posko">

    <h1 class="page__title">Klaim menunggu verifikasi</h1>
    <p class="page__subtitle">
        Posko {{ $faculty }} &bull; {{ $claims->count() }} klaim ditampilkan
    </p>

    <form class="row" method="GET" action="{{ route('posko.index') }}"
          style="margin: var(--space-6) 0">
        <select class="field__control" name="status" style="max-width: 260px"
                aria-label="Saring menurut status">
            <option value="menunggu" @selected($current === 'menunggu' || $current === '')>
                Menunggu verifikasi</option>
            <option value="disetujui" @selected($current === 'disetujui')>Disetujui</option>
            <option value="ditolak" @selected($current === 'ditolak')>Ditolak</option>
        </select>
        <x-button variant="secondary" size="small">Terapkan</x-button>
    </form>

    @if ($claims->isEmpty())
        <x-empty-state title="Tidak ada klaim pada status ini">
            Klaim baru akan muncul di sini, terurut dari yang paling lama menunggu.
        </x-empty-state>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Pengklaim</th>
                        <th>Diajukan</th>
                        <th>Menunggu</th>
                        <th><span class="field__optional">Aksi</span></th>
                    </tr>
                </thead>
                <tbody>
                    {{-- AC-08.1 — terurut dari yang paling lama menunggu --}}
                    @foreach ($claims as $claim)
                        <tr>
                            <td><strong>{{ $claim->item->name }}</strong></td>
                            <td>{{ $claim->claimant_name }}</td>
                            <td>{{ $claim->created_at->translatedFormat('j M H:i') }}</td>
                            <td>
                                @if ($claim->needsReview())
                                    {{-- AC-07.2 — menunggu lebih dari 24 jam --}}
                                    <x-badge tone="review">
                                        {{ $claim->waitingDuration() }} &bull; Perlu ditinjau
                                    </x-badge>
                                @else
                                    <x-badge :tone="$claim->status_tone">
                                        {{ $claim->waitingDuration() }}
                                    </x-badge>
                                @endif
                            </td>
                            <td>
                                <x-button variant="secondary" size="small"
                                          :href="route('posko.show', $claim)">Tinjau</x-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</x-layouts.app>
