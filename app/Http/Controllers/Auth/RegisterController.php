<?php

namespace FrontFiles\Http\Controllers\Auth;

use FrontFiles\User;
use FrontFiles\Utility\Helper;
use Illuminate\Support\Facades\Validator;
use FrontFiles\Http\Controllers\Controller;
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email'         => 'required|string|email|max:100|unique:users',
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'avatar'        => 'nullable|image:jpeg,jpg,png|max:1048576',
            'bio'           => 'nullable|string|max:500',
            'location'      => 'required|string|max:100',
            'type'          => 'required|in:user,corporative',
            'password'      => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \FrontFiles\User
     */
    protected function create(array $data)
    {
        if(request()->file('avatar'))
        {
            $rawImg         = request()->file('avatar');
            $extension      = (string)$rawImg->clientExtension();
            $short_id       = Helper::generateRandomAlphaNumericString(12);
            $avatar_name    = $short_id . '.' . $extension;
            $avatarUrl      = Helper::storeUserAvatarAndReturnUrl($avatar_name);
        }

        return User::create([
            'email'         => $data['email'],
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'avatar'        => $avatarUrl ?? 'http://via.placeholder.com/450x450',
            'avatar_name'   => $avatar_name ?? null,
            'bio'           => $data['bio'] ?? 'I am new here!',
            'location'      => $data['location'],
            'password'      => $data['password'],
        ])->assignRole($data['type']);
    }
}
