@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Blog</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @isset ($object)
                            <article class="blog-entry">
                                <header class="blog-entry__header header">
                                    <h3>{{ $object->title }}</h3>
                                </header>
                                <div class="blog-entry__abstract abstract">
                                    {{ $object->abstract }}
                                </div>
                                <div class="blog-entry__content content">
                                    {{ $object->content }}
                                </div>
                                <div class="blog-entry__back">
                                    <a href="{{ route('blog') }}">{{ __('Back to Blog') }}</a>
                                </div>
                            </article>
                    @endisset

                    @empty ($object)
                        <p>{{ __('Blog entry not found.') }}</p>
                    @endempty
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
