@extends('layouts.frontend')

@section('content')
    <div class="container">
        @isset ($object)
            <article class="blog-entry panel">
                <header class="blog-entry__header header">
                    <h2>
                        <a href="{{ route('blog.show', ['id' => $object->id, 'slug' => str_slug($object->title) ]) }}">
                            {{ $object->title }}
                        </a>
                    </h2>
                </header>
                <div class="blog-entry__abstract-container">
                    <div class="blog-entry__text">
                        <div class="blog-entry__abstract abstract">
                            {{ $object->abstract }}
                        </div>
                        <div class="blog-entry__content content">
                            @if ($object->hasMedia())
                                <img src="/public{{ Storage::disk('local')->url($object->getFirstImageUri()) }}" alt="{{ __('Blog Image') }}" class="img-responsive">
                            @endif

                            {!! $object->renderMarkdown() !!}
                        </div>
                    </div>

                </div>
                @if($object->products->count() > 0)
                    <div class="blog-entry__products row">
                        @foreach($object->products as $product)
                            @include('frontend.partials.product--grid', [
                            'product' => $product,
                            'class' => 'col-sm-6'
                            ])
                        @endforeach
                    </div>
                @endif
            </article>

        @endisset

        @empty ($object)
            <p>{{ __('Blog entry not found.') }}</p>
        @endempty
    </div>
@endsection
