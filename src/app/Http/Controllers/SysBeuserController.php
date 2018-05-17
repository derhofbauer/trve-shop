<?php

namespace App\Http\Controllers;

use App\SysBeuser;
use App\SysRole;
use Illuminate\Http\Request;

class SysBeuserController extends Controller
{
    public function __construct ()
    {
        $this->middleware('auth:admin');
    }

    public function index ()
    {
        $users = \App\SysBeuser::all();
        return view('backend/users-be', ['users' => $users]);
    }

    public function show ($id)
    {
        $user = SysBeuser::find($id);
        $roles = SysRole::all();
        return view('backend/users-be-single', [
            'user' => $user,
            'roles' => $roles
        ]);
    }
    }
}
