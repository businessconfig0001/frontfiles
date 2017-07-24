<?php

namespace FrontFiles\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use FrontFiles\User;

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
            'clientId'       => 'string|max:175',
            'clientSecret'   => 'string|max:175',
            'refreshToken'   => 'string|max:175',
            'folderId'       => 'string|max:175',
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
            'google_clientId'       => request('clientId'),
            'google_clientSecret'   => request('clientSecret'),
            'google_refreshToken'   => request('refreshToken'),
            'google_folderId'       => request('folderId'),
        ]);

        if(request()->expectsJson())
            return response(['status' => 'Profile successfully edited!'], 200);

        return redirect(route('profile'));
    }
}
