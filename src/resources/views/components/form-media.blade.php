<label for="{{ $id }}">{{ $label }}</label>
<div class="media">
    @forelse($value as $item)
        <div class="media-item">
            <figure>
                <img src="/public{{ Storage::disk('local')->url($item) }}" alt="{{ __('Item image') }} {{ $loop->index + 1 }}">
            </figure>
            <label for="delete_media[{{ $item }}]">{{ __('Delete') }}</label>
            <input type="checkbox" id="delete_media[{{ $item }}]" name="delete_media[{{ $item }}]">
        </div>
    @empty
        {{ __('This item does not have any media yet.') }}
    @endforelse
</div>