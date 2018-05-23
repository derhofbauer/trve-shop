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
        $products = SysProduct::allWithoutDeleted()->get(['id', 'name', 'stock', 'parent_product_id', 'new_until', 'hidden'])->sortByDesc('stock');

        return view('backend/list', self::prepareConfig([
            'thead' => [
                __('ID'),
                __('Name'),
                __('Stock'),
                __('New Until'),
                __('Hidden'),
                __('Parent Product'),
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
        $children = [];
        foreach ($product->children as $child) {
            $children[] = $child->id;
        }
        $products = SysProduct::allWithoutDeleted()
            ->where('id', '!=', $id) // not self
            ->whereNull('parent_product_id') // not products that already are children of some other product
            ->get(['name', 'id'])
            ->sortBy('name');

        return view('backend/edit', self::prepareConfig([
            'object' => $product,
            'tabs' => [
                [
                    'title' => __('General'),
                    'fields' => [
                        ['label' => __('Name'), 'type' => 'text', 'id' => 'name', 'placeholder' => __('Name placeholder'), 'required' => true, 'value' => $product->name],
                        ['label' => __('Description'), 'type' => 'editor', 'id' => 'description', 'placeholder' => __('Description placeholder'), 'required' => false, 'value' => $product->description],
                        ['label' => __('Price (€)'), 'type' => 'number', 'id' => 'price', 'placeholder' => __('Price placeholder'), 'required' => false, 'value' => $product->price],
                        ['label' => __('Stock'), 'type' => 'number', 'id' => 'stock', 'placeholder' => __('Stock placeholder'), 'required' => true, 'value' => $product->stock],
                        ['label' => __('Hidden'), 'type' => 'checkbox', 'id' => 'hidden', 'required' => false, 'checked' => (bool)$product->hidden],
                        ['label' => __('Media'), 'type' => 'media', 'id' => 'media', 'placeholder' => __('Media placeholder'), 'required' => false, 'value' => $product->media],
                        ['label' => __('Parent'), 'type' => 'select', 'id' => 'parent_product_id', 'required' => false, 'data' => $products, 'value' => $product->parent_product_id],
                        ['label' => __('New Until'), 'type' => 'date', 'id' => 'new_until', 'placeholder' => __('New Until'), 'required' => false, 'value' => $product->new_until],
                    ]
                ]
            ]
        ]));
    }

    public function update (Request $request, $id)
    {
        // TODO: implement file upload
        $product = SysProduct::find($id);
        $validationRules = self::getValidationRules();

        if ($product->name == $request->input('name')) {
            unset($validationRules['name']);
        }
        if ($request->input('parent_product_id') == "0") {
            unset($validationRules['parent_product_id']);
        }

        $validatedData = $request->validate($validationRules);

        $product->fill($validatedData);
        if ($request->input('parent_product_id') == "0") {
            $product->parent_product_id = null;
        }
        $product->save();

        return redirect()->route('admin.products');
    }

    public function createView ()
    {
        $products = SysProduct::allWithoutDeleted()
            ->whereNull('parent_product_id') // not products that already are children of some other product
            ->get(['name', 'id'])
            ->sortBy('name');

        /**
         * `required` is false on nearly all fields, because a product might inherit values from the parent product and
         *      does not need to have own values other than a name.
         */
        return view('backend/create', self::prepareConfig([
            'tabs' => [
                [
                    'title' => __('General'),
                    'fields' => [
                        ['label' => __('Name'), 'type' => 'text', 'id' => 'name', 'placeholder' => __('Name placeholder'), 'required' => true],
                        ['label' => __('Description'), 'type' => 'editor', 'id' => 'description', 'placeholder' => __('Description placeholder'), 'required' => false],
                        ['label' => __('Price (€)'), 'type' => 'number', 'id' => 'price', 'placeholder' => __('Price placeholder'), 'required' => false],
                        ['label' => __('Stock'), 'type' => 'number', 'id' => 'stock', 'placeholder' => __('Stock placeholder'), 'required' => true],
                        ['label' => __('Hidden'), 'type' => 'checkbox', 'id' => 'hidden', 'required' => false],
                        ['label' => __('Media'), 'type' => 'media', 'id' => 'media', 'placeholder' => __('Media placeholder'), 'required' => false],
                        ['label' => __('Parent'), 'type' => 'select', 'id' => 'parent_product_id', 'required' => false, 'data' => $products],
                        ['label' => __('New Until'), 'type' => 'date', 'id' => 'new_until', 'placeholder' => __('New Until'), 'required' => false],
                    ]
                ]
            ]
        ]));
    }

    public function create (Request $request)
    {
        // TODO: implement file upload
        $validatedData = $request->validate(self::getValidationRules());

        $product = new SysProduct($validatedData);
        $product->save();

        return redirect()->route('admin.products');
    }

    public function delete (Request $request, $id)
    {
        $product = SysProduct::find($id);
        $product->deleted = true;
        $product->save();

        return redirect()->route('admin.products');
    }

    public static function getValidationRules ()
    {
        return [
            'name' => 'required|string|min:1|unique:sys_product',
            'description' => 'string|nullable',
            'price' => 'numeric|nullable',
            'stock' => 'required|integer',
            'media' => '',
            'parent_product_id' => 'integer|exists:sys_product,id|nullable',
            'new_until' => 'date|nullable'
        ];
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
