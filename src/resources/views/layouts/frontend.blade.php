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
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar">
            <div class="navbar__brand">
                <a href="{{ route('root') }}" class="navbar__brand__link">
                    <h1 class="sr-only">{{ config('app.name', 'Laravel') }}</h1>
                    <img src="{{ asset('img/Logo.svg') }}" alt="Logo">
                </a>
                <div class="navbar__title">{{ __('Merch Store') }}</div>
            </div>
            <div class="navbar__center">
                <div class="main-nav main-nav--dark">
                    @include('frontend.main-nav')
                </div>
            </div>
            <div class="navbar__right">
                <!-- Authentication Links -->
                <div class="nav">
                    <div class="nav-item"><a href="{{ route('cart') }}" class="nav-link">{{ __('Cart') }}</a></div>
                    @guest('web')
                        <div class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></div>
                    @else
                        <div class="nav-item">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="{{ route('profile') }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->firstname }} {{ Auth::user()->lastname }} <span class="caret"></span>
                            </a>
                            @include('frontend.logout-form')
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
<footer class="footer">
    <a class="nav-link" href="{{ route('admin') }}">{{ __('Admin') }}</a>
</footer>
</body>
</html>
