@props([
    'name',
    'label',
    'options'  => [],
    'value'    => null,
    'empty'    => null,
    'hint'     => null,
    'optional' => false,
    'required' => false,
])

@php
    $hasError = $errors->has($name);
    $current  = old($name, $value);
@endphp

<div class="field {{ $hasError ? 'field--error' : '' }}">
    <label class="field__label" for="{{ $name }}">
        {{ $label }}@if ($optional) <span class="field__optional">(opsional)</span>@endif
    </label>

    <select class="field__control" id="{{ $name }}" name="{{ $name }}"
            @required($required)
            @if ($hasError) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif>
        @if ($empty !== null)
            <option value="">{{ $empty }}</option>
        @endif
        @foreach ($options as $key => $text)
            <option value="{{ $key }}" @selected((string) $current === (string) $key)>{{ $text }}</option>
        @endforeach
    </select>

    @if ($hasError)
        <p class="field__error" id="{{ $name }}-error">{{ $errors->first($name) }}</p>
    @elseif ($hint)
        <p class="field__hint">{{ $hint }}</p>
    @endif
</div>
