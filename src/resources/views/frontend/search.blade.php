@extends('layouts.frontend')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                @include('frontend.partials.sidebar')
            </div>
            <div class="col-sm-10">
                <div class="row">
                    @forelse($products as $product)
                        @include('frontend.partials.product--grid', ['product' => $product])
                    @empty
                        <div class="warning">{{ __('Oh no! We got nothing to display here :(') }}</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection