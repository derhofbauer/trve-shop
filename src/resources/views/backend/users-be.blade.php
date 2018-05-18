@extends('../layouts.backend')

@section('content')
    <div class="module">
        <div class="module__header container">
            <a href="{{ route('admin.users.backend.create') }}" class="btn btn-icon">
                <i data-feather="plus"></i>
            </a>
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
                            <th>
                                <a href="{{ route('admin.users.backend.create') }}">
                                    <i class="btn btn-icon" data-feather="plus"></i>
                                </a>
                            </th>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Username') }}</th>
                            <th>{{ __('E-Mail') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.users.backend.edit', ['id' => $user->id]) }}">
                                        <i class="icon icon--card" data-feather="user"></i>
                                    </a>
                                </td>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email  }}</td>
                                <td>
                                    <a href="{{ route('admin.users.backend.edit', ['id' => $user->id]) }}" class="btn btn-icon">
                                        <i data-feather="edit-2"></i>
                                    </a>
                                    <a href="{{ route('admin.users.backend.delete', ['id' => $user->id]) }}" class="btn btn-icon">
                                        <i data-feather="trash-2"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection