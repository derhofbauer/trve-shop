@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div class="row">
            @forelse($data as $product)
                <div class="product col-md-4 col-lg-3 col-sm-2 col-xs-1">
                    <div class="product__name">
                        {{ $product->name }}
                    </div>
                    <div class="product__price">
                        {{ $product->price }}
                    </div>
                    @if(!empty($product->media))
                        <div class="product__image">
                            <img src="{{ asset($product->media->first()) }}" alt="">
                        </div>
                    @endif
                    <div class="product__description">
                        {{ $product->description }}
                    </div>
                    <div class="product__more">
                        <a href="{{ route('products.show', ['id' => $product->id, 'slug' => str_slug($product->name)]) }}">{{ __('Details') }}</a>
                    </div>
                </div>
            @empty
                <div class="warning">{{ __('Oh no! We got nothing to display here :(') }}</div>
            @endforelse
        </div>
    </div>
@endsection