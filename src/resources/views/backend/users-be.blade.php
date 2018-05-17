@extends('../layouts.backend')

@section('content')
    <div class="module">
        <div class="module__header container">
            <a href="{{ route('admin.user.backend.create') }}">{{ __('New') }}</a>
        </div>
        <div class="module__body container">
            <div class="card">
                <div class="card__header">
                    <h3>{{ __('Backend Users') }} ({{ count($users) }})</h3>
                </div>
                <div class="card__body">
                    <table>
                        <thead>
                        <tr>
                            <th>{{-- Add --}}</th>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Username') }}</th>
                            <th>{{ __('Password') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{-- Icon --}}</td>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email  }}</td>
                                <td>
                                    <a href="{{ route('admin.users.backend.edit', ['id' => $user->id]) }}">{{ __('Edit') }}</a>
                                </td>
                            </tr>
                        @empty
                            <p>No users found!</p>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection