@extends('../layouts.backend')

@section('content')
    @module
    @slot('header')
        @include('backend.partials.module-header-list')
    @endslot

    @slot('body')
        @card
        @slot('title')
            {{ $dataType }} ({{ count($data) }})
        @endslot

        @slot('body')
            @include('backend.partials.table')
        @endslot
        @endcard
    @endslot
    @endmodule
@endsection