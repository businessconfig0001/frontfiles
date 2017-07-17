<?php

namespace FrontFiles\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use FrontFiles\File;

class UpdateFileRequest extends FormRequest
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
            'title'         => 'required|string|max:175',
            'description'   => 'required|string',
            'what'          => 'required|string|max:175',
            'where'         => 'required|string|max:175',
            'when'          => 'required|date',
            'who'           => 'required|string|max:175',
        ];
    }

    /**
     * Updates the file.
     *
     * @param File $file
     * @return mixed
     */
    public function persist(File $file)
    {
        $file->update([
            'title' => request('title'),
            'description' => request('description'),
            'what' => request('what'),
            'where' => request('where'),
            'when' => request('when'),
            'who' => request('who'),
        ]);

        if(request()->expectsJson())
            return response(['status' => 'File successfully edited!']);

        return redirect('/files');
    }
}
