@if (session('status'))
    <div class="alert {{ session('status-class') }}">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="errors">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                <i data-feather="alert-circle"></i>
                <span class="alert__message">{{ $error }}</span>
            </div>
        @endforeach
    </div>
@endif