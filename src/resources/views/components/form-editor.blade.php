<label for="{{ $id }}">{{ $label }}</label>
<textarea name="{{ $id }}" id="{{ $id }}" class="form-control editor" @isset($requited) required @endisset placeholder="{{ $placeholder }}">{{ isset($value) ? $value : old($id) }}</textarea>