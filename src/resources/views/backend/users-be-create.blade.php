@extends('../layouts.backend')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User: Create</div>

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

                        <form action="{{ route('admin.user.backend.create.submit') }}" method="post" role="form">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="username">{{ __('Username') }}</label>
                                <input type="text" id="username" class="form-control" name="username" value="{{ old('username') }}" required autofocus placeholder="{{ __('Username placeholder') }}">
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Email')}}</label>
                                <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="{{ __('Email placeholder') }}">
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input type="password" id="password" class="form-control" name="password" placeholder="{{ __('Password placeholder') }}">
                            </div>
                            <div class="form-group">
                                <label for="password_repeat">{{ __('Repeat Password') }}</label>
                                <input type="password" id="password_repeat" class="form-control" name="password_repeat" placeholder="{{ __('Repeat Password placeholder') }}">
                            </div>
                            <div class="form-group">
                                <label for="role">{{ __('Role') }}</label>
                                <select name="role_id" id="role_id" class="form-control" required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="{{ __('Save') }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection