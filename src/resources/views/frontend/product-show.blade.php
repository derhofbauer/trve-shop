@extends('layouts.frontend-sidebar')

@section('content')
    @isset($object)
        <div class="product container-padding-top panel">
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
                            @if(count($object->media) > 1)
                                <div class="slider__thumbnails">
                                    @foreach($object->media as $image)
                                        <img src="/public{{ Storage::disk('local')->url($image) }}" alt="{{ $object->name }} {{ __('Image') }} {{ $loop->index }}" class="img-responsive">
                                    @endforeach
                                </div>
                            @endif
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
                    <div class="product__price-container">
                        <div class="product__price">
                            {{ $object->price }} &euro;
                        </div>
                        <div class="product__rating">
                            <span class="rating__title">{{ __('Rating') }}:</span>
                            <span class="rating__value">{{ $object->getMediumRating(1) }}
                                <small>/ 5</small></span>
                        </div>
                    </div>
                    <div class="add-to-cart">
                        <a href="{{ route('cart.add', [
                        'id' => $object->id,
                        'returnUrl' => base64_encode(route('products.show', ['id' => $object->id]))
                    ]) }}" class="btn btn-primary btn-justify">
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
        <div class="panel">
            @include('frontend.partials.comment-form')
        </div>
    @endauth

    <section class="comments container-padding-top panel">
        <header>
            <h3>{{ __('Comments') }}</h3>
        </header>
        @foreach($object->comments as $comment)
            <div class="comment">
                <div class="comment_text">{{ $comment->content }}</div>
                <div class="comment__meta">
                    <div class="comment__author">{{ substr($comment->author->firstname, 0, 1) }}
                        . {{ $comment->author->lastname }}</div>
                    <div class="comment__date">{{ $comment->created_at->format(__('d.m.Y H:m')) }}</div>
                </div>
            </div>
        @endforeach
    </section>
@endsection