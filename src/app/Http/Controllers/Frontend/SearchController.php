<?php

namespace App\Http\Controllers\Frontend;

use App\SysBlogEntry;
use App\SysProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request) {
        $validatedData = $request->validate([
           'searchterm' => 'string'
        ]);
        $searchterm = $validatedData['searchterm'];
        if (!empty($searchterm)) {
            // TODO: perform search here
            $products = SysProduct::all();

            $blogEntries = SysBlogEntry::all();

            return view('frontend.search', [
                'products' => $products,
                'blogEntries' => $blogEntries
            ]);
        }
        return view('frontend.search');
    }
}
