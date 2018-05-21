<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

class AdminController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index() {
        return view('backend/admin');
    }
}
