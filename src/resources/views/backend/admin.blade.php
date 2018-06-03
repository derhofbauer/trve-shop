@extends('../layouts.backend')

@section('content')
<div class="module">
    <div class="module__header container-fluid"></div>
    <div class="module__body container-fluid">
        <div class="module__heading">
            <h2>{{ __('Dashboard') }}</h2>
        </div>

        <div class="row">
        @foreach($tables as $table)
            @if($loop->count % 2 > 0 && $loop->last)
                <div class="col-sm-12">
            @else
                <div class="col-sm-6">
            @endif

                @card
                @slot('title')
                    {{ $table['dataType'] }} ({{ count($table['data']) }})
                @endslot

                @slot('body')
                    @include('backend.partials.table', $table)
                @endslot
                @endcard
            </div>
        @endforeach
                </div>
    </div>
</div>
@endsection