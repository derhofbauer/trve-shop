@extends('layouts.frontend')

@section('content')
    <div class="container col-sm-10 col-md-4 margin-auto login-container">
        <div class="login panel">
            <header class="panel__heading text-center">
                <h2>{{ __('Request Password Reset') }}</h2>
            </header>

            <form method="POST" action="{{ route('password.email') }}" class="login__form">
                @csrf

                <div class="form-group">
                    <label for="email" class="sr-only">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="{{ __('Email') }}">

                    @if ($errors->has('email'))
                        <span class="has-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-justify">{{ __('Send Password Reset Link') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection