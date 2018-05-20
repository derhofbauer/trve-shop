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
        $users = SysBeuser::all(['id', 'username', 'email']);
        return view('backend/users-be', ['users' => $users]);
    }

    public function show ($id)
    {
        $user = SysBeuser::find($id);
        $roles = SysRole::all('name', 'id');
        return view('backend/users-be-edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function update (Request $request, $id)
    {
        $validatedData = $request->validate(self::getValidationRules());

        $user = SysBeuser::find($id);

        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->role_id = $request->input('role_id');

        $user->save();

        return redirect()->route('admin.users.backend');
    }

    public function createView ()
    {
        $roles = SysRole::all('name', 'id');
        return view('backend/users-be-create', [
            'roles' => $roles
        ]);
    }

    public function create (Request $request)
    {
        $validatedData = $request->validate(self::getValidationRules());

        $user = new SysBeuser($validatedData);
        $user->setPassword($validatedData['password']);
        $user->save();

        return redirect()->route('admin.users.backend');
    }

    public function delete ($id)
    {
        $user = SysBeuser::find($id);
        $user->delete();

        return redirect()->route('admin.users.backend');
    }

    public static function getValidationRules ()
    {
        return [
            'username' => 'required|string|min:4|max:16|unique:sys_beusers',
            'email' => 'required|email|unique:sys_beusers',
            'password' => 'sometimes|required|string|min:8|max:32',
            'password_repeat' => 'sometimes|same:password',
            'role_id' => 'required|numeric'
        ];
    }
}
