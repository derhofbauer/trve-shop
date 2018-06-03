<div class="searchbox">
    <form action="{{ route('products.filter') }}" id="searchbox" method="get" class="form">
        <input type="text" name="searchterm" id="searchterm" placeholder="{{ __('What are you looking for?') }}" class="form-control" @if(!empty($searchterm)) value="{{ $searchterm}} " @endif>
        <button type="submit" class="btn btn-default">
            <i data-feather="search"></i>
        </button>
    </form>
</div>
