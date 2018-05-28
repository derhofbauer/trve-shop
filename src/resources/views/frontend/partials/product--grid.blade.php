<div class="product product--grid col-md-3 col-sm-6 col-xs-12">
    <header class="product__title">
        <h3>{{ $product->name }}</h3>
    </header>
    <div class="product__price">{{ $product->price}} &euro;</div>
    @if(!empty($product->getFirstImageUri()))
        <div class="product__image">
            <img src="/public{{ Storage::disk('local')->url($product->getFirstImageUri()) }}" alt="{{ $product->name }}" class="img-responsive">
        </div>
    @endif
    <div class="product__description">{{ $product->getTeaser() }}</div>
</div>