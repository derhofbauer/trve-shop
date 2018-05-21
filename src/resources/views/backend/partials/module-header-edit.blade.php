<a href="{{ route($routes['base']) }}" class="btn btn-icon">
    <i data-feather="x"></i>
</a>
@include('backend/partials/form-submit')
<a href="{{ route($routes['delete'], ['id' => $object->id]) }}" class="btn btn-icon">
    <i data-feather="trash-2"></i>
</a>

<div class="module__header--right">
    {{ __('Path:') }} {{ $dataType }} [{{ $object->id }}]
</div>