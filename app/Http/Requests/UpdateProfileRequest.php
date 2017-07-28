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
            'token' => 'nullable|string|max:64',
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
        if(request('token'))
            $user->update(['dropbox_token' => request('token')]);

        if(request()->expectsJson())
            return response(['status' => 'Profile successfully edited!'], 200);

        return redirect(route('profile'));
    }
}
