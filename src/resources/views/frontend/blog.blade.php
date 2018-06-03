@extends('layouts.frontend')

@section('content')
    <div class="container">
        <h2 class="header sr-only">Blog</h2>

        <section>
            @forelse ($data as $entry)
                @include('frontend.partials.blog-entry', ['entry' => $entry])
            @empty
                <p>{{ __('No blog entries found.') }}</p>
            @endforelse
        </section>
    </div>
@endsection
