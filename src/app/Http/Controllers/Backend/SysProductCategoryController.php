<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RouteHelper;
use App\SysProductCategory;
use Illuminate\Http\Request;

/**
 * Class SysProductCategoryController
 *
 * @package App\Http\Controllers\Backend
 */
class SysProductCategoryController extends Controller implements BackendControllerInterface
{
    /**
     * SysProductCategoryController constructor.
     */
    public function __construct ()
    {
        $this->middleware('auth:admin');

        $this->storage_path = 'public/category_pictures';
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index ()
    {
        $categories = SysProductCategory::all('id', 'name', 'description')->sortBy('name');
        return view('backend/list', self::prepareConfig([
            'thead' => [
                __('ID'),
                __('Name'),
                __('Description')
            ],
            'data' => $categories
        ]));
    }

    /**
     * @param int|string $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show ($id)
    {
        $category = SysProductCategory::find($id);

        return view('backend/edit', self::prepareConfig([
            'object' => $category,
            'tabs' => [
                [
                    'title' => __('General'),
                    'fields' => [
                        ['label' => __('Name'), 'type' => 'text', 'id' => 'name', 'placeholder' => __('Name placeholder'), 'required' => true, 'value' => $category->name],
                        ['label' => __('Description'), 'type' => 'textarea', 'id' => 'description', 'placeholder' => __('Description placeholder'), 'required' => false, 'value' => $category->description],
                        ['label' => __('Media'), 'type' => 'media', 'id' => 'media', 'placeholder' => __('Media placeholder'), 'required' => false, 'value' => (array)$category->media],
                        ['label' => __('Add Media'), 'type' => 'file', 'id' => 'media[]', 'required' => false, 'placeholder' => __('Media placeholder'), 'multiple' => true],
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
        $category = SysProductCategory::find($id);

        $validatedData = $request->validate(self::getValidationRules());

        $category->fill($validatedData);
        self::handleMedia($category, $request, $this->storage_path);
        self::handleDeleteMedia($category, $request);

        $category->save();

        $request->session()->flash('status', __('Category updated successfully.'));
        $request->session()->flash('status-class', 'alert-success');

        return redirect()->route('admin.categories.edit', ['id' => $id]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createView ()
    {
        return view('backend/create', self::prepareConfig([
            'tabs' => [
                [
                    'title' => __('General'),
                    'fields' => [
                        ['label' => __('Name'), 'type' => 'text', 'id' => 'name', 'placeholder' => __('Name placeholder'), 'required' => true],
                        ['label' => __('Description'), 'type' => 'textarea', 'id' => 'description', 'placeholder' => __('Description placeholder'), 'required' => false],
                        ['label' => __('Add Media'), 'type' => 'file', 'id' => 'media[]', 'required' => false, 'placeholder' => __('Media placeholder'), 'multiple' => true],
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
        $validatedData = $request->validate(self::getValidationRules());

        $category = new SysProductCategory($validatedData);
        self::handleMedia($category, $request, $this->storage_path);
        $category->save();

        $request->session()->flash('status', __('Category created successfully.'));
        $request->session()->flash('status-class', 'alert-success');

        return redirect()->route('admin.categories.edit', ['id' => $category->id]);
    }

    /**
     * @param Request    $request
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete (Request $request, $id)
    {
        $category = SysProductCategory::find($id);
        $category->delete();

        $request->session()->flash('status', __('Category deleted successfully.'));
        $request->session()->flash('status-class', 'alert-success');

        return redirect()->route('admin.categories');
    }

    /**
     * @return array
     */
    public static function getValidationRules ()
    {
        return [
            'name' => 'required|string|min:1',
            'description' => 'string|nullable'
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
            'dataType' => __('Product Category'),
            'icon' => 'tag',
            'routes' => RouteHelper::prepareRouteConfigArray('admin.categories'),
            'identifier' => 'name'
        ], $additionalConfig);
    }

    /**
     * @param SysProductCategory $category
     * @param Request            $request
     */
    public static function handleDeleteMedia (&$category, $request)
    {
        if ($request->has('delete_media')) {
            foreach ($request->input('delete_media') as $path => $on) {
                $category->removeMedia($path);
            }
        }
    }

    /**
     * @param  SysProductCategory $category
     * @param Request             $request
     * @param string              $storagePath
     */
    public static function handleMedia (&$category, $request, $storagePath)
    {
        if ($request->has('media')) {
            foreach ($request->file('media') as $uploaded_file) {
                $category->addMedia($uploaded_file->store($storagePath));
            }
        }
    }
}
