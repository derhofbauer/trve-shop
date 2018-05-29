@extends('layouts.frontend')

@section('content')
    <form action="{{ route('checkout.confirm') }}" method="post">
        @csrf

        <select name="address" id="address">
            @foreach($addresses as $address)
                <option value="{{ $address->id }}">{{ $address->city }}: {{ $address->street }}</option>
            @endforeach
        </select>
        <select name="payment_method" id="payment_method">
            @foreach($paymentMethods as $paymentMethod)
                <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->data['iban'] }}
                    ({{ $paymentMethod->data['swift'] }})
                </option>
            @endforeach
        </select>

        @forelse($user->cart as $entry)
            <div class="cart">
                <div class="cart__entry">
                    <div class="product">{{ $entry->product->name }}</div>
                    <div class="quantity">{{ $entry->product_quantity }}</div>
                </div>
            </div>
        @empty
            <p class="warning">{{ __('Your Cart is empty :(') }}</p>
        @endforelse

        @if($user->cart->count() > 0)
            <input type="submit" value="{{ __('Confirm') }}">
        @endif
    </form>

@endsection