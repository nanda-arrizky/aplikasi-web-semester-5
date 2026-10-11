@props([
    'variant' => 'primary',   {{-- primary | secondary | danger | ghost --}}
    'size'    => 'normal',    {{-- normal | small --}}
    'href'    => null,
    'block'   => false,
    'disabled'=> false,
])

@php
    $classes = 'btn btn--' . $variant
        . ($size === 'small' ? ' btn--small' : '')
        . ($block ? ' btn--block' : '');
@endphp

@if ($href && ! $disabled)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@elseif ($href)
    <span {{ $attributes->merge(['class' => $classes]) }} aria-disabled="true">{{ $slot }}</span>
@else
    <button type="{{ $attributes->get('type', 'submit') }}"
            @disabled($disabled)
            {{ $attributes->merge(['class' => $classes])->except('type') }}>{{ $slot }}</button>
@endif
