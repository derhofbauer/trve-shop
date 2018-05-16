<?php

namespace App\Http\Controllers;

use App\SysBlogEntry;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * BlogController constructor.
     *
     * @return void
     */
    public function __construct ()
    {
        // inject middleware
    }

    public function index ()
    {
        $blogEntries = SysBlogEntry::all();

        return view('frontend/blog', ['entries' => $blogEntries]);
    }

    public function show ($id)
    {
        $blogEntry = SysBlogEntry::find($id);
        return view('frontend/blog-single', [
            'entry' => $blogEntry,
            'slug' => str_slug($blogEntry->title)
        ]);
    }
}
