@props(['item'])

@php
    $clickable = $item->status === 'aktif';
@endphp

<a class="item-card {{ $clickable ? '' : 'item-card--unavailable' }}"
   href="{{ route('items.show', $item) }}"
   @if (! $clickable) aria-disabled="true" tabindex="-1" @endif>

    <span class="card__title">{{ $item->name }}</span>
    <span class="card__meta">{{ $item->location }}</span>

    <span class="item-card__footer">
        <span class="card__meta">{{ $item->found_at->translatedFormat('j F Y') }}</span>
        @if ($clickable)
            <x-badge tone="route">{{ $item->route_label }}</x-badge>
        @else
            <x-badge tone="pending">{{ $item->status_label }}</x-badge>
        @endif
    </span>
</a>
