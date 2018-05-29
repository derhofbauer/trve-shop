<?php

namespace App\Http\Controllers\Frontend;

use App\SysProduct;
use App\SysRating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class SysCommentController
 *
 * @package App\Http\Controllers\Frontend
 */
class SysCommentController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct ()
    {
        $this->middleware('auth:web');
    }

    /**
     * @param Request $request
     * @param string  $id
     */
    public function create (Request $request, $id)
    {
        $product = SysProduct::find($id);

        // dd($request->toArray());

        $validatedData = $request->validate([
            'rating' => 'integer|between:0,5',
            'comment' => 'nullable|string'
        ]);

        if ($validatedData['rating'] > 0) {
            $product->ratings()->create([
                'feuser_id' => Auth::user()->id,
                'rating' => $validatedData['rating']
            ]);
        }

        if (strlen($validatedData['comment']) > 0) {
            $product->comments()->create([
                'feuser_id' => Auth::user()->id,
                'content' => $validatedData['comment']
            ]);
        }

        return redirect()->route('products.show', ['id' => $id]);
    }
}
