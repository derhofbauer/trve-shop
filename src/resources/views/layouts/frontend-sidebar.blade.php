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
<div id="app" class="app">

    @include('frontend.partials.navbar')

    <aside class="sidebar-container container-padding-top container-fluid">
        @include('frontend.partials.sidebar')
    </aside>

    <main class="main content container-fluid">
        @yield('content')
    </main>
</div>
{{-- @include('frontend.partials.footer') --}}
</body>
</html>
