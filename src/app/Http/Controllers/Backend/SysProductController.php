<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\BackendControllerInterface;
use App\Http\Helpers\RouteHelper;
use App\SysProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SysProductController extends Controller implements BackendControllerInterface
{
    public function __construct ()
    {
        $this->middleware('auth:admin');
    }

    public function index ()
    {
        $products = SysProduct::all(['id', 'name', 'stock', 'parent_product_id', 'new_until'])->sortByDesc('stock');
        return view('backend/list', self::prepareConfig([
            'thead' => [
                __('ID'),
                __('Name'),
                __('Stock'),
                __('New Until'),
                __('Parent Product')
            ],
            'data' => $products,
            'ignoreData' => [
                'parent_product_id'
            ],
            'relatedData' => [
                'parent' => 'name'
            ]
        ]));
    }

    public function show ($id)
    {
        $product = SysProduct::find($id);
        $products = SysProduct::all();

        return view('backend/edit', self::prepareConfig([
            'object' => $product,
            'tabs' => [
                [
                    'title' => __('General'),
                    'fields' => [
                        ['label' => __('Name'), 'type' => 'text', 'id' => 'name', 'placeholder' => __('Name placeholder'), 'required' => true, 'value' => $product->name]
                    ]
                ]
            ]
        ]));
    }

    public function update (Request $request, $id)
    {
        // TODO: Implement update() method.
    }

    public function createView ()
    {
        // TODO: Implement createView() method.
    }

    public function create (Request $request)
    {
        // TODO: Implement create() method.
    }

    public function delete (Request $request, $id)
    {
        // TODO: Implement delete() method.
    }

    public static function getValidationRules ()
    {
        // TODO: Implement getValidationRules() method.
    }

    public static function prepareConfig (array $additionalConfig)
    {
        return array_merge([
            'dataType' => __('Product'),
            'icon' => 'shopping-cart',
            'routes' => RouteHelper::prepareRouteConfigArray('admin.products'),
            'identifier' => 'name'
        ], $additionalConfig);
    }
}
