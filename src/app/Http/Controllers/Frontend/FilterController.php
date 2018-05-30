<?php

namespace App\Http\Controllers\Frontend;

use App\SysProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * Class FilterController
 *
 * @package App\Http\Controllers\Frontend
 */
class FilterController extends Controller
{
    public function filter (Request $request)
    {
        $validatedData = $request->validate([
            'searchterm' => 'nullable|string',
            'categories' => 'array|nullable',
            'price_max' => 'nullable|integer',
        ]);
        $searchterm = $validatedData['searchterm'];

        $products = SysProduct::query();

        if ($request->has('searchterm') && !empty($validatedData['searchterm'])) {
            $products = $products->where('name', 'like', "%$searchterm%")
                ->orWhere('description', 'like', "%$searchterm%");
        }
        if ($request->has('price_max') && $validatedData['price_max'] > 0) {
            $products = $products->whereBetween('price', [0, (int)$validatedData['price_max']]);
        }
        if ($request->has('categories') && is_array($validatedData['categories'])) {
            $subquery = DB::table('sys_product_category_mm')->select('product_id')->whereIn('category_id', array_keys($validatedData['categories']));
            $products = $products->whereIn('id', $subquery);
        }
        $products = $products->get();

        $return = [];

        foreach ($products as $product) {
            if ($product->children()->count() > 0) {
                foreach ($product->children as $child) {
                    $return[] = $child;
                }
            } else {
                $return[] = $product;
            }
        }

        return view('frontend.product', array_merge([
            'data' => $return
        ], $validatedData));
    }
}
