<label for="{{ $id }}">{{ $label }}</label>
<div class="select">
    @foreach($data as $date)
        <div class="select-item">
            <label for="{{ $id }}[{{ $date->id }}]">
                <input type="checkbox" id="{{ $id }}[{{ $date->id }}]" name="{{ $id }}[{{ $date->id }}]" @if(isset($value) && in_array($date->id, $value)) checked @endif>
                {{ $date->name }}
            </label>
        </div>
    @endforeach
</div>