@extends('../layouts.backend')

@section('content')
    @module(['class' => 'module--form'])
        @slot('header')
            <a href="{{ route('admin.users.backend') }}" class="btn btn-icon">
                <i data-feather="x"></i>
            </a>
            @include('backend/partials/form-submit')
            <a href="{{ route('admin.users.backend.delete', ['id' => $user->id]) }}" class="btn btn-icon">
                <i data-feather="trash-2"></i>
            </a>
            <div class="module__header--right">
                {{ __('Path:') }} {{ __('Backend User') }} [{{ $user->id }}]
            </div>
        @endslot

        @slot('body')
            @include('backend/partials/errors')

            @form(['action' => route('admin.users.backend.edit.submit', ['id' => $user->id]) ])
                @slot('header')
                    Edit Backend User "{{ $user->username }}"
                @endslot

                @slot('body')
                    @formtab
                        @slot('title')
                            {{ __('General') }}
                        @endslot
                        @slot('body')
                            @formgroup
                            @forminput(['label' => __('Username'), 'type' => 'text', 'id' => 'username', 'placeholder' => __('Username placeholder'), 'required' => true, 'value' => $user->username])
                            @endforminput
                            @endformgroup
                            @formgroup
                            @forminput(['label' => __('Email'), 'type' => 'email', 'id' => 'email', 'placeholder' => __('Email placeholder'), 'required' => true, 'value' => $user->email])
                            @endforminput
                            @endformgroup
                            @formgroup
                                @formselect(['label' => __('Role'), 'id' => 'role_id', 'required' => true, 'data' => $roles, 'value' => $user->role_id])
                                @endformselect
                            @endformgroup
                            @formgroup
                                @include('backend/partials/form-buttons')
                            @endformgroup
                        @endslot
                    @endformtab
                @endslot
            @endform
        @endslot
    @endmodule
@endsection