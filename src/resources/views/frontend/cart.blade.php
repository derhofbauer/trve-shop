@extends('layouts.frontend', ['hideErrors' => true])

@section('content')
    <div class="container col-sm-10 margin-auto">
        <div class="panel">
            <header class="panel__header text-center">
                <h2>{{ __('Cart') }}</h2>
            </header>

            @include('partials.errors')

            @include('frontend.partials.cart')
        </div>
    </div>
@endsection
