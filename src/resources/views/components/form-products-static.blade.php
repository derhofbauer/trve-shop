<label for="{{ $id }}">{{ $label }}</label>
<div class="products">
    @forelse($value as $item)
        <div class="product-item">
            <div class="product">{{ $item['name'] }} ({{ $item['quantity'] }}x)</div>
        </div>
    @empty
        {{ __('This item does not have any products yet.') }}
    @endforelse
</div>