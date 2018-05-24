<label for="{{ $id }}">{{ $label }}</label>
<div class="select">
    @foreach($data as $date)
        <div class="select-item">
            <label for="product_categories[{{ $date->id }}]">
                <input type="checkbox" id="product_categories[{{ $date->id }}]" name="product_categories[{{ $date->id }}]" @if(in_array($date->id, $value)) checked @endif>
                {{ $date->name }}
            </label>
        </div>
    @endforeach
</div>