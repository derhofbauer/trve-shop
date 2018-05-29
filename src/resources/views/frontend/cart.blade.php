@extends('layouts.frontend')

@section('content')
    <form action="{{ route('cart.update') }}" method="post">
        @csrf
    @forelse($cart as $entry)
        <div class="cart">
            <div class="cart__entry">
                <div class="product">{{ $entry->product->name }}</div>
                <div class="quantity">
                    <input type="number" class="form-control" name="new_product_quantity[{{ $entry->product->id }}]" value="{{ $entry->product_quantity }}">
                    <input type="submit" value="{{ __('Save') }}">
                </div>
                <div class="remove">
                    <a href="{{ route('cart.remove', ['id' => $entry->product->id]) }}">{{ __('remove') }}</a>
                </div>
            </div>
        </div>
    @empty
        <div class="warning">{{ __('You cart is empty.') }}</div>
    @endforelse
    </form>

    @if(!empty($cart))
        <div class="buy">
            <a href="{{ route('checkout') }}">{{ __('Buy') }}</a>
        </div>
    @endif
@endsection