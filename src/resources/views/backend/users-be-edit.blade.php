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
                                <label for="username">{{ __('Username') }}</label>
                                <input type="text" id="username" class="form-control" name="username" value="{{ !empty(old('username')) ? old('username') : $user->username }}" required autofocus placeholder="{{ __('Username placeholder') }}">
                            @endformgroup
                            @formgroup
                                <label for="email">{{ __('Email')}}</label>
                                <input type="email" id="email" class="form-control" name="email" value="{{ !empty(old('email')) ? old('email') : $user->email }}" required>
                            @endformgroup
                            @formgroup
                                <label for="role">{{ __('Role') }}</label>
                                <select name="role_id" id="role_id" class="form-control" required>
                                    @foreach ($roles as $role)
                                        @if ($user->role_id == $role->id)
                                            <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                                        @else
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
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