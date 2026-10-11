<x-layouts.app title="Halaman tidak ditemukan">

    <div class="empty-state" style="margin-top: var(--space-12)">
        <p style="font-size: 3rem; font-weight: var(--weight-bold); color: var(--color-border-strong)">404</p>
        <p class="empty-state__title">Halaman tidak ditemukan</p>
        <p class="empty-state__text">
            Alamat yang Anda buka tidak tersedia atau sudah dipindahkan.
        </p>
        <x-button variant="primary" :href="route('home')">Kembali ke beranda</x-button>
    </div>

</x-layouts.app>
