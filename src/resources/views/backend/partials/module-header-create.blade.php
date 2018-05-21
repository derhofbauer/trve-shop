<a href="{{ route($routes['base']) }}" class="btn btn-icon">
    <i data-feather="x"></i>
</a>
@include('backend/partials/form-submit')

<div class="module__header--right">
    {{ __('Path:') }} {{ $dataType }} [{{ __('NEW') }}]
</div>