@extends('layouts.frontend')

@section('content')
    <div class="success">{{ __('Great! :D Your order was was placed.') }}</div>
    <div class="show-order">
        <a href="{{ route('profile.orders'  ) }}">{{ __('show orders') }}</a>
    </div>
@endsection