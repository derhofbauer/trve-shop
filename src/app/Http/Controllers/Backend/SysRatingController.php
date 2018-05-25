<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RouteHelper;
use App\SysComment;
use App\SysFeuser;
use App\SysProduct;
use App\SysRating;
use Illuminate\Http\Request;

/**
 * Class SysRatingController
 *
 * @package App\Http\Controllers\Backend
 */
class SysRatingController extends Controller implements BackendControllerInterface
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
        $ratings = SysRating::all('id', 'rating', 'product_id', 'feuser_id');

        return view('backend/list', self::prepareConfig([
            'thead' => [
                __('ID'),
                __('Rating'),
                __('Product'),
                __('Author')
            ],
            'data' => $ratings,
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

    public function show ($id)
    {
        // TODO: Implement show() method.
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

    /**
     * @param Request    $request
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete (Request $request, $id)
    {
        $rating = SysRating::find($id);
        $rating->delete();

        return redirect()->route('admin.ratings');
    }

    /**
     * @param array $additionalConfig
     *
     * @return array
     */
    public static function prepareConfig (array $additionalConfig)
    {
        return array_merge([
            'dataType' => __('Rating'),
            'icon' => 'star',
            'routes' => RouteHelper::prepareRouteConfigArray('admin.ratings'),
            'identifier' => 'id',
            'hideButtons' => 'new,edit'
        ], $additionalConfig);
    }

    public static function getValidationRules ()
    {
        return [
            'rating' => 'required|integer',
            'feuser_id' => 'required|integer|exists:sys_feusers,id',
            'product_id' => 'required|integer|exists:sys_product,id'
        ];
    }
}
