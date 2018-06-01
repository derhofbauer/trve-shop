@extends('layouts.frontend-sidebar')

@section('content')
    @isset($object)
        <div class="product row">
            <div class="col-sm-6">
                <div class="product__name">
                    {{ $object->name }}
                </div>
                <div class="product__price">
                    {{ $object->price }}
                </div>
                @if(!empty($object->media))
                    <div class="product__image">
                        <img src="{{ asset($object->media[0]) }}" alt="">
                    </div>
                @endif
                <div class="product__description">
                    {{ $object->description }}
                </div>
            </div>
            <div class="col-sm-6">
                @if(!empty($object->media))
                    <div class="slider">
                        <div class="slider__canvas">
                            <img src="/public{{ Storage::disk('local')->url($object->media[0]) }}" alt="{{ $object->name }} {{ __('Image') }} 1" class="img-responsive product__image">
                        </div>
                        <div class="slider__thumbnails">
                            @foreach($object->media as $image)
                                <img src="/public{{ Storage::disk('local')->url($image) }}" alt="{{ $object->name }} {{ __('Image') }} {{ $loop->index }}" class="img-responsive">
                            @endforeach
                        </div>
                    </div>
                @endif
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

    @auth('web')
        <form action="{{ route('products.comment.add', ['id' => $object->id]) }}" method="post">
            @csrf

            <textarea name="comment" id="comment" class="form-control" placeholder="{{ __('Please give feedback') }}"></textarea>
            <select name="rating" id="rating" class="form-control">
                <option value="0">{{ __('Please rate ...') }}</option>
                <option value="1">{{ __('Very good') }}</option>
                <option value="2">{{ __('Good') }}</option>
                <option value="3">{{ __('OK') }}</option>
                <option value="4">{{ __('Bad') }}</option>
                <option value="5">{{ __('Very bad') }}</option>
            </select>
            <input type="submit" name="do-comment" value="{{ __('Comment') }}">
        </form>
    @endauth

    <div class="comments">
        @foreach($object->comments as $comment)
            <div class="comment">
                <div class="comment__author">{{ $comment->author->firstname }} {{ $comment->author->lastname }}</div>
                <div class="comment_text">{{ $comment->content }}</div>
            </div>
        @endforeach
    </div>
@endsection