<?php

namespace FrontFiles\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use FrontFiles\File;
use Illuminate\Support\Facades\Artisan;

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
            'what'          => 'required|string|max:175',
            'where'         => 'required|string|max:175',
            'when'          => 'required|date',
            'who'           => 'required|string|max:175',
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
        $extension = (string)$rawFile->clientExtension();
        $name = $short_id . '.' . $extension;

        $file = File::create([
            'user_id' => auth()->user()->id,
            'short_id' => $short_id,
            'type' => File::getFileType((string)$rawFile->getMimeType()),
            'extension' => $extension,
            'size' => (int)$rawFile->getClientSize(),
            'original_name' => (string)$rawFile->getClientOriginalName(),
            'name' => $name,
            'url' => File::storeAndReturnUrl($name),
            'title' => request('title'),
            'description' => request('description'),
            'what' => request('what'),
            'where' => request('where'),
            'who' => request('who'),
            'when' => request('when'),
        ]);

        /**  CHANGES HERE (IMPROVE THE CODE) */
        $container = 'user-id-' . auth()->user()->id;

        $config = config('filesystems.local.root');
        $local_path=public_path('userFiles').'/'.$container.'/';

        Artisan::queue('convert:video', [
            'storage_path' => $local_path,
            'input' =>  $name,
            'output' =>         $name = $short_id . 'encoded.' . $extension,
            'watermark_image' => asset('images/logo2x.png'),
        ]);
        $config = config('filesystems.default');

        $file->name=$name;
        $file->url=config('filesystems.disks.local.url').'/'.$container.'/'.$name;
        $file->save();
        /**  END CHANGES HERE */

        if(request()->wantsJson())
            return response()->json(array('status' => 'File uploaded successfully!', 'data' => $file));

        return redirect('/files/upload')->with(array('status' => 'File uploaded successfully!'));
    }
}
