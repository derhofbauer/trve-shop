@if(!isset($disableInputs) || $disableInputs !== true)
<form action="{{ route('cart.update') }}" method="post" role="form" class="form">
    @csrf
@endif

    <table>
        <thead>
        <tr>
            <th>{{ __('Product') }}</th>
            <th>{{ __('Quantity') }}</th>
            <th>{{ __('Price') }}</th>
            <th>{{ __('Total') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cart as $entry)
            <tr class="cart__entry" data-price="{{ $entry->product->price }}">
                <td class="product">
                    <a href="{{ route('products', ['id' => $entry->product->id]) }}">
                        {{ $entry->product->name }}
                    </a>
                </td>
                <td class="quantity">
                    <input type="number" class="form-control" name="new_product_quantity[{{ $entry->product->id }}]" value="{{ $entry->product_quantity }}" @if(isset($disableInputs) && $disableInputs) readonly @endif>
                    @if(!isset($disableInputs) || $disableInputs !== true)
                        <button class="btn btn-default" type="submit">{{ __('Save') }}</button>
                        <a href="{{ route('cart.remove', ['id' => $entry->product->id]) }}" class="btn btn-danger">
                            {{ __('remove') }}
                        </a>
                    @endif
                </td>
                <td class="price">
                    {{ $entry->product->price }} &euro;
                </td>
                <td class="total">
                    {{ $entry->product->price * $entry->product_quantity }} &euro;
                </td>
            </tr>
        @endforeach
        <tr class="total">
            <td></td>
            <td></td>
            <td class="bold">
                {{ __('Total') }}:
            </td>
            <td>
                {{ \App\Http\Controllers\Frontend\CartController::getCartTotal(request()) }} &euro;
            </td>
        </tr>
        </tbody>
    </table>
@if(!isset($disableInputs) || $disableInputs !== true)
</form>
@endif