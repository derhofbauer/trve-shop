<div class="{{ $class ?? 'col-md-3 col-sm-6 col-xs-12' }}">
    <div class="product product--grid">
        @if(!empty($product->getFirstImageUri()))
            <img src="/public{{ Storage::disk('local')->url($product->getFirstImageUri()) }}" alt="{{ $product->name }}" class="img-responsive product__image">
        @endif
        <div class="product__overlay">
            <header class="product__title">
                <h3>
                    {{ $product->name }}
                </h3>
            </header>
            <div class="product__price">{{ $product->price }} &euro;</div>

            <div class="product__description">{{ $product->getTeaser() }}</div>
        </div>
        <a href="{{ route('products.show', ['id' => $product->id]) }}" class="product__link"></a>
    </div>
</div>