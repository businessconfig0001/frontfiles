<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateAccountRequest extends Request {

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
            'name' => 'required|min:2|max:50',
            'email' => 'required|email|max:50|unique:accounts,email',
            'password' => 'required|confirmed|min:6|max:100',
            'account_type_id' => 'required',

        ];
    }

}
