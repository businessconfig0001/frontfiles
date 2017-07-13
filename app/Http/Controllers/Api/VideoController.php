<?php

namespace FrontFiles\Http\Controllers\Api;

use App\Http\Requests\Request;
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

    public function store(Request $request)
    {
        this.validate($request->input->all(),[
            'video' => 'required|video',
            'title' => 'required',
            'description' => 'required',
            'what' => 'required',
            'where' => 'required',
            'when' => 'required',
            'who' => 'required',
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$request->all();
        $video = Video::find($id);

        //$this->authorize('update', $doctor);
        foreach((array) $data as $key => $value) {
            switch($key) {
                case 'title' :              $video->title           = $value; break;
                case 'description' :        $video->description     = $value; break;
                case 'what' :               $video->description     = $value; break;
                case 'where' :              $video->description     = $value; break;
                case 'when' :               $video->description     = $value; break;
                case 'who'  :               $video->description     = $value; break;

            }
        }

        $video->save();

        return response()->json(array('status' => 'Video updated.','data'=>$video));
    }
}
