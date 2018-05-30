<?php

namespace App\Http\Controllers\Auth;

use App\SysAddress;
use App\SysFeuser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct ()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator (array $data)
    {
        return Validator::make($data, [
            'title' => 'string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:sys_feusers,email',
            'password' => 'required|string|min:6|confirmed',
            'country' => 'required|string|min:1',
            'city' => 'required|string|min:1',
            'zip' => 'required|string|min:1',
            'street' => 'required|string|min:1',
            'street_number' => 'required|string|min:1',
            'address_line_2' => 'string|nullable',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return \App\SysFeuser
     */
    protected function create (array $data)
    {
        $user = SysFeuser::create([
            'title' => $data['title'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->addresses()->create([
            'country' => $data['country'],
            'city' => $data['city'],
            'zip' => $data['zip'],
            'street' => $data['street'],
            'street_number' => $data['street_number'],
            'address_line_2' => $data['address_line_2']
        ]);

        return $user;
    }
}
