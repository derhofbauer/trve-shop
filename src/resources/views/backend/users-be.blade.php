@extends('../layouts.backend')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Users</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @forelse ($users as $user)
                            <div>{{ $user->username }}</div>
                        @empty
                            <p>No users found!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
