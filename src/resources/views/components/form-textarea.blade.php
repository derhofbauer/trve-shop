<label for="{{ $id }}">{{ $label }}</label>
<textarea name="{{ $id }}" id="{{ $id }}" class="form-control" @isset($requited) required @endisset placeholder="{{ $placeholder }}">{{ $value }}</textarea>