<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Helpers\RouteHelper;
use App\SysFeuser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index ()
    {
        $user = Auth::user();

        return view('frontend.profile', self::prepareConfig([
            'user' => $user
        ]));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update (Request $request)
    {
        $user = Auth::user();

        $validationRules = self::getValidationRules();

        if ($user->email == $request->input('email')) {
            unset($validationRules['email']);
        }
        if (empty($request->input('password'))) {
            unset($validationRules['password']);
        }

        $validatedData = $request->validate($validationRules);

        if ($user->email != $request->input('email')) {
            $user->email = $validatedData['email'];
        }
        if (!empty($request->input('password'))) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->firstname = $validatedData['firstname'];
        $user->lastname= $validatedData['lastname'];
        $user->title = $validatedData['title'];
        $user->save();

        $request->session()->flash('status', __('Profile updated successfully.'));
        $request->session()->flash('status-class', 'alert-success');


        return redirect()->route('profile');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orders ()
    {
        $orders = Auth::user()->orders;

        return view('frontend.profile-orders', [
            'orders' => $orders
        ]);
    }

    /**
     * @return array
     */
    public static function getValidationRules ()
    {
        return [
            'email' => 'required|email|unique:sys_feusers,email',
            'password' => 'sometimes|string|min:8|max:32',
            'password_repeat' => 'sometimes|same:password',
            'firstname' => 'string|min:1',
            'lastname' => 'string|min:1',
            'title' => 'string'
        ];
    }

    /**
     * @param array $additionalConfig
     *
     * @return array
     */
    public static function prepareConfig (array $additionalConfig)
    {
        return array_merge([
            'dataType' => __('Frontend User'),
            'routes' => [
                'edit-submit' => "profile.update",
                'base' => 'profile',
            ],
            'identifier' => 'email'
        ], $additionalConfig);
    }
}
