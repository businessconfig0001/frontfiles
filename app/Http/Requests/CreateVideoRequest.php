<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use FrontFiles\Video;

class CreateVideoRequest extends Request {

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
            'video' => 'required|video',
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
     * @param $request
     * @return mixed
     */
    public function persist($request)
    {
        //Exit early if the request doesn't have a video
        if(!$request->hasFile('video'))
        {
            if(request()->wantsJson())
                return response()->json(array('error' => 'Video file is not available'));

            return redirect('/video/upload')->with(array('error'=>'Video file is not available'));
        }

        //Exit early if the video isn't valid
        if(!$request->file('video')->isValid())
        {
            if(request()->wantsJson())
                return response()->json(array('error' => 'Video file is not valid'));

            return redirect('/video/upload')->with(array('error'=>'Video file is not valid'));
        }

        $file = $request->file('video');
        $extension = $file->getClientOriginalExtension();
        $name = $request->get('title') . uniqid() . '.' . $extension;
        $destinationPath = public_path('/videos/');
        //$file = $request->file('video')->move($destinationPath,$name);

        $video = new Video();
        $video->user_id = auth()->user()->id;
        $video->short_id = uniqid();
        $video->filename = $name;
        $video->title = $request->title;
        $video->description = $request->description;
        $video->what = $request->what;
        $video->where = $request->where;
        $video->who = $request->who;
        $video->when = $request->when;

        // Copy to remote
        ini_set('memory_limit', '-1');
        $path =  $request->file('video')->storeAs(
            'usercontents', $name, 'azure'
        );

        $video->url = config('filesystems.disks.azure.url') . $path;

        $video->save();

        if(request()->wantsJson())
            return response()->json(array('status' => 'Video uploaded!', 'data' => $video));

        return redirect('/video/upload')->with(array('status' => 'Video uploaded!'));
    }

}
