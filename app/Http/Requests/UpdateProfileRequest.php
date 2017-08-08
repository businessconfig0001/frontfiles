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
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'bio'           => 'nullable|string|max:500',
            'location'      => 'required|string|max:100',
            'type'          => 'required|in:user,corporative',
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

        $user->syncRoles([request('type')]);

        $user->generateSlug();

        $user->save();

        if(request()->expectsJson())
            return response(['status' => 'Profile successfully edited!'], 200);

        return redirect(route('profile'))
            ->with('message', 'Profile successfully edited!');
    }
}
