@extends('layouts.frontend')

@section('content')
    @forelse($orders as $order)
        <div class="order">
            <div class="order__number">{{ $order->id }}</div>
            <div class="order__date">{{ $order->created_at }}</div>
            <div class="order__price">{{ $order->getPriceFromInvoice(9) }}</div>
        </div>
    @empty
        <p class="warning">{{ __('Nothing to show here :(') }}</p>
    @endforelse
@endsection