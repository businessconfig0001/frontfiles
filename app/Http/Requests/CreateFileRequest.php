<?php

namespace FrontFiles\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use FrontFiles\File;

class CreateFileRequest extends FormRequest
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
            'file' => 'required',
            'title' => 'required',
            'description' => 'required',
            'what' => 'required',
            'where' => 'required',
            'when' => 'required',
            'who' => 'required',
        ];
    }

    /**
     * Processes the request and then stores the file.
     *
     * @return mixed
     */
    public function persist()
    {
        //Exit early if the request doesn't have a file
        if(!request()->hasFile('file'))
        {
            if(request()->wantsJson())
                return response()->json(array('error' => 'File is not available'));

            return redirect('/files/upload')->with(array('error'=>'File is not available'));
        }

        //Exit early if the file isn't valid
        if(!request()->file('file')->isValid())
        {
            if(request()->wantsJson())
                return response()->json(array('error' => 'File is not valid'));

            return redirect('/files/upload')->with(array('error'=>'File is not valid'));
        }

        $rawFile = request()->file('file');
        $short_id = File::generateUniqueShortID();
        $extension = $rawFile->getClientOriginalExtension();
        $name = $short_id . '.' . $extension;

        $file = File::create([
            'user_id' => auth()->user()->id,
            'short_id' => $short_id,
            'type' => File::getFileType($rawFile->getClientMimeType()),
            'extension' => $extension,
            'original_name' => $rawFile->getClientOriginalName(),
            'name' => $name,
            'url' => File::storeAndReturnUrl($name),
            'title' => request('title'),
            'description' => request('description'),
            'what' => request('what'),
            'where' => request('where'),
            'who' => request('who'),
            'when' => request('when'),
        ]);

        if(request()->wantsJson())
            return response()->json(array('status' => 'File uploaded successfully!', 'data' => $file));

        return redirect('/files/upload')->with(array('status' => 'File uploaded successfully!'));
    }
}
