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
            'clientId'       => 'nullable|string|max:175',
            'clientSecret'   => 'nullable|string|max:175',
            'refreshToken'   => 'nullable|string|max:175',
            'folderId'       => 'nullable|string|max:175',
            'token'          => 'nullable|string|max:175',
            'app_name'       => 'nullable|string|max:175',
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
        if(request('clientId') && request('clientSecret') && request('refreshToken') && request('folderId'))
            $user->update([
                'google_clientId'       => request('clientId'),
                'google_clientSecret'   => request('clientSecret'),
                'google_refreshToken'   => request('refreshToken'),
                'google_folderId'       => request('folderId'),
            ]);

        if(request('token') && request('app_name'))
            $user->update([
                'dropbox_token'         => request('token'),
                'dropbox_app_name'      => request('app_name'),
            ]);

        if(request()->expectsJson())
            return response(['status' => 'Profile successfully edited!'], 200);

        return redirect(route('profile'));
    }
}
