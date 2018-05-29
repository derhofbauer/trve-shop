<div class="searchbox">
    <form action="{{ route('search') }}" id="searchbox" method="get">
        <input type="text" name="searchterm" id="searchterm" placeholder="{{ __('What are you looking for?') }}" class="form-control">
        <button type="submit" class="btn btn-default">
            <i data-feather="search"></i>
        </button>
    </form>
</div>