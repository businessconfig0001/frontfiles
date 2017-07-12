<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Video;
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

    }

    public function store(CreateVideoRequest $request)
    {

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
                case 'path' :               $video->path        = $value; break;
                case 'url' :                $video->url  = $value; break;
            }
        }

        $video->save();

        return response()->json(array('status' => 'Video updated.','data'=>$video));
    }
}
