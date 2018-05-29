<div class="sidebar">
    <form action="{{ route('products.filter') }}" id="filter" method="get">
        <div class="searchbox">
            <div class="form">
                <input type="text" name="searchterm" id="searchterm" placeholder="{{ __('What are you looking for?') }}" class="form-control" @if(!empty($searchterm)) value="{{ $searchterm}} " @endif>
                <button type="submit" class="btn btn-default">
                    <i data-feather="search"></i>
                </button>
            </div>
        </div>

        <div class="categories">
            <div class="title">{{ __('Categories') }}</div>
            <div class="categories__tree">
                @foreach (\App\SysProductCategory::all() as $category)
                    <label>
                        <input type="checkbox" class="category" name="categories[{{ $category->id }}]" @if(!empty($categories) && array_key_exists($category->id, $categories)) checked @endif> {{ $category->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="price">
            <div class="title">{{ __('Price (€)') }}</div>
            <div class="lables">
                <div class="price__min">0</div>
                <div class="price__max">5</div>
            </div>
            <input type="range" min="0" step="1" max="{{ \App\SysProduct::getHighestPricedProduct()->price }}" name="price_max" @if(!empty($price_max)) value="{{ $price_max }}" @else value="15" @endif">
        </div>

        <div class="submit">
            <input type="submit" value="{{ __('Filter') }}" class="btn btn-default">
            <a href="{{ route('products') }}">{{ __('Reset filters') }}</a>
        </div>
    </form>
</div>