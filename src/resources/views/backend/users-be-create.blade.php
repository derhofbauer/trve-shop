@extends('../layouts.backend')

@section('content')
    @module(['class' => 'module--form'])
        @slot('header')
            <a href="{{ route('admin.users.backend') }}" class="btn btn-icon">
                <i data-feather="x"></i>
            </a>
            @include('backend/partials/form-submit')

            <div class="module__header--right">
                {{ __('Path:') }} {{ __('Backend User') }} [{{ __('edit') }}]
            </div>
        @endslot

        @slot('body')
            @include('backend/partials/errors')

            @form(['action' => route('admin.users.backend.create.submit')])
                @slot('header')
                    New Backend User
                @endslot

                @slot('body')
                    @formtab
                        @slot('title')
                            {{ __('General') }}
                        @endslot
                        @slot('body')
                            @formgroup
                                @forminput(['label' => __('Username'), 'type' => 'text', 'id' => 'username', 'placeholder' => __('Username placeholder'), 'required' => true])
                                @endforminput
                            @endformgroup
                            @formgroup
                                @forminput(['label' => __('Email'), 'type' => 'email', 'id' => 'email', 'placeholder' => __('Email placeholder'), 'required' => true])
                                @endforminput
                            @endformgroup
                            @formgroup
                                @forminput(['label' => __('Password'), 'type' => 'password', 'id' => 'password', 'placeholder' => __('Password placeholder'), 'required' => true])
                                @endforminput
                            @endformgroup
                            @formgroup
                                @forminput(['label' => __('Password repeat'), 'type'=> 'password', 'id' => 'password_repeat', 'placeholder' => __('Password repeat'), 'required' => true])
                                @endforminput
                            @endformgroup
                            @formgroup
                                @formselect(['label' => __('Role'), 'id' => 'role_id', 'required' => true, 'data' => $roles])
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