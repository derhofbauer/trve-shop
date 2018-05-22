@form(['action' => route($routes['edit-submit'], ['id' => $object->id]) ])
@slot('header')
    {{ __('Edit') }} {{ $dataType }} "{{ $object->$identifier}}"
@endslot

@slot('body')
    {{-- Tab Bar --}}
    @include('backend.partials.form-tabs')

    {{-- Tab content --}}
    @foreach($tabs as $tab)
        @formtab
        @slot('title')
            {{ $tab['title'] }}
        @endslot

        @slot('body')
            @include('backend.partials.form-fields')

            @formgroup
            @include('backend/partials/form-buttons')
            @endformgroup
        @endslot
        @endformtab
    @endforeach
@endslot
@endform