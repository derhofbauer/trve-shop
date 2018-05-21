<?php

namespace App\Http\Controllers\Backend;

use App\SysBeuser;
use App\SysBlogEntry;
use App\SysRole;
use Illuminate\Http\Request;

class SysBlogEntryController extends \App\Http\Controllers\Controller
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

    public function index ()
    {
        $blogEntries = SysBlogEntry::all('id', 'title', 'created_at');

        return view('backend/list', self::prepareConfig([
            'thead' => [
                __('ID'),
                __('Title'),
                __('Created at')
            ],
            'data' => $blogEntries
        ]));
    }

    public function show ($id)
    {
        $blogEntry = SysBlogEntry::find($id);
        $users = SysBeuser::all('username As name', 'id');
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

    public function createView ()
    {
        $beUsers = SysBeuser::all('username', 'id');
        return view('backend/create');
    }

    public static function prepareConfig ($additionalConfig)
    {
        return array_merge([
            'dataType' => __('Blog Entry'),
            'icon' => 'book',
            'routes' => [
                'create' => 'admin.blog.create',
                'create-submit' => 'admin.blog.create.submit',
                'edit' => 'admin.blog.edit',
                'edit-submit' => 'admin.blog.edit.submit',
                'delete' => 'admin.blog.delete',
                'base' => 'admin.blog'
            ],
            'identifier' => 'title'
        ], $additionalConfig);
    }
}
