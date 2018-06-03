@extends('layouts.frontend')

@section('content')
    <div class="container col-sm-10 col-md-8 margin-auto login-container">
        <div class="login panel">
            <header class="panel__heading text-center">
                <h2>{{ __('Sign Up') }}</h2>
            </header>

            @include('partials.errors')

            <form method="post" action="{{ route('register') }}">
                @csrf

                <fieldset>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="title" class="control-label">{{ __('Title') }}</label>
                            <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' has-danger' : '' }}" name="title" value="{{ old('title') }}" autofocus placeholder="{{ __('Title') }}">
                        </div>

                        <div class="form-group col-md-5">
                            <label for="firstname" class="control-label">{{ __('Firstname') }}</label>
                            <input id="firstname" type="text" class="form-control{{ $errors->has('firstname') ? ' has-danger' : '' }}" name="firstname" value="{{ old('firstname') }}" required autofocus placeholder="{{ __('Firstname') }}">
                        </div>

                        <div class="form-group col-md-5">
                            <label for="lastname" class="control-label">{{ __('Lastname') }}</label>
                            <input id="lastname" type="text" class="form-control{{ $errors->has('lastname') ? ' has-danger' : '' }}" name="lastname" value="{{ old('lastname') }}" required autofocus placeholder="{{ __('Lastname') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' has-danger' : '' }}" name="email" value="{{ old('email') }}" required placeholder="{{ __('Email') }}">
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="password" class="control-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' has-danger' : '' }}" name="password" required placeholder="{{ __('Password') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="password-confirm" class="control-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control{{ $errors->has('password') ? ' has-danger' : '' }}" name="password_confirmation" required placeholder="{{__('Confirm Password') }}">
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <div class="row">
                        <div class="form-group col-md-5">
                            <label for="country" class="control-label">{{ __('Country') }}</label>
                            <input id="country" type="string" class="form-control{{ $errors->has('country') ? ' has-danger' : '' }}" name="country" required placeholder="{{ __('Country') }}" value="{{ old('country') }}">
                        </div>

                        <div class="form-group col-md-5">
                            <label for="city" class="control-label">{{ __('City') }}</label>
                            <input id="city" type="string" class="form-control{{ $errors->has('city') ? ' has-danger' : '' }}" name="city" required placeholder="{{ __('City') }}" value="{{ old('city') }}">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="zip" class="control-label">{{ __('ZIP') }}</label>
                            <input id="zip" type="string" class="form-control{{ $errors->has('zip') ? ' has-danger' : '' }}" name="zip" required placeholder="{{ __('ZIP') }}" value="{{ old('zip') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-9">
                            <label for="street" class="control-label">{{ __('Street') }}</label>
                            <input id="street" type="string" class="form-control{{ $errors->has('street') ? ' has-danger' : '' }}" name="street" required placeholder="{{ __('Street') }}" value="{{ old('street') }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="street_number" class="control-label">{{ __('Street Number') }}</label>
                            <input id="street_number" type="string" class="form-control{{ $errors->has('street_number') ? ' has-danger' : '' }}" name="street_number" required placeholder="{{ __('Street Number') }}" value="{{ old('street_number') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address_line_2" class="control-label">{{ __('Address line 2') }}</label>
                        <input id="address_line_2" type="string" class="form-control{{ $errors->has('address_line_2') ? ' has-danger' : '' }}" name="address_line_2" placeholder="{{ __('Address line 2') }}" value="{{ old('address_line_2') }}">
                    </div>
                </fieldset>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-justify">{{ __('Register') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection