<label for="{{ $id }}">{{ $label }}</label>
<select id="{{ $id }}" name="{{ $id }}" class="form-control"  @isset($required) required @endisset>
    @foreach ($data as $date)
        @if (isset($value) && $date->id == $value)
            <option value="{{ $date->id }}" selected>{{ $date->name }}</option>
        @else
            <option value="{{ $date->id }}">{{ $date->name }}</option>
        @endif
    @endforeach
</select>