<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RouteHelper;
use App\SysComment;
use App\SysFeuser;
use App\SysProduct;
use Illuminate\Http\Request;

/**
 * Class SysCommentController
 *
 * @package App\Http\Controllers\Backend
 */
class SysCommentController extends Controller implements BackendControllerInterface
{
    /**
     * SysCommentController constructor.
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
        $comments = SysComment::all('id', 'content', 'product_id', 'feuser_id');

        return view('backend/list', self::prepareConfig([
            'thead' => [
                __('ID'),
                __('Content'),
                __('Product'),
                __('Author')
            ],
            'data' => $comments,
            'ignoreData' => [
                'product_id',
                'feuser_id'
            ],
            'relatedData' => [
                'product' => 'name',
                'author' => 'email'
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
        $comment = SysComment::find($id);
        $products = SysProduct::all('name', 'id');
        $feusers = SysFeuser::all('email AS name', 'id');
        return view('backend/edit', self::prepareConfig([
            'object' => $comment,
            'tabs' => [
                [
                    'title' => __('General'),
                    'fields' => [
                        ['label' => __('Content'), 'type' => 'textarea', 'id' => 'content', 'placeholder' => __('Comment'), 'required' => true, 'value' => $comment->content],
                        ['label' => __('Product'), 'type' => 'select', 'id' => 'product_id', 'required' => true, 'data' => $products, 'value' => $comment->product_id],
                        ['label' => __('Author'), 'type' => 'select', 'id' => 'feuser_id', 'required' => true, 'data' => $feusers, 'value' => $comment->feuser_id],
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
        $validatedData = $request->validate(self::getValidationRules());

        $comment = SysComment::find($id);

        $comment->fill($validatedData);
        $comment->save();

        return redirect()->route('admin.comments');
    }

    public function createView ()
    {
        // TODO: Implement createView() method.
    }

    public function create (Request $request)
    {
        // TODO: Implement create() method.
    }

    /**
     * @param Request    $request
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete (Request $request, $id)
    {
        $comment = SysComment::find($id);
        $comment->delete();

        return redirect()->route('admin.comments');
    }

    /**
     * @param array $additionalConfig
     *
     * @return array
     */
    public static function prepareConfig (array $additionalConfig)
    {
        return array_merge([
            'dataType' => __('Comment'),
            'icon' => 'message-circle',
            'routes' => RouteHelper::prepareRouteConfigArray('admin.comments'),
            'identifier' => 'id',
            'hideButtons' => 'new'
        ], $additionalConfig);
    }

    public static function getValidationRules ()
    {
        return [
            'content' => 'required|string|min:1',
            'feuser_id' => 'required|integer|exists:sys_feusers,id',
            'product_id' => 'required|integer|exists:sys_product,id'
        ];
    }
}
