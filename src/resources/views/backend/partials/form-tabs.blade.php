<div class="tabs">
    <ol>
        @foreach($tabs as $tab)
            <li class="tabs__tab" data-target="{{ str_slug($tab['title']) }}">{{ $tab['title'] }}</li>
        @endforeach
    </ol>
</div>