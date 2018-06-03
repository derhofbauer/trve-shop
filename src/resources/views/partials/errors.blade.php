@if (session('status'))
    <div class="alert {{ session('status-class') }}">
        @switch(session('status-class'))
            @case('alert-danger')
                <i data-feather="alert-circle"></i>
                @break
            @case ('alert-success')
            @default
                <i data-feather="check-circle"></i>
                @break
        @endswitch
        <span class="alert__message">
            {{ session('status') }}
        </span>
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