<?php

namespace App\Http\Controllers\Backend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:admin', [
            'except' => [
                'logout'
            ]
        ]);
    }

    public function showLoginForm() {
        return view('backend/auth/admin-login');
    }

    public function login(Request $request) {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt([
            'username' => $request->username,
            'password' => $request->password
            ])) {
            return redirect()->intended(route('admin'));
        }
        return redirect()->back()->withInput($request->only('username'));
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect()->route('admin');
    }
}
