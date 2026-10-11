@props(['title'])

<div class="empty-state">
    <p class="empty-state__title">{{ $title }}</p>
    <p class="empty-state__text">{{ $slot }}</p>
    @isset($action)
        <div class="row">{{ $action }}</div>
    @endisset
</div>
