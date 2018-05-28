@extends('layouts.frontend')

@section('content')
    @forelse($cart as $entry)
        <div class="cart">
            <div class="cart__entry">
                <div class="product">{{ $entry->product->name }}</div>
                <div class="quantity">{{ $entry->product_quantity }}</div>
                <div class="remove">
                    <a href="{{ route('cart.remove', ['id' => $entry->product->id]) }}">{{ __('remove') }}</a>
                </div>
            </div>
        </div>
    @empty
        <div class="warning">{{ __('You cart is empty.') }}</div>
    @endforelse
@endsection