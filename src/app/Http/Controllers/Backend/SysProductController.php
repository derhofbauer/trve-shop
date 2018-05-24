<?php

namespace App\Http\Controllers\Backend;

use App\Http\Helpers\RouteHelper;
use App\SysProduct;
use App\SysProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class SysProductController
 *
 * @package App\Http\Controllers\Backend
 */
class SysProductController extends Controller implements BackendControllerInterface
{
    /**
     * SysProductController constructor.
     */
    public function __construct ()
    {
        $this->middleware('auth:admin');

        $this->storage_path = 'public/product_pictures';
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index ()
    {
        $products = SysProduct::allWithoutDeleted()->get(['id', 'name', 'stock', 'parent_product_id', 'new_until', 'hidden'])->sortBy('stock');

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

    /**
     * @param int|string $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show ($id)
    {
        $product = SysProduct::find($id);
        $selected_categories = [];
        foreach ($product->categories as $category) {
            $selected_categories[] = $category->id;
        }
        $children = [];
        foreach ($product->children as $child) {
            $children[] = $child->id;
        }
        $products = SysProduct::allWithoutDeleted()
            ->where('id', '!=', $id)// not self
            ->whereNull('parent_product_id')// not products that already are children of some other product
            ->get(['name', 'id'])
            ->sortBy('name');
        $categories = SysProductCategory::all(['name', 'id']);

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
                        ['label' => __('Media'), 'type' => 'media', 'id' => 'media', 'placeholder' => __('Media placeholder'), 'required' => false, 'value' => (array)$product->media],
                        ['label' => __('Add Media'), 'type' => 'file', 'id' => 'media[]', 'required' => false, 'placeholder' => __('Media placeholder'), 'multiple' => true],
                        ['label' => __('Parent'), 'type' => 'select', 'id' => 'parent_product_id', 'required' => false, 'data' => $products, 'value' => $product->parent_product_id],
                        ['label' => __('Category'), 'type' => 'select_multiple', 'id' => 'categories', 'required' => false, 'data' => $categories, 'value' => $selected_categories],
                        ['label' => __('New Until'), 'type' => 'date', 'id' => 'new_until', 'placeholder' => __('New Until'), 'required' => false, 'value' => $product->new_until],
                    ]
                ]
            ]
        ]));
    }

    /**
     * @param Request    $request
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update (Request $request, $id)
    {
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
        self::handleMedia($product, $request, $this->storage_path);
        self::handleDeleteMedia($product, $request);
        self::handleParent($product, $request);
        self::handleProductCategories($product, $request);

        $product->save();

        return redirect()->route('admin.products.edit', ['id' => $id]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createView ()
    {
        $products = SysProduct::allWithoutDeleted()
            ->whereNull('parent_product_id')// not products that already are children of some other product
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
                        ['label' => __('Add Media'), 'type' => 'file', 'id' => 'media[]', 'required' => false, 'placeholder' => __('Media placeholder'), 'multiple' => true],
                        ['label' => __('Parent'), 'type' => 'select', 'id' => 'parent_product_id', 'required' => false, 'data' => $products],
                        ['label' => __('New Until'), 'type' => 'date', 'id' => 'new_until', 'placeholder' => __('New Until'), 'required' => false],
                    ]
                ]
            ]
        ]));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create (Request $request)
    {
        $validationRules = self::getValidationRules();
        if ($request->input('parent_product_id') == "0") {
            unset($validationRules['parent_product_id']);
        }
        $validatedData = $request->validate($validationRules);

        $product = new SysProduct($validatedData);
        self::handleMedia($product, $request, $this->storage_path);
        self::handleParent($product, $request);

        $product->save();

        return redirect()->route('admin.products.edit', ['id' => $product->id]);
    }

    /**
     * @param Request    $request
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete (Request $request, $id)
    {
        $product = SysProduct::find($id);
        $product->deleted = true;
        $product->save();

        return redirect()->route('admin.products');
    }

    /**
     * @return array
     */
    public static function getValidationRules ()
    {
        return [
            'name' => 'required|string|min:1|unique:sys_product',
            'description' => 'string|nullable',
            'price' => 'numeric|nullable',
            'stock' => 'required|integer',
            'media' => '',
            'parent_product_id' => 'integer|exists:sys_product,id|nullable',
            'new_until' => 'date|nullable',
            'media' => 'sometimes|array|image|dimensions:min_width=250,min_height=250',
            'product_categories' => 'sometimes|array'
        ];
    }

    /**
     * @param array $additionalConfig
     *
     * @return array
     */
    public static function prepareConfig (array $additionalConfig)
    {
        return array_merge([
            'dataType' => __('Product'),
            'icon' => 'shopping-cart',
            'routes' => RouteHelper::prepareRouteConfigArray('admin.products'),
            'identifier' => 'name'
        ], $additionalConfig);
    }

    /**
     * @param SysProduct $product
     * @param Request    $request
     * @param string     $storagePath
     */
    public static function handleMedia (&$product, $request, $storagePath)
    {
        if ($request->has('media')) {
            foreach ($request->file('media') as $uploaded_file) {
                $product->addMedia($uploaded_file->store($storagePath));
            }
        }
    }

    /**
     * @param SysProduct $product
     * @param Request    $request
     */
    public static function handleDeleteMedia (&$product, $request)
    {
        if ($request->has('delete_media')) {
            foreach ($request->input('delete_media') as $path => $on) {
                $product->removeMedia($path);
            }
        }
    }

    /**
     * @param SysProduct $product
     * @param Request    $request
     */
    public static function handleParent (&$product, $request)
    {
        if ($request->input('parent_product_id') == "0") {
            $product->parent_product_id = null;
        }
    }

    /**
     * @param SysProduct $product
     * @param Request    $request
     */
    public static function handleProductCategories (&$product, $request)
    {
        if ($request->has('product_categories')) {
            foreach ($request->input('product_categories') as $category => $on) {
                $product->addCategory(SysProductCategory::find($category));
            }
            foreach ($product->categories as $category) {
                if (!in_array($category->id, array_keys($request->input('product_categories')))) {
                    $product->categories()->detach($category);
                }
            }
        } else {
            $product->categories()->detach($product->categories);
        }
    }
}
