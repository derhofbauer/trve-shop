@extends('layouts.frontend')

@section('content')
    <div class="container-fluid margin-auto">
        <div class="panel">
            <header class="panel__heading text-center">
                <h2>{{ __('Orders') }}</h2>
            </header>

            @if(!empty($orders))
                <table>
                    <thead>
                    <tr>
                        <th>{{ __('Order Number') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Products') }}</th>
                        <th>{{ __('Price') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr class="order">
                            <td class="order__number">{{ $order->id }}</td>
                            <td class="order__date">{{ $order->created_at }}</td>
                            <td class="order__products">
                                <ul>
                                    @foreach($order->invoice as $product)
                                        <li>
                                            {{ $product['name'] }} ({{ $product['quantity'] }}x)
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="order__price">{{ $order->getPriceFromInvoice() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="warning">{{ __('Nothing to show here :(') }}</p>
            @endif
        </div>
    </div>
@endsection