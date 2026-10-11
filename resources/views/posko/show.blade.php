<x-layouts.app title="Tinjau klaim — Posko">

    <a class="backlink" href="{{ route('posko.index') }}">&larr; Kembali ke daftar klaim</a>

    <h1 class="page__title">Tinjau klaim &bull; {{ $claim->item->name }}</h1>
    <p class="page__subtitle">
        Diajukan {{ $claim->claimant_name }} pada
        {{ $claim->created_at->translatedFormat('j F Y, H:i') }}
        &bull; menunggu {{ $claim->waitingDuration() }}
    </p>

    {{-- AC-08.2 — ciri tersembunyi dan deskripsi pengklaim bersisian,
         terbaca dalam satu pandangan tanpa menggulir. Latar dibedakan agar
         jelas mana data internal dan mana tulisan pihak luar. --}}
    <div class="grid-two" style="margin-top: var(--space-6)">
        <section class="card card--flat">
            <h2 class="card__title">Ciri tersembunyi</h2>
            <p class="card__meta">Hanya terlihat oleh petugas</p>
            <hr class="section-rule" style="margin: var(--space-3) 0">
            <p>{{ $claim->item->hidden_traits }}</p>
        </section>

        <section class="card">
            <h2 class="card__title">Deskripsi pengklaim</h2>
            <p class="card__meta">Ditulis saat mengajukan klaim</p>
            <hr class="section-rule" style="margin: var(--space-3) 0">
            <p>{{ $claim->ownership_description }}</p>
        </section>
    </div>

    <p class="card" style="margin-top: var(--space-6); border-style: dashed;
       font-size: var(--text-label); color: var(--color-text-muted)">
        Konfirmasi kepemilikan dilakukan di luar sistem pada rilis ini.
        Hubungi pengklaim, tanyakan ciri yang tidak pernah ditampilkan, lalu catat hasilnya di bawah.
    </p>

    @if ($claim->isPending())
        <div class="stack" style="margin-top: var(--space-6); max-width: 820px">
            <form method="POST" action="{{ route('posko.reject', $claim) }}" class="stack">
                @csrf
                {{-- AC-09.2 — alasan wajib diisi ketika klaim ditolak --}}
                <x-field
                    name="decision_reason"
                    label="Alasan keputusan"
                    textarea
                    rows="3"
                    placeholder="Tulis alasan singkat yang dapat dipertanggungjawabkan"
                    hint="Wajib diisi apabila klaim ditolak." />

                <div class="row">
                    <x-button variant="danger">Tolak klaim</x-button>
                </div>
            </form>

            <form method="POST" action="{{ route('posko.approve', $claim) }}">
                @csrf
                <x-button variant="primary">Setujui klaim</x-button>
            </form>
        </div>
    @else
        {{-- AC-09.3 — tombol tidak lagi tersedia, jejak keputusan ditampilkan --}}
        <div class="alert {{ $claim->status === 'disetujui' ? 'alert--success' : 'alert--danger' }}"
             style="margin-top: var(--space-6)">
            <span class="alert__title">Klaim {{ strtolower($claim->status_label) }}</span>
            <span>
                Diputuskan oleh {{ $claim->decided_by }} pada
                {{ $claim->decided_at?->translatedFormat('j F Y, H:i') }}
            </span>
            @if ($claim->decision_reason)
                <span>Alasan: {{ $claim->decision_reason }}</span>
            @endif
        </div>

        @if ($claim->status === 'disetujui' && $claim->item->status === 'menunggu_pengambilan')
            <form method="POST" action="{{ route('posko.handover', $claim) }}"
                  style="margin-top: var(--space-4)">
                @csrf
                <x-button variant="secondary">Tandai sudah diserahkan</x-button>
            </form>
        @endif
    @endif

</x-layouts.app>
