@extends('../layouts.backend')

@section('content')
<div class="module">
    <div class="module__header container"></div>
    <div class="module__body container">
        <div class="module__heading">
            <h2>{{ __('Dashboard') }}</h2>
        </div>

        <div class="card">
            {{ Auth::user()->username }}, You are logged in to the Backend!
        </div>
    </div>
</div>
@endsection