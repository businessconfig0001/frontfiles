<?php

namespace FrontFiles\Http\Requests;

use FrontFiles\User;
use FrontFiles\Utility\Helper;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'avatar'        => 'nullable|image:jpeg,jpg,png|max:1048576',
            'bio'           => 'nullable|string|max:500',
            'location'      => 'required|string|max:100',
            'role'          => 'required|in:user,corporative',
        ];
    }

    /**
     * Updates the user.
     *
     * @param User $user
     * @return mixed
     */
    public function persist(User $user)
    {
        $user->update([
            'first_name'    => request('first_name'),
            'last_name'     => request('last_name'),
            'bio'           => request('bio') ?? 'I am new here!',
            'location'      => request('location'),
        ]);

        if(request()->file('avatar'))
        {
            if($user->avatar_name)
                Helper::deleteUserAvatar($user->avatar_name);

            $rawImg         = request()->file('avatar');
            $extension      = (string)$rawImg->clientExtension();
            $short_id       = Helper::generateRandomAlphaNumericString(12);
            $avatar_name    = $short_id . '.' . $extension;
            $avatarUrl      = Helper::storeUserAvatarAndReturnUrl($avatar_name);

            $user->update([
                'avatar'        => $avatarUrl ?? 'http://via.placeholder.com/300x300',
                'avatar_name'   => $avatar_name ?? null,
            ]);
        }

        $user->syncRoles([request('role')]);

        $user->generateSlug();

        $user->save();

        if(request()->expectsJson())
            return response(['status' => 'Profile successfully edited!'], 200);

        return redirect(route('profile'))
            ->with('message', 'Profile successfully edited!');
    }
}
