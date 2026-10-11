<x-layouts.app title="Ubah klaim — Kampus Lost & Found">

    <a class="backlink" href="{{ route('claims.index') }}">&larr; Kembali ke klaim saya</a>
    <h1 class="page__title">Ubah klaim</h1>

    <form class="stack card" method="POST" action="{{ route('claims.update', $claim) }}"
          style="margin-top: var(--space-6); max-width: 720px">
        @csrf
        @method('PUT')

        <div class="card card--flat">
            <strong>{{ $claim->item->name }}</strong><br>
            <span class="card__meta">{{ $claim->item->location }}</span>
        </div>

        <x-field name="claimant_name" label="Nama lengkap Anda"
                 required :value="$claim->claimant_name" />

        <x-field name="ownership_description" label="Deskripsi kepemilikan"
                 textarea required :value="$claim->ownership_description" />

        <div class="row">
            <x-button variant="primary">Simpan perubahan</x-button>
            <x-button variant="secondary" :href="route('claims.index')">Batal</x-button>
        </div>
    </form>

</x-layouts.app>
