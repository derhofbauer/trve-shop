@extends('layouts.frontend')

@section('content')
    <div class="nav">
        <div class="nav-item">
            <a href="{{ route('profile.orders') }}">{{ __('Orders') }}</a>
        </div>
    </div>
    @include('backend.partials.form')
@endsection