<?php

namespace FrontFiles\Http\Controllers;

use FrontFiles\Video;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    /**
     * VideosController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::where('user_id',Auth::user()->id);

        if(request()->wantsJson())
            return $videos->get();

        return view('videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('videos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'video' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('video')) {
            if ($request->file('video')->isValid()) {

                $file = $request->file('video');
                $extension = $file->getClientOriginalExtension();
                $name = $request->get('title') . uniqid() . '.' . $extension;
                $destinationPath = public_path('/videos/');
                //$file = $request->file('video')->move($destinationPath,$name);

                $video = new Video();
                $video->title = $request->get('title');
                $video->description = $request->get('description');
                $video->user_id = Auth::user()->id;
                $video->filename=$name;

                // Copy to remote
                ini_set('memory_limit', '-1');
                $path =  $request->file('video')->storeAs(
                    'usercontents',$name, 'azure'
                );

                $url = config('filesystems.disks.azure.url').$path;
                $video->url=$url;
                $video->save();

                return redirect('/videos/upload')->with(array('status'=>'Video uploaded!'));
            }
            return redirect('/videos/upload')->with(array('error'=>'Video file is not valid'));
        }
        return redirect('/videos/upload')->with(array('error'=>'Video file is not available'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
