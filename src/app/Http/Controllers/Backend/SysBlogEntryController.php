<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RouteHelper;
use App\SysBeuser;
use App\SysBlogEntry;
use App\SysProduct;
use Illuminate\Http\Request;

/**
 * Class SysBlogEntryController
 *
 * @package App\Http\Controllers\Backend
 */
class SysBlogEntryController extends Controller implements BackendControllerInterface
{
    /**
     * SysBlogEntryController constructor.
     *
     * @return void
     */
    public function __construct ()
    {
        $this->middleware('auth:admin');

        $this->storage_path = 'public/blog_pictures';
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index ()
    {
        $blogEntries = SysBlogEntry::all('id', 'title', 'created_at', 'beuser_id')->sortBy('created_at');

        return view('backend/list', self::prepareConfig([
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
            'relatedData' => [
                'author' => 'username'
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
        $blogEntry = SysBlogEntry::find($id);
        $users = SysBeuser::all('username AS name', 'id');
        $products = SysProduct::all('name', 'id');
        $selected_products = [];
        foreach ($blogEntry->products as $product) {
            $selected_products[] = $product->id;
        }
        return view('backend/edit', self::prepareConfig([
            'object' => $blogEntry,
            'tabs' => [
                [
                    'title' => __('General'),
                    'fields' => [
                        ['label' => __('Title'), 'type' => 'text', 'id' => 'title', 'placeholder' => __('Title placeholder'), 'required' => true, 'value' => $blogEntry->title],
                        ['label' => __('Author'), 'type' => 'select', 'id' => 'beuser_id', 'required' => true, 'data' => $users, 'value' => $blogEntry->beuser_id],
                        ['label' => __('Abstract'), 'type' => 'textarea', 'id' => 'abstract', 'placeholder' => __('Abstract placeholder'), 'required' => true, 'value' => $blogEntry->abstract],
                        ['label' => __('Content'), 'type' => 'editor', 'id' => 'content', 'placeholder' => __('Content Placeholder'), 'value' => $blogEntry->content],
                        ['label' => __('Media'), 'type' => 'media', 'id' => 'media', 'placeholder' => __('Media placeholder'), 'required' => false, 'value' => (array)$blogEntry->media],
                        ['label' => __('Add Media'), 'type' => 'file', 'id' => 'media[]', 'required' => false, 'placeholder' => __('Media placeholder'), 'multiple' => true],
                        ['label' => __('Products'), 'type' => 'select_multiple', 'id' => 'products', 'required' => false, 'data' => $products, 'value' => $selected_products],
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

        $entry = SysBlogEntry::find($id);

        $entry->fill($validatedData);
        self::handleMedia($entry, $request, $this->storage_path);
        self::handleDeleteMedia($entry, $request);
        self::handleProducts($entry, $request);
        $entry->save();

        $request->session()->flash('status', __('Blog entry saved successfully.'));
        $request->session()->flash('status-class', 'alert-success');

        return redirect()->route('admin.blog.edit', ['id' => $id]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createView ()
    {
        $users = SysBeuser::all('username AS name', 'id');
        return view('backend/create', self::prepareConfig([
            'tabs' => [
                [
                    'title' => __('General'),
                    'fields' => [
                        ['label' => __('Title'), 'type' => 'text', 'id' => 'title', 'placeholder' => __('Title placeholder'), 'required' => true],
                        ['label' => __('Author'), 'type' => 'select', 'id' => 'beuser_id', 'required' => true, 'data' => $users],
                        ['label' => __('Abstract'), 'type' => 'textarea', 'id' => 'abstract', 'placeholder' => __('Abstract placeholder'), 'required' => true],
                        ['label' => __('Content'), 'type' => 'editor', 'id' => 'content', 'placeholder' => __('Content Placeholder')],
                        ['label' => __('Add Media'), 'type' => 'file', 'id' => 'media[]', 'required' => false, 'placeholder' => __('Media placeholder'), 'multiple' => true],
                        ['label' => __('Products'), 'type' => 'select_multiple', 'id' => 'products', 'required' => false, 'data' => $products],
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

        $entry = new SysBlogEntry($validatedData);
        self::handleMedia($entry, $request);
        self::handleDeleteMedia($entry, $request);
        self::handleProducts($entry, $request);
        $entry->save();

        $request->session()->flash('status', __('Blog entry created successfully.'));
        $request->session()->flash('status-class', 'alert-success');

        return redirect()->route('admin.blog');
    }

    /**
     * @param Request    $request
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete (Request $request, $id)
    {
        $entry = SysBlogEntry::find($id);
        $entry->delete();

        $request->session()->flash('status', __('Blog entry deleted successfully.'));
        $request->session()->flash('status-class', 'alert-success');

        return redirect()->route('admin.blog');
    }

    /**
     * @param array $additionalConfig
     *
     * @return array
     */
    public static function prepareConfig (array $additionalConfig)
    {
        return array_merge([
            'dataType' => __('Blog Entry'),
            'icon' => 'book',
            'routes' => RouteHelper::prepareRouteConfigArray('admin.blog'),
            'identifier' => 'title'
        ], $additionalConfig);
    }

    /**
     * @return array
     */
    public static function getValidationRules ()
    {
        return [
            'title' => 'required|string|min:1',
            'abstract' => 'required|string|min:1',
            'content' => 'required|string|min:1',
            'beuser_id' => 'required|integer|exists:sys_beusers,id'
        ];
    }

    /**
     * @param SysProduct $entry
     * @param Request    $request
     * @param string     $storagePath
     */
    public static function handleMedia (&$entry, $request, $storagePath)
    {
        if ($request->has('media')) {
            foreach ($request->file('media') as $uploaded_file) {
                $entry->addMedia($uploaded_file->store($storagePath));
            }
        }
    }

    /**
     * @param SysProduct $entry
     * @param Request    $request
     */
    public static function handleDeleteMedia (&$entry, $request)
    {
        if ($request->has('delete_media')) {
            foreach ($request->input('delete_media') as $path => $on) {
                $entry->removeMedia($path);
            }
        }
    }

    /**
     * @param SysBlogEntry $entry
     * @param Request      $request
     */
    public static function handleProducts (&$entry, Request $request)
    {
        if ($request->has('products')) {
            foreach ($request->input('products') as $product => $on) {
                $entry->addProduct(SysProduct::find($product));
            }
            foreach ($entry->products as $product) {
                if (!in_array($product->id, array_keys($request->input('products')))) {
                    $entry->products()->detach($product);
                }
            }
        } else {
            $entry->products()->detach($entry->products);
        }
    }
}
