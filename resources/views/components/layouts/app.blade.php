<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Kampus Lost & Found' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<header class="site-header">
    <div class="container site-header__inner">
        <a class="site-header__brand" href="{{ route('home') }}">Kampus Lost &amp; Found</a>
        <nav class="site-nav" aria-label="Navigasi utama">
            <a href="{{ route('home') }}"
               @if (request()->routeIs('home')) aria-current="page" @endif>Beranda</a>
            <a href="{{ route('items.index') }}"
               @if (request()->routeIs('items.*')) aria-current="page" @endif>Cari barang</a>
            <a href="{{ route('claims.index') }}"
               @if (request()->routeIs('claims.*')) aria-current="page" @endif>Klaim saya</a>
            <a href="{{ route('posko.index') }}"
               @if (request()->routeIs('posko.*')) aria-current="page" @endif>Posko</a>
        </nav>
    </div>
</header>

<main class="container page">
    @if (session('success'))
        <div class="alert alert--success" role="status" style="margin-bottom: var(--space-6)">
            <span class="alert__title">Berhasil</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert--danger" role="alert" style="margin-bottom: var(--space-6)">
            <span class="alert__title">Tidak dapat diproses</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{ $slot }}
</main>

<footer class="site-footer">
    <div class="container">
        Kampus Lost &amp; Found &bull; Purbaya Dwipananda Arrizky (24051130060) &bull;
        Praktik Aplikasi Web (INF60295) &bull; Universitas Negeri Yogyakarta
    </div>
</footer>

</body>
</html>
