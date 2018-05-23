<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

/**
 * Class AdminController
 *
 * @package App\Http\Controllers\Backend
 */
class AdminController extends \App\Http\Controllers\Controller
{
    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('backend/admin');
    }
}
