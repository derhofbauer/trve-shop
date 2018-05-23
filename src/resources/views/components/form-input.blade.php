<label for="{{ $id }}">{{ $label }}</label>
<input type="{{ $type }}" id="{{ $id }}" name="{{ $id }}" value="{{ isset($value) ? $value : old($id) }}" placeholder="{{ $placeholder }}" class="form-control" @if(isset($required) && $required == true) required @endif>