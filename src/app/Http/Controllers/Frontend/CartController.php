<?php

namespace App\Http\Controllers\Frontend;

use App\SysCartEntry;
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

        return view('frontend/cart', self::prepareConfig([
            'cart' => $cart
        ]));
    }

    /**
     * @param Request $request
     * @param integer $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToCart (Request $request, $id)
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

        return redirect()->route('cart');
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
    public function mergeCarts (Request $request) {
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
}
