<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RouteHelper;
use App\SysFeuser;
use App\SysOrder;
use App\SysOrderProductMM;
use App\SysProduct;
use Illuminate\Http\Request;

/**
 * Class SysOrderController
 *
 * @package App\Http\Controllers\Backend
 */
class SysOrderController extends Controller implements BackendControllerInterface
{
    /**
     * SysOrderController constructor.
     */
    public function __construct ()
    {
        $this->middleware('auth:admin');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index ()
    {
        $orders = SysOrder::all('id', 'status', 'feuser_id')->sortBy('created_at');

        return view('backend/list', self::prepareConfig([
            'thead' => [
                __('ID'),
                __('Status'),
                __('Customer'),
                __('Total Price')
            ],
            'data' => $orders,
            'ignoreData' => [
                'feuser_id'
            ],
            'relatedData' => [
                'feuser' => 'email'
            ],
            'methodData' => [
                // $methodName => render information (sprintf)
                'priceTotal' => '%s ' . __('€')
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
        $order = SysOrder::find($id);
        $feusers = SysFeuser::all('email AS name', 'id');
        $products = SysProduct::all('name', 'id');

        if ($order->productsMM->count() > 0) {
            $orderField = ['label' => __('Products'), 'type' => 'products', 'id' => 'products', 'required' => true, 'value' => $orderProducts];
        } else {
            $orderField = ['label' => __('Products'), 'type' => 'products-static', 'id' => 'products-static', 'value' => $order->invoice];
        }

        return view('backend/edit', self::prepareConfig([
            'object' => $order,
            'tabs' => [
                [
                    'title' => __('General'),
                    'fields' => [
                        ['label' => __('Order Number'), 'type' => 'text', 'id' => 'id', 'placeholder' => __('Order Number'), 'readonly' => true, 'value' => $order->id],
                        ['label' => __('Status'), 'type' => 'select', 'id' => 'status', 'required' => false, 'data' => SysOrder::getStates(), 'value' => $order->status],
                        ['label' => __('Delivery Address'), 'type' => 'textarea', 'id' => 'delivery_address', 'placeholder' => __('Delivery Address'), 'required' => true, 'value' => $order->delivery_address],
                        ['label' => __('Customer'), 'type' => 'select', 'id' => 'feuser_id', 'required' => true, 'data' => $feusers, 'value' => $order->feuser_id],
                        ['label' => __('Payment Method'), 'type' => 'textarea', 'id' => 'payment_method', 'placeholder' => __('Payment Method'), 'required' => true, 'value' => $order->payment_method],
                        $orderField,
                        ['label' => __('Add Products'), 'type' => 'select', 'id' => 'add_product', 'required' => true, 'data' => $products],
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
        $order = SysOrder::find($id);
        $validatedData = $request->validate(self::getValidationRules());

        $order->fill($validatedData);
        self::handleProducts($order, $request);
        self::handleDeletedProducts($order, $request);

        $order->save();

        return redirect()->route('admin.orders.edit', ['id' => $id]);
    }

    public function createView ()
    {
        $feusers = SysFeuser::all('email AS name', 'id');
        $products = SysProduct::all('name', 'id');

        return view('backend/create', self::prepareConfig([
            'tabs' => [
                [
                    'title' => __('General'),
                    'fields' => [
                        ['label' => __('Status'), 'type' => 'select', 'id' => 'status', 'required' => true, 'data' => SysOrder::getStates()],
                        ['label' => __('Delivery Address'), 'type' => 'textarea', 'id' => 'delivery_address', 'placeholder' => __('Delivery Address'), 'required' => true],
                        ['label' => __('Customer'), 'type' => 'select', 'id' => 'feuser_id', 'required' => true, 'data' => $feusers],
                        ['label' => __('Payment Method'), 'type' => 'textarea', 'id' => 'payment_method', 'placeholder' => __('Payment Method'), 'required' => true, ],
                        ['label' => __('Add Products'), 'type' => 'select', 'id' => 'add_product', 'required' => true, 'data' => $products]
                    ]
                ]
            ]
        ]));
    }

    public function create (Request $request)
    {
        $validatedData = $request->validate(self::getValidationRules());

        $order = new SysOrder($validatedData);
        $order->save();

        self::handleProducts($order, $request);

        $order->save();

        return redirect()->route('admin.orders.edit', ['id' => $order->id]);
    }

    public function delete (Request $request, $id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param array $additionalConfig
     *
     * @return array
     */
    public static function prepareConfig (array $additionalConfig)
    {
        return array_merge([
            'dataType' => __('Order'),
            'icon' => 'shopping-cart',
            'routes' => RouteHelper::prepareRouteConfigArray('admin.orders'),
            'identifier' => 'id'
        ], $additionalConfig);
    }

    /**
     * @return array
     */
    public static function getValidationRules ()
    {
        return [
            'status' => 'required|in:0,1,2,99',
            'delivery_address' => 'required|string',
            'feuser_id' => 'required|exists:sys_feusers,id',
            'payment_method' => 'required|string',
            'delete_product' => 'sometimes|array',
            'add_product' => 'sometimes|integer'
        ];
    }

    /**
     * @param SysOrder $order
     * @param Request  $request
     */
    public static function handleProducts (&$order, $request)
    {
        if ($request->has('add_product') && $request->input('add_product') > 0) {
            $id = $request->input('add_product');
            $productsMM = $order->productsMM()->where('product_id', '=', $id)->get();

            if ($productsMM->count() > 0) {
                foreach ($productsMM as $productMM) {
                    $productMM->product_quantity += 1;
                    $productMM->save();
                }
            } else {
                $productMM = new SysOrderProductMM([
                    'product_id' => $id,
                    'product_quantity' => 1
                ]);
                $order->productsMM()->save($productMM);
            }

        }
    }

    /**
     * @param SysOrder $order
     * @param Request  $request
     */
    public static function handleDeletedProducts (&$order, $request)
    {
        if ($request->has('delete_product')) {
            foreach ($request->input('delete_product') as $id => $on) {
                $productsMM = $order->productsMM()->where('product_id', '=', $id)->get();
                foreach ($productsMM as $productMM) {
                    $productMM->delete();
                }
            }
        }
    }
}
