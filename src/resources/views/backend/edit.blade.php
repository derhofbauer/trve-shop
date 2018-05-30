@extends('../layouts.backend')

@section('content')
    @module(['class' => 'module--form'])
    @slot('header')
        @include('backend.partials.module-header-edit')
    @endslot

    @slot('body')
        @include('partials.errors')

        @include('backend.partials.form')
    @endslot
    @endmodule
@endsection