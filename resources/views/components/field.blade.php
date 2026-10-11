@props([
    'name',
    'label',
    'type'     => 'text',
    'value'    => null,
    'placeholder' => null,
    'hint'     => null,
    'optional' => false,
    'required' => false,
    'textarea' => false,
    'rows'     => 6,
])

@php
    $hasError = $errors->has($name);
    $id       = $name;
    $current  = old($name, $value);
@endphp

<div class="field {{ $hasError ? 'field--error' : '' }}">
    <label class="field__label" for="{{ $id }}">
        {{ $label }}@if ($optional) <span class="field__optional">(opsional)</span>@endif
    </label>

    @if ($textarea)
        <textarea class="field__control" id="{{ $id }}" name="{{ $name }}"
                  rows="{{ $rows }}" placeholder="{{ $placeholder }}"
                  @required($required)
                  @if ($hasError) aria-invalid="true" aria-describedby="{{ $id }}-error" @endif
        >{{ $current }}</textarea>
    @else
        <input class="field__control" id="{{ $id }}" name="{{ $name }}"
               type="{{ $type }}" value="{{ $current }}"
               placeholder="{{ $placeholder }}"
               @required($required)
               @if ($hasError) aria-invalid="true" aria-describedby="{{ $id }}-error" @endif>
    @endif

    @if ($hasError)
        <p class="field__error" id="{{ $id }}-error">{{ $errors->first($name) }}</p>
    @elseif ($hint)
        <p class="field__hint">{{ $hint }}</p>
    @endif
</div>
