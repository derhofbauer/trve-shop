@extends('layouts.frontend')

@section('content')
    <div class="container col-sm-10 margin-auto login-container">
        <div class="panel login">
            <header class="panel__header text-center">
                <h2>{{ __('Profile') }}</h2>
            </header>

            @include('partials.errors')

            <form class="form" action="{{ route('profile.update') }}" method="post" role="form" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label" for="title">{{ __('Title') }}</label>
                        <input type="text" id="title" name="title" value="{{ $user->title ?? old('title') }}" placeholder="{{ __('Title') }}" class="form-control{{ $errors->has('title') ? ' has-danger' : '' }}">
                    </div>
                    <div class="form-group col-md-5">
                        <label class="control-label" for="firstname">{{ __('First name') }}</label>
                        <input type="text" id="firstname" name="firstname" value="{{ $user->firstname ?? old('firstname') }}" placeholder="{{ __('First name') }}" class="form-control{{ $errors->has('firstname') ? ' has-danger' : '' }}" required>
                    </div>
                    <div class="form-group col-md-5">
                        <label class="control-label" for="lastname">{{ __('Last name') }}</label>
                        <input type="text" id="lastname" name="lastname" value="{{ $user->lastname ?? old('lastname') }}" placeholder="{{ __('Last name') }}" class="form-control{{ $errors->has('lastname') ? ' has-danger' : '' }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="email">{{ __('Email') }}</label>
                    <input type="email" id="email" name="email" value="{{ $user->email ?? old('email') }}" placeholder="{{ __('Email') }}" class="form-control{{ $errors->has('email') ? ' has-danger' : '' }}" required>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="control-label" for="password">{{ __('Password') }}</label>
                        <input type="password" id="password" name="password" placeholder="{{ __('Password') }}" class="form-control{{ $errors->has('password') ? ' has-danger' : '' }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="password">{{ __('Password Confirmation') }}</label>
                        <input type="password" id="password" name="password_repeat" placeholder="{{ __('Password') }}" class="form-control{{ $errors->has('password_repeat') ? ' has-danger' : '' }}">
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-justify" value="{{ __('Save') }}">
                </div>
            </form>
        </div>
    </div>
@endsection