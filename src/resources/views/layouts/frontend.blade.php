<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/frontend.min.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar">
        <div class="navbar__brand">
            <a href="{{ route('root') }}" class="navbar__brand__link">
                <h1 class="sr-only">{{ config('app.name', 'Laravel') }}</h1>
                <img src="{{ asset('img/Logo.svg') }}" alt="Logo">
            </a>
            <div class="navbar__title">
                <img src="{{ asset('img/font.png') }}" alt="{{ __('Merch Store') }}">
            </div>
        </div>
        <div class="navbar__right">
            <div class="main-nav main-nav--dark">
                @include('frontend.main-nav')
            </div>
            @include('frontend.partials.searchbox')
            <!-- Authentication Links -->
            <div class="nav">
                <div class="nav-item dropdown">
                    <a class="btn btn--inverted btn--round" href="{{ route('profile') }}" data-toggle="#user-dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="user"></i>
                        <i data-feather="chevron-down"></i>
                    </a>
                    <div class="dropdown-menu" id="user-dropdown">
                        @guest('web')
                            <a href="{{ route('login') }}" class="dropdown-item">{{ __('Login') }}</a>
                        @else
                            <a href="{{ route('profile') }}" class="dropdown-item">
                                {{ __('Profile') }} <span class="sr-only">({{ Auth::user()->firstname }} {{ Auth::user()->lastname }})</span>
                            </a>
                            <a href="{{ route('logout') }}" data-logout class="dropdown-item">{{ __('Logout') }}</a>
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

    <main class="main content">
        @yield('content')
    </main>
</div>
<footer class="footer">
    <a class="nav-link" href="{{ route('admin') }}">{{ __('Admin') }}</a>
</footer>
@include('frontend.logout-form')
</body>
</html>
