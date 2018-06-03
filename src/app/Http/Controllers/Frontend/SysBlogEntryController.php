<?php

namespace App\Http\Controllers\Frontend;

use App\SysBlogEntry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class SysBlogEntryController
 *
 * @package App\Http\Controllers\Frontend
 */
class SysBlogEntryController extends Controller
{
    public function __construct ()
    {
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index ()
    {
        $blogEntries = SysBlogEntry::all();

        return view('frontend.blog', self::prepareConfig([
            'data' => $blogEntries
        ]));
    }

    /**
     * @param integer $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show ($id)
    {
        $blogEntry = SysBlogEntry::find($id);

        return view ('frontend.blog-single', self::prepareConfig([
            'object' => $blogEntry
        ]));
    }

    public function prepareConfig (array $additionalConfig)
    {
        return array_merge([

        ], $additionalConfig);
    }
}
