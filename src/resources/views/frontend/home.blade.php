@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Frontend</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @auth('web')
                        You are logged in into the Frontend!
                    @else
                        You are NOT logged in into the Frontend!
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
