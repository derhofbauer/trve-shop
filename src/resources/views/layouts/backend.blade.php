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
    <link href="{{ asset('css/backend.min.css') }}" rel="stylesheet">
</head>
<body>
    <div class="app">
        <nav class="navbar">
            <div class="navbar__brand">
                <i data-feather="shopping-bag"></i>
                <h1>{{ config('app.name', 'Laravel') }}</h1>
                <span class="version">
                    [{{ config('app.version', 'a.b.c') }}]
                </span>
            </div>

            <div class="navbar__right">
                <div class="user-nav">
                    <i data-feather="user" class="circle"></i>
                    <span class="username">
                        {{ Auth::user()->username }}
                    </span>
                    {{--<i data-feather="chevron-down"></i>--}}
                    {{--<div class="dropdown">--}}
                        {{--<div class="dropdown-item">--}}
                            <a href="{{ route('admin.logout') }}" class="btn btn-primary btn-icon-text">
                                <i data-feather="log-out"></i>
                                {{ __('Logout') }}
                            </a>
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </nav>

        <div class="main-nav">
            <nav class="nav--vertical container">
                <a href="{{ route('admin') }}" class="nav__item">{{ __('Dashboard') }}</a>
                @permitted('productsShow')
                    <a href="{{ route('admin.products') }}" class="nav__item">{{ __('Products') }}</a>
                @endpermitted
                @permitted('commentsShow')
                    <a href="{{ route('admin.comments') }}" class="nav__item">{{ __('Comments') }}</a>
                @endpermitted
                @permitted('ratingsShow')
                <a href="{{ route('admin.ratings') }}" class="nav__item">{{ __('Ratings') }}</a>
                @endpermitted
                @permitted('categoriesShow')
                    <a href="{{ route('admin.categories') }}" class="nav__item">{{ __('Categories') }}</a>
                @endpermitted
                @permitted('blogPostsShow')
                    <a href="{{ route('admin.blog') }}" class="nav__item">{{ __('Blog') }}</a>
                @endpermitted
                @permitted ('beusersShow')
                    <a href="{{ route('admin.users') }}" class="nav__item">{{ __('Users') }}</a>
                @endpermitted
                @permitted('feusersShow')
                    <a href="{{ route('admin.users.frontend') }}" class="nav__item nav__item--sub">{{ __('Frontend User') }}</a>
                @endpermitted
                @permitted('ordersShow')
                    <a href="{{ route('admin.orders') }}" class="nav__item">{{ __('Orders') }}</a>
                @endpermitted
                {{--<a href="{{ route('admin.settings') }}" class="nav__item">{{ __('Settings') }}</a>--}}
            </nav>
        </div>

        <main class="main">
            @yield('content')
        </main>
    </div>
</body>
</html>
