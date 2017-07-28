<?php

namespace FrontFiles\Http\Requests;

use FrontFiles\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateUserDropboxToken extends FormRequest
{
    /**
     * Redirect route when errors occur.
     *
     * @var string
     */
    protected $redirectRoute = 'profile';

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
            'code'  => 'required|string|size:43',
            'state' => 'required|string|size:32',
        ];
    }

    /**
     * Updates the user.
     *
     * @param User $user
     * @param $authHelper
     * @return mixed
     */
    public function persist(User $user, $authHelper)
    {
        //Fetch the AccessToken
        //$accessToken = $authHelper->getAccessToken(
        //    request('code'),
        //    request('state'),
        //    route('profile.dropbox.auth')
        //);

        //$user->update(['dropbox_token' => $accessToken->getToken()]);

        if(request()->expectsJson())
            return response(['status' => 'Dropbox successfully configured!'], 200);

        return redirect(route('profile'));
    }
}
