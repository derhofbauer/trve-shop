<label for="{{ $id }}">{{ $label }}</label>
<select id="{{ $id }}" name="{{ $id }}" class="form-control"  @if(isset($required) && $required == true) required @endif>
    @if (!isset($default) || $default != false)
        <option value="0">{{ __('Please choose ...') }}</option>
    @endif
    @foreach ($data as $date)
        @if (isset($value) && $date->id == $value)
            <option value="{{ $date->id }}" selected>{{ $date->name }}</option>
        @else
            <option value="{{ $date->id }}">{{ $date->name }}</option>
        @endif
    @endforeach
</select>