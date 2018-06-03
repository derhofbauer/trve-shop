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
            <nav class="nav--vertical container no-gutters">
                <a href="{{ route('admin') }}" class="nav__item">
                    <i data-feather="home"></i>
                    {{ __('Dashboard') }}
                </a>
                @permitted('productsShow')
                    <a href="{{ route('admin.products') }}" class="nav__item{{ Request::segment(2) == 'products' ? ' active' : '' }}">
                        <i data-feather="shopping-cart"></i>
                        {{ __('Products') }}
                    </a>
                @endpermitted
                @permitted('categoriesShow')
                <a href="{{ route('admin.categories') }}" class="nav__item{{ Request::segment(2) == 'categories' ? ' active' : '' }}">
                    <i data-feather="tag"></i>
                    {{ __('Categories') }}
                </a>
                @endpermitted
                @permitted('commentsShow')
                    <a href="{{ route('admin.comments') }}" class="nav__item{{ Request::segment(2) == 'comments' ? ' active' : '' }}">
                        <i data-feather="message-circle"></i>
                        {{ __('Comments') }}
                    </a>
                @endpermitted
                @permitted('ratingsShow')
                <a href="{{ route('admin.ratings') }}" class="nav__item{{ Request::segment(2) == 'ratings' ? ' active' : '' }}">
                    <i data-feather="star"></i>
                    {{ __('Ratings') }}
                </a>
                @endpermitted
                @permitted('blogPostsShow')
                    <a href="{{ route('admin.blog') }}" class="nav__item{{ Request::segment(2) == 'blog' ? ' active' : '' }}">
                        <i data-feather="book"></i>
                        {{ __('Blog') }}
                    </a>
                @endpermitted
                @permitted ('beusersShow')
                    <a href="{{ route('admin.users.backend') }}" class="nav__item{{ Request::segment(2) == 'users' && Request::segment(3) == 'backend' ? ' active' : '' }}">
                        <i data-feather="user"></i>
                        {{ __('Backend Users') }}
                    </a>
                @endpermitted
                @permitted('feusersShow')
                    <a href="{{ route('admin.users.frontend') }}" class="nav__item{{ Request::segment(2) == 'users' && Request::segment(3) == 'frontend' ? ' active' : '' }}">
                        <i data-feather="user"></i>
                        {{ __('Frontend Users') }}
                    </a>
                @endpermitted
                @permitted('ordersShow')
                    <a href="{{ route('admin.orders') }}" class="nav__item{{ Request::segment(2) == 'orders' ? ' active' : '' }}">
                        <i data-feather="box"></i>
                        {{ __('Orders') }}
                    </a>
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
