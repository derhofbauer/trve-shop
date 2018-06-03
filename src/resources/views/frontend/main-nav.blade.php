@foreach (\App\Http\Helpers\FrontendNavigationHelper::prepareFeNavigation() as $item)
    <div class="main-nav__item @if($item['active'] == true) main-nav__item--active active @endif">
        <a href="{{ $item['route'] }}">{{ $item['label'] }}</a>
    </div>
@endforeach