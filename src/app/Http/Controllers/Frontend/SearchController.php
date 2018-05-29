<?php

namespace App\Http\Controllers\Frontend;

use App\SysBlogEntry;
use App\SysProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class SearchController
 *
 * @package App\Http\Controllers\Frontend
 */
class SearchController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search (Request $request)
    {
        if ($request->has('searchterm')) {
            $validatedData = $request->validate([
                'searchterm' => 'string'
            ]);
            $searchterm = $validatedData['searchterm'];
        }

        if (!empty($searchterm)) {
            $products = SysProduct::search($searchterm);
            $blogEntries = SysBlogEntry::search($searchterm);
        } else {
            $products = SysProduct::all();
            $blogEntries = SysBlogEntry::all();
        }

        return view('frontend.search', [
            'products' => $products,
            'blogEntries' => $blogEntries
        ]);
    }
}
