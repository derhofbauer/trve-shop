<label for="{{ $id }}">{{ $label }}</label>
<select id="{{ $id }}" name="{{ $id }}" class="form-control" @if(isset($required) && $required == true) required @endif @if(isset($readonly) && $readonly == true) readonly @endif>
    @if (!isset($default) || $default != false)
        <option value="0">{{ __('Please choose ...') }}</option>
    @endif
    @if (is_object($data[0]))
        @foreach ($data as $date)
            @if (isset($value) && $date->id == $value)
                <option value="{{ $date->id }}" selected>{{ $date->name }}</option>
            @else
                <option value="{{ $date->id }}">{{ $date->name }}</option>
            @endif
        @endforeach
    @else
        @foreach ($data as $key => $label)
            @if (isset($value) && $key == $value)
                <option value="{{ $key }}" selected>{{ $label }}</option>
            @else
                <option value="{{ $key }}">{{ $label }}</option>
            @endif
        @endforeach
    @endif
</select>