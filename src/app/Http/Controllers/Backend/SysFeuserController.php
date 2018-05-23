<?php

namespace App\Http\Controllers\Backend;

use App\Http\Helpers\RouteHelper;
use App\SysFeuser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class SysFeuserController
 *
 * @package App\Http\Controllers\Backend
 */
class SysFeuserController extends Controller implements BackendControllerInterface
{
    /**
     * SysFeuserController constructor.
     */
    public function __construct ()
    {
        $this->middleware('auth:admin');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index ()
    {
        $users = SysFeuser::all(['id', 'email', 'firstname', 'lastname'])->sortBy('created_at');
        return view('backend/list', self::prepareConfig([
            'thead' => [
                __('ID'),
                __('Email'),
                __('First Name'),
                __('Last Name')
            ],
            'data' => $users
        ]));
    }

    /**
     * @param int|string $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show ($id)
    {
        $user = SysFeuser::find($id);

        return view('backend/edit', self::prepareConfig([
            'object' => $user,
            'tabs' => [
                [
                    'title' => __('General'),
                    'fields' => [
                        ['label' => __('Email'), 'type' => 'email', 'id' => 'email', 'placeholder' => __('Email placeholder'), 'required' => true, 'value' => $user->email],
                        ['label' => __('First name'), 'type' => 'text', 'id' => 'firstname', 'placeholder' => __('Firstname'), 'required' => true, 'value' => $user->firstname],
                        ['label' => __('Last name'), 'type' => 'text', 'id' => 'lastname', 'placeholder' => __('Lastname'), 'required' => true, 'value' => $user->lastname],
                        ['label' => __('Title'), 'type' => 'text', 'id' => 'title', 'placeholder' => __('Academic title'), 'value' => $user->title]
                    ]
                ]
            ]
        ]));
    }

    /**
     * @param Request    $request
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update (Request $request, $id)
    {
        $user = SysFeuser::find($id);
        $validationRules = self::getValidationRules();

        if ($user->email == $request->input('email')) {
            unset($validationRules['email']);
        }
        $validatedData = $request->validate($validationRules);

        $user->email = $request->input('email');
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->title = $request->input('title');

        $user->save();

        return redirect()->route('admin.users.frontend');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createView ()
    {
        return view('backend/create', self::prepareConfig([
            'tabs' => [
                [
                    'title' => __('General'),
                    'fields' => [
                        ['label' => __('Email'), 'type' => 'email', 'id' => 'email', 'placeholder' => __('Email placeholder'), 'required' => true],
                        ['label' => __('Password'), 'type' => 'password', 'id' => 'password', 'placeholder' => __('Password placeholder'), 'required' => true],
                        ['label' => __('Password repeat'), 'type' => 'password', 'id' => 'password_repeat', 'placeholder' => __('Password repeat'), 'required' => true],
                        ['label' => __('First name'), 'type' => 'text', 'id' => 'firstname', 'placeholder' => __('Firstname'), 'required' => true],
                        ['label' => __('Last name'), 'type' => 'text', 'id' => 'lastname', 'placeholder' => __('Lastname'), 'required' => true],
                        ['label' => __('Title'), 'type' => 'text', 'id' => 'title', 'placeholder' => __('Academic title')]
                    ]
                ]
            ]
        ]));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create (Request $request)
    {
        $validatedData = $request->validate(self::getValidationRules());

        $user = new SysFeuser($validatedData);
        $user->setPassword($validatedData['password']);
        $user->save();

        return redirect()->route('admin.users.frontend');
    }

    /**
     * @param Request    $request
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete (Request $request, $id)
    {
        $user = SysFeuser::find($id);
        $user->delete();

        return redirect()->route('admin.users.frontend');
    }

    /**
     * @return array
     */
    public static function getValidationRules ()
    {
        return [
            'email' => 'required|email|unique:sys_feusers',
            'password' => 'sometimes|required|string|min:8|max:32',
            'password_repeat' => 'sometimes|required|same:password',
            'firstname' => 'required|string|min:1',
            'lastname' => 'required|string|min:1'
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
            'icon' => 'user',
            'routes' => RouteHelper::prepareRouteConfigArray('admin.users.frontend'),
            'identifier' => 'email'
        ], $additionalConfig);
    }
}
