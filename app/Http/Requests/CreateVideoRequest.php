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

        $filename = $this->getVideoFilename();

        $video = Video::create([
            'user_id' => auth()->user()->id,
            'short_id' => uniqid(),
            'filename' => $filename,
            'url' => $this->getVideoUrl($filename),
            'title' => request('title'),
            'description' => request('description'),
            'what' => request('what'),
            'where' => request('where'),
            'who' => request('who'),
            'when' => request('when'),
        ]);

        if(request()->wantsJson())
            return response()->json(array('status' => 'Video uploaded successfully!', 'data' => $video));

        return redirect('/video/upload')->with(array('status' => 'Video uploaded successfully!'));
    }

    /**
     * Returns the filename of the video.
     *
     * @return string
     */
    protected function getVideoFilename()
    {
        return request()->get('title') .
            uniqid() .
            '.' .
            request()
                ->file('video')
                ->getClientOriginalExtension();
    }

    /**
     * Returns the URL of the video.
     *
     * @param string $filename
     * @return string
     */
    protected function getVideoUrl($filename)
    {
        // Copy to remote
        //!!! REMOVE THIS ON PRODUCTION
        ini_set('memory_limit', '-1');

        if(config('filesystems.default') === 'local')
            return config('filesystems.disks.local.url') .
                request()
                    ->file('video')
                    ->storeAs('usercontents', $filename, config('filesystems.default'));

        return config('filesystems.disks.azure.url') .
            request()
                ->file('video')
                ->storeAs('usercontents', $filename, config('filesystems.default'));
    }
}
