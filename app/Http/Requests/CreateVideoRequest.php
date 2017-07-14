<?php

namespace FrontFiles\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use FrontFiles\Video;

class CreateVideoRequest extends FormRequest
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
            'video' => 'required',
            'title' => 'required',
            'description' => 'required',
            'what' => 'required',
            'where' => 'required',
            'when' => 'required',
            'who' => 'required',
        ];
    }

    /**
     * Processes the request and then stores the video.
     *
     * @return mixed
     */
    public function persist()
    {
        //Exit early if the request doesn't have a video
        if(!request()->hasFile('video'))
        {
            if(request()->wantsJson())
                return response()->json(array('error' => 'Video file is not available'));

            return redirect('/video/upload')->with(array('error'=>'Video file is not available'));
        }

        //Exit early if the video isn't valid
        if(!request()->file('video')->isValid())
        {
            if(request()->wantsJson())
                return response()->json(array('error' => 'Video file is not valid'));

            return redirect('/video/upload')->with(array('error'=>'Video file is not valid'));
        }

        $file = request()->file('video');
        $extension = $file->getClientOriginalExtension();
        $name = request()->get('title') . uniqid() . '.' . $extension;

        $video = new Video();
        $video->user_id = auth()->user()->id;
        $video->short_id = uniqid();
        $video->filename = $name;
        $video->title = request()->title;
        $video->description = request()->description;
        $video->what = request()->what;
        $video->where = request()->where;
        $video->who = request()->who;
        $video->when = request()->when;

        // Copy to remote
        ini_set('memory_limit', '-1');
        $path =  request()->file('video')->storeAs(
            'usercontents', $name, config('filesystems.default')
        );

        $video->url = config('filesystems.disks.azure.url') . $path;

        $video->save();

        if(request()->wantsJson())
            return response()->json(array('status' => 'Video uploaded successfully!', 'data' => $video));

        return redirect('/video/upload')->with(array('status' => 'Video uploaded successfully!'));
    }

}
