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

                    @forelse ($data as $entry)
                        @include('frontend/partials/blog-entry', ['entry' => $entry])
                    @empty
                        <p>{{ __('No blog entries found.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
