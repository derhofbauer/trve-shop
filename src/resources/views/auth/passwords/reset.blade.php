@extends('layouts.frontend')

@section('content')
    <div class="container col-sm-10 col-sm-4 margin-auto login-container">
        <div class="login panel">
            <header class="panel__heading text-center">
                <h2>{{ __('Password Reset') }}</h2>
            </header>

            <form method="POST" action="{{ route('password.request') }}" class="login__form">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email" class="sr-only">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' has-danger' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus placeholder="{{ __('Email') }}">

                    @if ($errors->has('email'))
                        <span class="has-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password" class="sr-only">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' has-danger' : '' }}" name="password" required placeholder="{{ __('Password') }}">

                    @if ($errors->has('password'))
                        <span class="has-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="sr-only">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}" name="password_confirmation" required placeholder="{{ __('Confirm Password') }}">

                    @if ($errors->has('password_confirmation'))
                        <span class="has-danger">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-justify">{{ __('Reset Password') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
