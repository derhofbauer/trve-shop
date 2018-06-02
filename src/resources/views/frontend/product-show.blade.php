@extends('layouts.frontend-sidebar')

@section('content')
    @isset($object)
        <div class="product container-padding-top">
            <div class="product__name col-12">
                <h2>{{ $object->name }}</h2>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    @if(!empty($object->media))
                        <div class="slider">
                            <div class="slider__canvas">
                                <img src="/public{{ Storage::disk('local')->url($object->media[0]) }}" alt="{{ $object->name }} {{ __('Image') }} 1" class="img-responsive">
                            </div>
                            <div class="slider__thumbnails">
                                @foreach($object->media as $image)
                                    <img src="/public{{ Storage::disk('local')->url($image) }}" alt="{{ $object->name }} {{ __('Image') }} {{ $loop->index }}" class="img-responsive">
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-sm-8">
                    <div class="product__description">
                        {{ $object->description }}
                    </div>
                    @if(!empty($object->parent->children))
                        <div class="product__siblings col-sm-4 no-gutters">
                            <select name="siblings" id="siblings" class="form-control">
                                <option value="default">{{ __('Other variants ...') }}</option>
                                @foreach ($object->siblings as $sibling)
                                    <option value="{{ route('products.show', ['id' => $sibling->id]) }}">{{ $sibling->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="product__price">
                        {{ $object->price }} &euro;
                    </div>
                    <div class="add-to-cart">
                        <a href="{{ route('cart.add', [
                        'id' => $object->id,
                        'returnUrl' => base64_encode(route('products.show', ['id' => $object->id]))
                    ]) }}" class="btn btn-primary">
                            {{ __('Add To Cart') }}
                        </a>
                    </div>
                    <small>{{ __('* All prices include taxes.') }}</small>
                </div>
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