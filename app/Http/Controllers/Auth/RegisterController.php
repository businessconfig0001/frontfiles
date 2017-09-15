<?php

namespace FrontFiles\Http\Controllers\Auth;

use FrontFiles\User;
use FrontFiles\Utility\Helper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use FrontFiles\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Intervention\Image\Facades\Image;

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
    protected $redirectTo = '/profile';

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
            'role'          => 'required|in:user,corporative',
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
            $crop           = json_decode($data['crop'], true);
            $rawImg         = request()->file('avatar');
            $short_id       = Helper::generateRandomAlphaNumericString(12);
            $avatar_name    = $short_id . '.' . (string)$rawImg->clientExtension();

            $img = Image::make($rawImg)
                ->crop($crop['width'], $crop['height'], $crop['x'], $crop['y'])
                ->resize(null, 160, function ($constraint){
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->stream();

            $avatarUrl = Helper::storeUserAvatarAndReturnUrl($avatar_name, $img->__toString());
        }

        return User::create([
            'email'         => $data['email'],
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'avatar'        => $avatarUrl ?? 'http://via.placeholder.com/300x300',
            'avatar_name'   => $avatar_name ?? null,
            'bio'           => $data['bio'] ?? 'I am new here!',
            'location'      => $data['location'],
            'password'      => $data['password'],
        ])->assignRole($data['role']);
    }
}
