@extends('../layouts.backend')

@section('content')
    @module
        @slot('header')
            <a href="{{ route('admin.users.backend.create') }}" class="btn btn-icon">
                <i data-feather="plus"></i>
            </a>
        @endslot

        @slot('body')
            @card
                @slot('title')
                    {{ __('Backend Users') }} ({{ count($users) }})
                @endslot

                @slot('body')
                    @table
                        @slot('thead')
                            <th>
                                <a href="{{ route('admin.users.backend.create') }}">
                                    <i class="btn btn-icon" data-feather="plus"></i>
                                </a>
                            </th>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Username') }}</th>
                            <th>{{ __('E-Mail') }}</th>
                            <th></th>
                        @endslot

                        @slot('tbody')
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
                        @endslot
                    @endtable
                @endslot
            @endcard
        @endslot
    @endmodule
@endsection