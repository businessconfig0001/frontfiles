<?php

namespace FrontFiles\Http\Requests;

use FrontFiles\File;
use FrontFiles\{ TagWhat, TagWho };
use Illuminate\Foundation\Http\FormRequest;

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
            'file'          => 'required|file|allowed_file|has_enough_space|size:524288000',
            'title'         => 'required|string|max:175',
            'description'   => 'required|string',
            'where'         => 'required|string|max:175',
            'when'          => 'required|date',
            'what.*'        => 'required|string|max:25',
            'who.*'         => 'required|string|max:25',
            'why'           => 'nullable|string|max:160',
            'drive'         => 'required|in:nothing,dropbox',
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

        $drive = request('drive') === 'dropbox' ? 'dropbox' : 'azure';

        $file = File::create([
            'user_id'       => auth()->user()->id,
            'short_id'      => $short_id,
            'drive'         => $drive,
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

        $tagsWhat = json_decode(request('what'), true);
        $tagsWho = json_decode(request('who'), true);
        $tagsWhatIds = [];
        $tagsWhoIds = [];

        foreach($tagsWhat as $tagWhat)
            if(!TagWhat::where('name', $tagWhat)->exists())
                array_push($tagsWhatIds, TagWhat::create(['name' => $tagWhat])->id);
            else
                array_push($tagsWhatIds, TagWhat::where('name', $tagWhat)->first()->id);

        foreach($tagsWho as $tagWho)
            if(!TagWho::where('name', $tagWho)->exists())
                array_push($tagsWhoIds, TagWho::create(['name' => $tagWho])->id);
            else
                array_push($tagsWhoIds, TagWho::where('name', $tagWho)->first()->id);

        $file->tagsWhat()->sync($tagsWhatIds);
        $file->tagsWho()->sync($tagsWhoIds);

        if(request()->wantsJson())
            return response()->json(['status' => 'File uploaded successfully!', 'data' => $file], 201);

        return redirect(route('files.upload'))->with(['status' => 'File uploaded successfully!']);
    }
}