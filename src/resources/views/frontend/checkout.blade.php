@extends('layouts.frontend')

@section('content')
    <div class="container col-sm-10 margin-auto">
        <div class="panel">
            <form action="{{ route('checkout.confirm') }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-sm-6">
                        <label for="address">{{ __('Delivery Address') }}</label>
                        <select name="address" id="address" class="form-control">
                            @foreach($addresses as $address)
                                <option value="{{ $address->id }}">{{ $address->city }}: {{ $address->street }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="payment_method">{{ __('Payment Method') }}</label>
                        <select name="payment_method" id="payment_method" class="form-control">
                            @foreach($paymentMethods as $paymentMethod)
                                <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->data['iban'] }}
                                    ({{ $paymentMethod->data['swift'] }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <textarea name="address_new" id="address_new" class="form-control address_new" placeholder="{{ __('You can add a delivery address for this order only.') }}"></textarea>
                    </div>
                </div>

                <div class="container-padding-top">
                    @include('frontend.partials.cart-table', [
                    'cart' => $user->cart,
                    'disableInputs' => true
                    ])
                </div>

                @if($user->cart->count() > 0)
                    <div class="container-padding-top">
                        <input type="submit" value="{{ __('Confirm') }}" class="btn btn-primary btn-justify">
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection