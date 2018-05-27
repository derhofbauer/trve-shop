<?php

namespace App\Http\Controllers\Frontend;

use App\SysProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class SysProductController
 *
 * @package App\Http\Controllers\Frontend
 */
class SysProductController extends Controller
{
    /**
     * SysProductController constructor.
     */
    public function __construct ()
    {
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index ()
    {
        $products = SysProduct::allVisible();

        return view('frontend.product', self::prepareConfig([
            'data' => $products
        ]));
    }

    /**
     * @param integer $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show ($id)
    {
        $product = SysProduct::find($id);

        return view('frontend.product-show', self::prepareConfig([
            'object' => $product
        ]));
    }

    /**
     * @param array $additionalConfig
     *
     * @return array
     */
    public static function prepareConfig (array $additionalConfig)
    {
        return array_merge([

        ], $additionalConfig);
    }
}
