<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProfileController
 *
 * @package App\Http\Controllers\Frontend
 */
class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct ()
    {
        $this->middleware('auth:web');
    }


    public function index ()
    {
        $user = Auth::user();
        return view('frontend.profile', [
            'user' => $user,
            'orders' => $user->orders
        ]);
    }

    public function update ()
    {

    }
}
