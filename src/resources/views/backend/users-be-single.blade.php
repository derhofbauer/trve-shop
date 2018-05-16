@extends('../layouts.backend')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User: Edit ({{ $user->id }})</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @isset ($user)
                            <div>{{ $user->username }}</div>
                        @endisset

                        @empty ($user)
                            <p>User not found!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection