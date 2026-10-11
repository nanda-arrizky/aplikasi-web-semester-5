@props([
    'tone' => 'pending',  {{-- pending | approved | rejected | review | route --}}
])

{{-- Warna bukan satu-satunya pembeda: teks status selalu ditampilkan. --}}
<span {{ $attributes->merge(['class' => 'badge badge--' . $tone]) }}>{{ $slot }}</span>
