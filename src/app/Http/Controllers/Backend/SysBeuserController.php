<?php

namespace App\Http\Controllers\Backend;

use App\SysBeuser;
use App\SysRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SysBeuserController extends \App\Http\Controllers\Controller implements BackendControllerInterface
{
    public function __construct ()
    {
        $this->middleware('auth:admin');
    }

    public function index ()
    {
        $users = SysBeuser::all(['id', 'username', 'email'])->sortBy('username');
        return view('backend/list', self::prepareConfig([
            'thead' => [
                __('ID'),
                __('Username'),
                __('Email')
            ],
            'data' => $users
        ]));
    }

    public function show ($id)
    {
        $user = SysBeuser::find($id);
        $roles = SysRole::all('name', 'id');
        return view('backend/edit', self::prepareConfig([
            'object' => $user,
            'tabs' => [
                [
                    'title' => __('General'),
                    'fields' => [
                        ['label' => __('Username'), 'type' => 'text', 'id' => 'username', 'placeholder' => __('Username placeholder'), 'required' => true, 'value' => $user->username],
                        ['label' => __('Password'), 'type' => 'password', 'id' => 'password', 'placeholder' => __('Reset password')],
                        ['label' => __('Email'), 'type' => 'email', 'id' => 'email', 'placeholder' => __('Email placeholder'), 'required' => true, 'value' => $user->email],
                        ['label' => __('Role'), 'type' => 'select', 'id' => 'role_id', 'required' => true, 'data' => $roles, 'value' => $user->role_id]
                    ]
                ]
            ]
        ]));
    }

    public function update (Request $request, $id)
    {
        $user = SysBeuser::find($id);
        $validationRules = self::getValidationRules();

        if ($user->username == $request->input('username')) {
            unset($validationRules['username']);
        }
        if ($user->email == $request->input('email')) {
            unset($validationRules['email']);
        }
        if (empty($request->input('password'))) {
            unset($validationRules['password']);
        }
        $validatedData = $request->validate($validationRules);

        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->role_id = $request->input('role_id');

        if ($request->input('password') != '') {
            $user->setPassword($request->input('password'));
        }

        $user->save();

        return redirect()->route('admin.users.backend');
    }

    public function createView ()
    {
        $roles = SysRole::all('name', 'id');
        return view('backend/create', self::prepareConfig([
            'tabs' => [
                [
                    'title' => __('General'),
                    'fields' => [
                        ['label' => __('Username'), 'type' => 'text', 'id' => 'username', 'placeholder' => __('Username placeholder'), 'required' => true],
                        ['label' => __('Email'), 'type' => 'email', 'id' => 'email', 'placeholder' => __('Email placeholder'), 'required' => true],
                        ['label' => __('Password'), 'type' => 'password', 'id' => 'password', 'placeholder' => __('Password placeholder'), 'required' => true],
                        ['label' => __('Password repeat'), 'type' => 'password', 'id' => 'password_repeat', 'placeholder' => __('Password repeat'), 'required' => true],
                        ['label' => __('Role'), 'type' => 'select', 'id' => 'role_id', 'required' => true, 'data' => $roles]
                    ]
                ]
            ]
        ]));
    }

    public function create (Request $request)
    {
        $validatedData = $request->validate(self::getValidationRules());

        $user = new SysBeuser($validatedData);
        $user->setPassword($validatedData['password']);
        $user->save();

        return redirect()->route('admin.users.backend');
    }

    public function delete (Request $request, $id)
    {
        if (Auth::user()->id != $id) {
            $user = SysBeuser::find($id);
            $user->delete();
        } else {
            // @todo implement error messages
            Session::flash('status', 'You cannot delete your current user.');
            Session::flash('status-class', 'alert-error');
        }
        return redirect()->route('admin.users.backend');
    }

    public static function getValidationRules ()
    {
        return [
            'username' => 'required|string|min:4|max:16|unique:sys_beusers',
            'email' => 'required|email|unique:sys_beusers',
            'password' => 'sometimes|required|string|min:8|max:32',
            'password_repeat' => 'sometimes|required|same:password',
            'role_id' => 'required|numeric|exists:sys_role,id'
        ];
    }

    public static function prepareConfig ($additionalConfig)
    {
        return array_merge([
            'dataType' => __('Backend User'),
            'icon' => 'user',
            'routes' => [
                'create' => 'admin.users.backend.create',
                'create-submit' => 'admin.users.backend.create.submit',
                'edit' => 'admin.users.backend.edit',
                'edit-submit' => 'admin.users.backend.edit.submit',
                'delete' => 'admin.users.backend.delete',
                'base' => 'admin.users.backend'
            ],
            'identifier' => 'username'
        ], $additionalConfig);
    }
}
