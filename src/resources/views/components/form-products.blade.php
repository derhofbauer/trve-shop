<label for="{{ $id }}">{{ $label }}</label>
<div class="products">
    @forelse($value as $item)
        <div class="product-item">
            <div class="product">{{ $item->product->name }} ({{ $item->product_quantity }}x)</div>
            <label for="delete_product[{{ $item->product->id }}]">{{ __('Delete') }}</label>
            <input type="checkbox" id="delete_product[{{ $item->product->id }}]" name="delete_product[{{ $item->product->id }}]">
        </div>
    @empty
        {{ __('This item does not have any products yet.') }}
    @endforelse
</div>