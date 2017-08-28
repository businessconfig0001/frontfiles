<?php

namespace FrontFiles\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use FrontFiles\{
    File, Jobs\FetchAndProcessFile, TagWhat, TagWho, Utility\DriversHelper
};

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
            'file'          => 'required|file|allowed_file|max:524288000',
            'title'         => 'required|string|max:175',
            'description'   => 'required|string',
            'where'         => 'required|string|max:175',
            'when'          => 'required|date',
            'what.*'        => 'required|string|max:25',
            'who.*'         => 'required|string|max:25',
            'why'           => 'nullable|string|max:160',
            'drive'         => 'required|string|valid_token|in:dropbox',
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

        $this->storeFile($name);

        $file = File::create([
            'user_id'       => auth()->user()->id,
            'short_id'      => $short_id,
            'drive'         => request('drive'),
            'type'          => File::getFileType((string)$rawFile->getMimeType()),
            'extension'     => $extension,
            'size'          => (int)$rawFile->getClientSize(),
            'original_name' => (string)$rawFile->getClientOriginalName(),
            'name'          => $name,
            'url'           => $this->getUrl($name),
            'title'         => request('title'),
            'description'   => request('description'),
            'where'         => request('where'),
            'when'          => request('when'),
            'why'           => request('why'),
        ]);

        $file->tagsWhat()->sync(
            $this->getTagIds(request('what'), TagWhat::class)
        );

        $file->tagsWho()->sync(
            $this->getTagIds(request('who'), TagWho::class)
        );

        dispatch(
            (new FetchAndProcessFile($file))
                ->onQueue('regular_files')
                ->onConnection('database')
                ->delay(Carbon::now()->addMinutes(1))
        );

        if(request()->wantsJson())
            return response()->json(['status' => 'File uploaded successfully!', 'data' => $file], 201);

        return redirect(route('files.upload'))->with(['status' => 'File uploaded successfully!']);
    }

    /**
     * Returns an array with the id's of the tags.
     *
     * @param string $tags
     * @param $type
     * @return array
     */
    protected function getTagIds(string $tags, $type) : array
    {
        $tagsFiltered = json_decode($tags, true);
        $output = [];

        foreach($tagsFiltered as $tag)
            if(!$type::where('name', $tag)->exists())
                array_push($output, $type::create(['name' => $tag])->id);
            else
                array_push($output, $type::where('name', $tag)->first()->id);

        return $output;
    }

    /**
     * Stores the file.
     *
     * @param string $name
     */
    protected function storeFile(string $name)
    {
        $filesystem = DriversHelper::userDropbox(auth()->user()->dropbox_token);

        $filesystem->write($name, file_get_contents(request()->file('file')));
    }

    /**
     * Returns the file URL.
     *
     * @param string $name
     * @return string
     */
    protected function getUrl(string $name) : string
    {
        return env('DROPBOX_APP_URL') . '/' . env('DROPBOX_APP_FOLDER') . '/' . $name;
    }
}