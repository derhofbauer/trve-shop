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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/backend.min.css') }}" rel="stylesheet">
</head>
<body class="login">
<div id="app">
    <main class="main main--login">
        <h1 class="title global-title">{{ config('app.name', 'Laravel') }}</h1>
        <div class="panel panel--login">
            <div class="panel__heading">
                <h2><i data-feather="shopping-bag"></i>{{ __('Login') }}</h2>
            </div>
            <div class="panel__body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.login.submit') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                        <label for="email" class="control-label">{{ __('Username') }}</label>

                        <div class="col-12">
                            <input id="username" type="username" class="form-control" name="username" value="{{ old('username') }}" required autofocus placeholder="{{ __('Username') }}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label for="password" class="control-label">{{ __('Password') }}</label>

                        <div class="col-12">
                            <input id="password" type="password" class="form-control" name="password" required placeholder="{{ __('Password') }}">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-justify">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>