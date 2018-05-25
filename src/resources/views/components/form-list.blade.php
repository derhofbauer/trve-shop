<label for="{{ $id }}">{{ $label }}</label>
<div class="list">
    @forelse($value as $item)
        <div class="list-item">
            <div class="item">{{ $item->name }}</div>
            <label for="delete_{{ $item->table }}[{{ $item->id }}]">{{ __('Delete') }}</label>
            <input type="checkbox" id="delete_{{ $item->table }}[{{ $item->id }}]" name="delete_{{ $item->table }}[{{ $item->id }}]">
        </div>
    @empty
        {{ __('This item does not have any media yet.') }}
    @endforelse
</div>