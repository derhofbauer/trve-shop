<?php

namespace App\Http\Controllers\Frontend;

use App\SysBlogEntry;
use Illuminate\Http\Request;

/**
 * Class BlogController
 *
 * @package App\Http\Controllers\Frontend
 */
class BlogController extends \App\Http\Controllers\Controller
{
    /**
     * SysBlogEntryController constructor.
     */
    public function __construct ()
    {
        // inject middleware
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index ()
    {
        $blogEntries = SysBlogEntry::all();

        return view('frontend/blog', ['entries' => $blogEntries]);
    }

    /**
     * @param string|int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show ($id)
    {
        $blogEntry = SysBlogEntry::find($id);
        return view('frontend/blog-single', [
            'entry' => $blogEntry,
            'slug' => str_slug($blogEntry->title)
        ]);
    }
}
