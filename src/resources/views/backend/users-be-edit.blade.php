@extends('../layouts.backend')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User: Edit ({{ $user->id }}) - <a href="{{ route('admin.users.backend.delete', ['id' => $user->id]) }}">{{ __('Delete') }}</a></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @isset ($user)
                            <form action="{{ route('admin.user.backend.edit.submit', ['id' => $user->id]) }}" method="post" role="form">
                                {{ csrf_field() }}
                                <div class="hidden">
                                    <input type="hidden" id="userid" name="userid" value="{{ $user->id }}">
                                </div>

                                <div class="form-group">
                                    <label for="username">{{ __('Username') }}</label>
                                    <input type="text" id="username" class="form-control" name="username" value="{{ !empty(old('username')) ? old('username') : $user->username }}" required autofocus placeholder="{{ __('Username placeholder') }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ __('Email')}}</label>
                                    <input type="email" id="email" class="form-control" name="email" value="{{ !empty(old('email')) ? old('email') : $user->email }}" required>
                                </div>
                                {{--<div class="form-group">--}}
                                    {{--<label for="password">{{ __('Password') }}</label>--}}
                                    {{--<input type="password" id="password" class="form-control" name="password" placeholder="{{ __('Will not be changed if empty') }}">--}}
                                {{--</div>--}}
                                <div class="form-group">
                                    <label for="role">{{ __('Role') }}</label>
                                    <select name="role_id" id="role_id" class="form-control" required>
                                        @foreach ($roles as $role)
                                            {{ dump($user->role_id) }}
                                            {{ dump($role->id) }}
                                            @if ($user->role_id == $role->id)
                                                <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                                            @else
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="{{ __('Save') }}">
                                </div>
                            </form>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection