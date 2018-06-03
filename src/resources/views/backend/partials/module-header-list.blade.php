@if(!isset($hideButtons) || strpos($hideButtons, 'new') === false)
    <a href="{{ route($routes['create']) }}" class="btn btn-icon">
        <i data-feather="plus"></i>
    </a>
@endif

<div class="module__header--right">
    {{ __('Path:') }} {{ $dataType }}
</div>