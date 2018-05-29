@extends('layouts.frontend')

@section('content')
    <div class="container">
        @isset($object)
            <div class="product">
                <div class="product__name">
                    {{ $object->name }}
                </div>
                <div class="product__price">
                    {{ $object->price }}
                </div>
                @if(!empty($object->media))
                    <div class="product__image">
                        <img src="{{ asset($object->media->first()) }}" alt="">
                    </div>
                @endif
                <div class="product__description">
                    {{ $object->description }}
                </div>

                <div class="add-to-cart">
                    <a href="{{ route('cart.add', [
                        'id' => $object->id,
                        'returnUrl' => base64_encode(route('products.show', ['id' => $object->id]))
                    ]) }}">
                        {{ __('Add To Cart') }}
                    </a>
                </div>
            </div>
        @else
            <div class="warning">{{ __('Oh no! We got nothing to display here :(') }}</div>
        @endisset

        <div class="comments">
            @foreach($object->comments as $comment)
                <div class="comment">
                    <div class="comment__author">{{ $comment->author->firstname }} {{ $comment->author->lastname }}</div>
                    <div class="comment_text">{{ $comment->content }}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection