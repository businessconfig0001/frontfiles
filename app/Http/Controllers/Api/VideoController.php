<?php

namespace FrontFiles\Http\Controllers\Api;

use App\Http\Requests\CreateVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use FrontFiles\Http\Controllers\Controller;
use FrontFiles\Video;

class VideoController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function index()
    {
        $videos=Video::where('user_id',Auth::user()->id);
        return response()->json(array('data'=>$videos));
    }

    public function store($request)
    {
        \Log::info($request);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVideoRequest $request, $id)
    {
        $data=$request->all();
        $video = Video::find($id);

        //$this->authorize('update', $doctor);
        foreach((array) $data as $key => $value) {
            switch($key) {
                case 'title' :              $video->title    = $value; break;
                case 'description' :        $video->description     = $value; break;
            }
        }

        $video->save();

        return response()->json(array('status' => 'Video updated.','data'=>$video));
    }
}
