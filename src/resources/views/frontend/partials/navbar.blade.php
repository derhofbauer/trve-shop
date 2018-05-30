<nav class="navbar">
    <div class="navbar__brand col-sm-4 row">
        <a href="{{ route('root') }}" class="navbar__brand__link col-xs-3 no-gutters">
            <img src="{{ asset('img/Logo.svg') }}" alt="Logo" class="img-responsive">
        </a>
        <a href="{{ route('root') }}" class="navbar__brand__link col-xs-9 no-gutters">
            <h1 class="navbar__title">{{ config('app.name', 'Laravel') }}</h1>
        </a>
    </div>

    <div class="navbar__right col-sm-8 row">
        <div class="main-nav main-nav--dark col-sm-4 col-xl-3">
            @include('frontend.main-nav')
        </div>
        <div class="col-sm-4 col-xl-6">
            @include('frontend.partials.searchbox')
        </div>
        <div class="nav col-sm-4 col-xl-3">
            <div class="nav-item dropdown">
                <a class="btn btn--inverted btn--round" href="{{ route('profile') }}" data-toggle="#user-dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">{{ __('Profile') }}</span>
                    <i data-feather="user"></i>
                    <i data-feather="chevron-down"></i>
                </a>
                <div class="dropdown-menu" id="user-dropdown">
                    @guest('web')
                        <a href="{{ route('login') }}" class="dropdown-item">{{ __('Login') }}</a>
                    @else
                        <a href="{{ route('profile') }}" class="dropdown-item">
                            {{ __('Profile') }}
                            <span class="sr-only">
                                    ({{ Auth::user()->firstname }} {{ Auth::user()->lastname }})
                                </span>
                        </a>
                        <a href="{{ route('profile.orders') }}" class="dropdown-item">{{ __('Orders') }}</a>

                        <a href="{{ route('logout') }}" data-logout class="dropdown-item seperator-top">{{ __('Logout') }}</a>
                    @endguest
                </div>
            </div>
            {{--<div class="nav-item">
                <a href="{{ route('favorite') }}" class="btn btn--inverted">
                    <i data-feather="star"></i>
                </a>
            </div>--}}
            <div class="nav-item">
                <a href="{{ route('cart') }}" class="btn btn--round btn--inverted">
                    <i data-feather="shopping-bag"></i> <span class="cart-total">{{ \App\Http\Controllers\Frontend\CartController::getCartTotal(request()) }} &euro;</span>
                </a>
            </div>
        </div>
    </div>
</nav>