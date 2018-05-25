<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RouteHelper;
use App\SysBeuser;
use App\SysBlogEntry;
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
        return view('backend/edit', self::prepareConfig([
            'object' => $blogEntry,
            'tabs' => [
                [
                    'title' => __('General'),
                    'fields' => [
                        ['label' => __('Title'), 'type' => 'text', 'id' => 'title', 'placeholder' => __('Title placeholder'), 'required' => true, 'value' => $blogEntry->title],
                        ['label' => __('Author'), 'type' => 'select', 'id' => 'beuser_id', 'required' => true, 'data' => $users, 'value' => $blogEntry->beuser_id],
                        ['label' => __('Abstract'), 'type' => 'textarea', 'id' => 'abstract', 'placeholder' => __('Abstract placeholder'), 'required' => true, 'value' => $blogEntry->abstract],
                        ['label' => __('Content'), 'type' => 'editor', 'id' => 'content', 'placeholder' => __('Content Placeholder'), 'value' => $blogEntry->content]
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
        $entry->save();

        return redirect()->route('admin.blog');
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
                        ['label' => __('Content'), 'type' => 'editor', 'id' => 'content', 'placeholder' => __('Content Placeholder')]
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
        $entry->save();

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
}
