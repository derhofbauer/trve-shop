@if(!empty($cart))
    @include('frontend.partials.cart-table')

    @auth('web')
        <div class="buy">
            <a href="{{ route('checkout') }}" class="btn btn-primary">{{ __('Proceed To Checkout') }}</a>
        </div>
    @else
        <div class="buy">
            <a href="{{ route('login') }}" class="btn btn-primary">{{ __('Login') }}</a>
        </div>
    @endauth
@else
    <div class="alert alert-danger">
        <i data-feather="alert-circle"></i>
        <span class="alert__message">
            {{ __('You cart is empty.') }}
        </span>
    </div>
@endif