<label for="{{ $id }}">{{ $label }}</label>
<div class="media row">
    @forelse($value as $item)
        <div class="media-item col-sm-2 col-md-1">
            <figure>
                <img src="/public{{ Storage::disk('local')->url($item) }}" alt="{{ __('Item image') }} {{ $loop->index + 1 }}" class="img-responsive">
            </figure>
            <label>
                {{ __('Delete') }}
                <input type="checkbox" id="delete_media[{{ $item }}]" name="delete_media[{{ $item }}]">
            </label>
        </div>
    @empty
        <div class="col-xs-12">
            {{ __('This item does not have any media yet.') }}
        </div>
    @endforelse
</div>