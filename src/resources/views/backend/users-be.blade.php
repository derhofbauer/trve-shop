@extends('../layouts.backend')

@section('content')
    <div class="module">
        <div class="module__header container">
            <a href="{{ route('admin.user.backend.create') }}">{{ __('New') }}</a>
        </div>
        <div class="module__body container">
        </div>
    </div>
@endsection

@section('card')
    <div class="card">
        <div class="card__header">{{ __('Backend Users') }}</div>
        <div class="card__body">
            <table>
                <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Username') }}</th>
                    <th>{{ __('Password') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($users as $user)
                    <tr>
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
@endsection