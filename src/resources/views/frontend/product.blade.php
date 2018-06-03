@extends('layouts.frontend-sidebar')

@section('content')
    <div class="content-container container-padding-top">
        <div class="row">
            @forelse($data as $product)
                @include('frontend.partials.product--grid', ['product' => $product])
            @empty
                @include('frontend.partials.nothing-to-display')
            @endforelse
        </div>
    </div>
@endsection