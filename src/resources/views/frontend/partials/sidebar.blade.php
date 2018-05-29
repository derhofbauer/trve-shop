<div class="sidebar">
    @include('frontend.partials.searchbox')

    <div class="categories">
        <div class="title">{{ __('Categories') }}</div>
        <div class="categories__tree">
            @foreach (\App\SysProductCategory::all() as $category)
                <div class="category">{{ $category->name }}</div>
            @endforeach
        </div>
    </div>

    <div class="price">
        <div class="title">{{ __('Price') }}</div>
        <input type="range" min="0" step="5" max="{{ \App\SysProduct::getHighestPricedProduct()->price }}">
    </div>
</div>