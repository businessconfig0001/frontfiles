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
     * Corrects data.
     *
     * @return array
     */
    protected function validationData(): array
    {
        $all = parent::validationData();

        if (is_string($what = array_get($all, 'what')))
            $what = json_decode($what, true);

        if (is_string($who = array_get($all, 'who')))
            $who = json_decode($who, true);

        $all['what'] = $what;
        $all['who'] = $who;

        return $all;
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
            'what.*'        => 'required|string|max:50|unique:tagswhat,name',
            'who.*'         => 'required|string|max:50|unique:tagswho,name',
            'why'           => 'nullable|string|max:160',
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

        dd('works');
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
            'where'         => request('where'),
            'when'          => request('when'),
            'why'           => request('why'),
        ]);

        $file->tagsWhat()->attach(request('what'));
        $file->tagsWho()->attach(request('who'));

        if(request()->wantsJson())
            return response()->json(['status' => 'File uploaded successfully!', 'data' => $file], 201);

        return redirect(route('files.upload'))->with(['status' => 'File uploaded successfully!']);
    }
}