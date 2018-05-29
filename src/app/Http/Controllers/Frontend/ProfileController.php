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


    public function index ()
    {
        $user = Auth::user();

        return view('frontend.profile', self::prepareConfig([
            'object' => $user,
            'tabs' => [
                [
                    'title' => __('General'),
                    'fields' => [
                        ['label' => __('Email'), 'type' => 'email', 'id' => 'email', 'placeholder' => __('Email placeholder'), 'required' => true, 'value' => $user->email],
                        ['label' => __('Password'), 'type' => 'password', 'id' => 'password', 'placeholder' => __('Reset password')],
                        ['label' => __('Password'), 'type' => 'password', 'id' => 'password', 'placeholder' => __('Password placeholder')],
                        ['label' => __('First name'), 'type' => 'text', 'id' => 'firstname', 'placeholder' => __('Firstname'), 'required' => true, 'value' => $user->firstname],
                        ['label' => __('Last name'), 'type' => 'text', 'id' => 'lastname', 'placeholder' => __('Lastname'), 'required' => true, 'value' => $user->lastname],
                        ['label' => __('Title'), 'type' => 'text', 'id' => 'title', 'placeholder' => __('Academic title'), 'value' => $user->title]
                    ]
                ]
            ]
        ]));
    }

    /**
     * @param Request $request
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
            'password' => 'sometimes|required|string|min:8|max:32',
            'password_repeat' => 'sometimes|required|same:password',
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
