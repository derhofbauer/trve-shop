@extends('layouts.frontend')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-10">
                <div class="row search__products">
                    @forelse($products as $product)
                        @include('frontend.partials.product--grid', ['product' => $product])
                    @empty
                        <div class="warning">{{ __('Oh no! We got nothing to display here :(') }}</div>
                    @endforelse
                </div>
                <div class="row search__blog-entries">
                    @forelse($blogEntries as $entry)
                        <article class="col-sm-3">
                            <header>{{ $entry->title }}</header>
                            <div class="content">
                                {{ $entry->abstract }}
                            </div>
                            <div class="more">
                                <a href="{{ route('blog.show', ['id' => $entry->id]) }}">{{ __('Read more ...') }}</a>
                            </div>
                        </article>
                    @empty
                        <div class="warning">{{ __('Oh no! We got nothing to display here :(') }}</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection