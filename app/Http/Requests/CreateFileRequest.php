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
            'file'          => 'required|file|allowed_file|has_enough_space',
            'title'         => 'required|string|max:175',
            'description'   => 'required|string',
            'where'         => 'required|string|max:175',
            'when'          => 'required|date',
            'what.*'        => 'required|string|max:50|unique:tagsWhat',
            'who.*'         => 'required|string|max:50|unique:tagsWho',
            'drive'         => 'required|in:azure,dropbox',
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
                return response()->json(['error' => 'File is not available'], 422);

            return redirect(route('files.upload'))->with(['error'=>'File is not available']);
        }

        //Exit early if the file isn't valid
        if(!request()->file('file')->isValid())
        {
            if(request()->wantsJson())
                return response()->json(['error' => 'File is not valid'], 422);

            return redirect(route('files.upload'))->with(['error'=>'File is not valid']);
        }

        $rawFile    = request()->file('file');
        $short_id   = File::generateUniqueShortID();
        $extension  = (string)$rawFile->clientExtension();
        $name       = $short_id . '.' . $extension;

        $file = File::create([
            'user_id'       => auth()->user()->id,
            'short_id'      => $short_id,
            'drive'         => request('drive'),
            'type'          => File::getFileType((string)$rawFile->getMimeType()),
            'extension'     => $extension,
            'size'          => (int)$rawFile->getClientSize(),
            'original_name' => (string)$rawFile->getClientOriginalName(),
            'name'          => $name,
            'url'           => File::storeAndReturnUrl($name),
            'title'         => request('title'),
            'description'   => request('description'),
            'what'          => request('what'),
            'where'         => request('where'),
            'who'           => request('who'),
            'when'          => request('when'),
        ]);

        if(request()->wantsJson())
            return response()->json(['status' => 'File uploaded successfully!', 'data' => $file], 201);

        return redirect(route('files.upload'))->with(['status' => 'File uploaded successfully!']);
    }
}