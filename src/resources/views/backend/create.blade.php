@extends('../layouts.backend')

@section('content')
    @module(['class' => 'module--form'])
    @slot('header')
        @include('backend.partials.module-header-create')
    @endslot

    @slot('body')
        @include('backend.partials.errors')

        @include('backend.partials.form-create')
    @endslot
    @endmodule
@endsection