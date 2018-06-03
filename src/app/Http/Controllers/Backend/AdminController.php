<?php

namespace App\Http\Controllers\Backend;

use App\SysBlogEntry;
use App\SysOrder;
use App\SysProduct;

/**
 * Class AdminController
 *
 * @package App\Http\Controllers\Backend
 */
class AdminController extends \App\Http\Controllers\Controller
{
    /**
     * AdminController constructor.
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
        $openOrders = SysOrder::where('status', '<', 4)->take(15)->orderBy('created_at', 'desc')->get(['id', 'status', 'feuser_id']);
        $blogEntries = SysBlogEntry::orderBy('created_at', 'desc')->take(15)->get(['id', 'title', 'created_at', 'beuser_id']);
        $lowStockProducts = SysProduct::where('stock', '<', 10)->orderBy('stock', 'asc')->get(['id', 'name', 'stock', 'hidden']);
        return view('backend.admin', [
            'tables' => [
                SysOrderController::prepareConfig([
                    'dataType' => __('Open Orders'),
                    'thead' => [
                        __('ID'),
                        __('Status'),
                        __('Customer'),
                        __('Total Price')
                    ],
                    'data' => $openOrders,
                    'ignoreData' => [
                        'feuser_id'
                    ],
                    'relatedData' => [
                        'feuser' => 'email'
                    ],
                    'hideButtons' => 'delete',
                    'methodData' => [
                        // $methodName => render information (sprintf)
                        'priceTotal' => '%s ' . __('€')
                    ]
                ]),
                SysProductController::prepareConfig([
                    'dataType' => __('Products with low stock numbers'),
                    'thead' => [
                        __('ID'),
                        __('Name'),
                        __('Stock'),
                        __('Hidden'),
                    ],
                    'data' => $lowStockProducts,
                    'hideButtons' => 'delete'
                ]),
                SysBlogEntryController::prepareConfig([
                    'thead' => [
                        __('ID'),
                        __('Title'),
                        __('Created at'),
                        __('Author')
                    ],
                    'data' => $blogEntries,
                    'ignoreData' => [
                        'beuser_id'
                    ],
                    'hideButtons' => 'delete',
                    'relatedData' => [
                        'author' => 'username'
                    ]
                ])
            ]
        ]);
    }
}
