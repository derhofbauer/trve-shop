<label for="{{ $id }}">{{ $label }}</label>
<input type="{{ $type }}"
       id="{{ $id }}"
       name="{{ $id }}"
       value="{{ isset($value) ? $value : old($id) }}"
       @isset($placeholder)
       placeholder="{{ $placeholder }}"
       @endisset
       class="form-control"
       @if(isset($required) && $required == true)
       required
       @endif
       @if(isset($multiple) && $multiple == true)
       multiple
       @endif
       @if(isset($readonly) && $readonly == true)
       readonly
       @endif
>