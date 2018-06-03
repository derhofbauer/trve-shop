<?php

namespace App\Http\Controllers\Frontend;

use App\SysAddress;
use App\SysCartEntry;
use App\SysOrder;
use App\SysPaymentMethod;
use App\SysProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class CartController
 *
 * @package App\Http\Controllers\Frontend
 */
class CartController extends Controller
{
    /**
     * CartController constructor.
     */
    public function __construct ()
    {
        // $this->middleware('auth:web');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index (Request $request)
    {
        if (Auth::guest()) {
            $entries = $request->session()->get('cart', function () {
                return [];
            });
            if ($entries == null) {
                $entries = [];
            }
        } else {
            $this->mergeCarts($request);
            $entries = Auth::user()->cart;
        }

        $cart = [];
        foreach ($entries as $entry) {
            if (!is_object($entry) && is_array($entry)) {
                $cart[] = new SysCartEntry([
                    'product_id' => $entry['id'],
                    'product_quantity' => $entry['quantity']
                ]);
            } else {
                $cart[] = $entry;
            }
        }

        // sort by product_id
        usort($cart, function ($a, $b) {
            return strcmp($a->product_id, $b->product_id);
        });

        return view('frontend/cart', self::prepareConfig([
            'cart' => $cart
        ]));
    }

    /**
     * @param Request     $request
     * @param integer     $id
     * @param string|null $returnUrl
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToCart (Request $request, $id, $returnUrl = null)
    {
        if (Auth::guest()) {
            if (!$request->session()->has('cart')) {
                $request->session()->put('cart', []);
            }
            $cart = $request->session()->get('cart');
            $set = false;
            foreach ($cart as $key => $entry) {
                if ($entry['id'] == $id) {
                    $cart[$key]['quantity'] += 1;
                    $set = true;
                }
            }
            $request->session()->put('cart', $cart);
            if ($set === false) {
                $request->session()->push('cart', [
                    'id' => $id,
                    'quantity' => 1
                ]);
            }
        } else {
            $this->mergeCarts($request);
            if (SysProduct::find($id)->exists()) {
                $cart = Auth::user()->cart;


                if (SysCartEntry::where('product_id', $id)->where('feuser_id', Auth::user()->id)->exists()) {
                    $entries = SysCartEntry::where('product_id', $id)->where('feuser_id', Auth::user()->id)->get();

                    foreach ($entries as $entry) {
                        $entry->product_quantity += 1;
                        $entry->save();
                    }
                } else {
                    $entry = new SysCartEntry([
                        'product_id' => $id,
                        'product_quantity' => 1,
                        'feuser_id' => Auth::user()->id
                    ]);
                    $entry->save();
                }
            }
        }

        $request->session()->flash('status', __('Product was successfully added to your cart.'));
        $request->session()->flash('status-class', 'alert-success');

        if ($returnUrl != null) {
            $returnUrl = base64_decode($returnUrl);
            return redirect($returnUrl);
        }

        return redirect()->route('shop');
    }

    /**
     * @param Request $request
     * @param integer $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeFromCart (Request $request, $id)
    {
        if (Auth::guest()) {
            if ($request->session()->has('cart')) {
                $cart = $request->session()->get('cart');

                foreach ($cart as $key => $entry) {
                    if ($entry['id'] == $id) {
                        unset($cart[$key]);
                    }
                }
                $request->session()->put('cart', $cart);
            }
        } else {
            $this->mergeCarts($request);

            SysCartEntry::where('feuser_id', Auth::user()->id)->where('product_id', $id)->delete();
        }

        $request->session()->flash('status', __('Product was successfully removed from your cart.'));
        $request->session()->flash('status-class', 'alert-success');

        return redirect()->route('cart');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update (Request $request)
    {
        $validatedData = $request->validate([
            'new_product_quantity' => 'sometimes|array'
        ]);

        if (Auth::guest() && $request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
            foreach ($validatedData['new_product_quantity'] as $id => $quantity) {
                foreach ($cart as $key => $cartEntry) {
                    if ($cartEntry['id'] == $id) {
                        if ($quantity == 0) {
                            unset($cart[$key]);
                        } else {
                            $cart[$key]['quantity'] = $quantity;
                        }
                    }
                }
            }
            $request->session()->put('cart', $cart);
        } else {
            $this->mergeCarts($request);

            foreach ($validatedData['new_product_quantity'] as $id => $quantity) {
                $cartEntries = Auth::user()->cart()->where('product_id', $id)->get();
                foreach ($cartEntries as $entry) {
                    if ($quantity == 0) {
                        $entry->delete();
                    } else {
                        $entry->product_quantity = (int)$quantity;
                        $entry->save();
                    }
                }
            }
        }

        $request->session()->flash('status', __('Your cart was successfully updated.'));
        $request->session()->flash('status-class', 'alert-success');

        return redirect()->route('cart');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkout (Request $request)
    {
        $user = Auth::user();

        $payment_methods = $user->paymentMethods;
        $addresses = $user->addresses;

        return view('frontend.checkout', [
            'user' => $user,
            'paymentMethods' => $payment_methods,
            'addresses' => $addresses
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirmAndBuy (Request $request)
    {
        $user = Auth::user();
        $cart = $user->cart;

        $products = [];
        foreach ($cart as $entry) {
            $product = $entry->product->toArray();
            $product['quantity'] = $entry->product_quantity;
            $products[] = $product;

            $entry->product->stock = $entry->product->stock - $entry->product_quantity;
            $entry->product->save();
        }

        $validatedData = $request->validate([
            'address' => 'integer|required|exists:sys_address,id',
            'payment_method' => 'integer|required|exists:sys_payment_method,id',
            'address_new' => 'sometimes|string|nullable'
        ]);

        $order = new SysOrder([
            'status' => 0,
            'invoice' => $products,
            'feuser_id' => $user->id,
            'payment_method' => json_encode(SysPaymentMethod::find($validatedData['payment_method'])->toArray())
        ]);
        if (!empty($validatedData['address_new'])) {
            $order->delivery_address = json_encode($validatedData['address_new']);
        } else {
            $order->delivery_address = json_encode(SysAddress::find($validatedData['address'])->toArray());
        }
        $order->save();

        foreach ($cart as $entry) {
            $entry->delete();
        }

        return view('frontend.checkout-success', [
            'order' => $order
        ]);
    }

    /**
     * @param array $additionalConfig
     *
     * @return array
     */
    public static function prepareConfig (array $additionalConfig)
    {
        return array_merge([
            'user' => Auth::user()
        ], $additionalConfig);
    }

    /**
     * @param Request $request
     */
    public function mergeCarts (Request $request)
    {
        if (!Auth::guest() && $request->session()->has('cart')) {
            foreach ($request->session()->pull('cart') as $entry) {
                if (is_array($entry)) {
                    $cartEntry = new SysCartEntry([
                        'feuser_id' => Auth::user()->id,
                        'product_id' => $entry['id'],
                        'product_quantity' => $entry['quantity']
                    ]);
                    $cartEntry->save();
                }
            }
        }
    }

    /**
     * @param Request $request
     *
     * @return float|int
     */
    public static function getCartTotal (Request $request)
    {
        if (Auth::guest()) {
            $entries = $request->session()->get('cart', function () {
                return [];
            });
            $total = 0;
            foreach ($entries as $entry) {
                $product = SysProduct::find($entry['id']);
                $total += $product->price * $entry['quantity'];
            }
        } else {
            $entries = Auth::user()->cart;
            $total = 0;
            foreach ($entries as $entry) {
                $total += $entry->product->price * $entry->product_quantity;
            }
        }
        return $total;
    }
}
