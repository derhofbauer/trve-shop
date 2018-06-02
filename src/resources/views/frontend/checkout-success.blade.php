@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="panel">
        <div class="alert alert-success">
            <div class="alert__message">
                <i data-feather="check-circle"></i>
                {{ __('Great! :D Your order was was placed.') }}
            </div>
        </div>
        <div class="show-order container-padding-top">
            <a href="{{ route('profile.orders'  ) }}" class="btn btn-primary">{{ __('show orders') }}</a>
        </div>
    </div>
</div>
@endsection