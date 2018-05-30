@extends('layouts.frontend')

@section('content')
    <div class="container col-sm-10 col-md-4 margin-auto login-container">
        <div class="login panel">
            <header class="panel__heading text-center">
                <h2>{{ __('Login') }}</h2>
            </header>

            @include('partials.errors')

            <form method="POST" action="{{ route('login') }}" class="login__form">
                @csrf

                <div class="form-group">
                    <label for="email" class="sr-only">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' has-danger' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('Email') }}">
                </div>

                <div class="form-group">
                    <label for="password" class="sr-only">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' has-danger' : '' }}" name="password" required placeholder="{{ __('Password') }}">
                </div>

                {{--<div class="form-group">--}}
                    {{--<div class="checkbox">--}}
                        {{--<label>--}}
                            {{--<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}--}}
                        {{--</label>--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-justify">{{ __('Login') }}</button>
                </div>

                <div class="login__forgot-password">
                    <small>
                        <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                    </small>
                </div>
            </form>

            <div class="login__register-container seperator-top">
                <a class="btn btn-default btn-justify" href="{{ route('register') }}">{{ __('Register') }}</a>
            </div>
        </div>
    </div>

@endsection
