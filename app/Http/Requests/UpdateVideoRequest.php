<?php

namespace FrontFiles\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use FrontFiles\Video;

class UpdateVideoRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required'
        ];
    }

    /**
     * Updates the video.
     *
     * @param Video $video
     * @return mixed
     */
    public function persist(Video $video)
    {
        $video->update([
            'title' => request('title'),
            'description' => request('description'),
        ]);

        if(request()->expectsJson())
            return response(['status' => 'Video successfully edited!']);

        return redirect('/video');
    }
}
