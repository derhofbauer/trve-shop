<label for="{{ $id }}">
    {{ $label }}<br>
    <input type="{{ $type }}" id="{{ $id }}" name="{{ $id }}" class="form-control" @if(isset($required) && $required == true) required @endif @if(isset($checked) && $checked == true || isset($value) && $value == true) checked @endif>
</label>