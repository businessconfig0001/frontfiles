<?php

namespace FrontFiles\Http\Controllers;

use FrontFiles\Http\Requests\{
    CreateVideoRequest, UpdateVideoRequest
};
use FrontFiles\Video;

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
        $videos = Video::where('user_id', auth()->user()->id)->get();

        return request()->wantsJson() ? $videos : view('videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $videos = Video::where('user_id', auth()->user()->id)->get();

        return request()->wantsJson() ? $videos : view('videos.create', compact('videos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateVideoRequest $form
     * @return \Illuminate\Http\Response
     */
    public function store(CreateVideoRequest $form)
    {
        return $form->persist();
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
     * @param Video $video
     * @param UpdateVideoRequest $form
     * @return \Illuminate\Http\Response
     */
    public function update(Video $video, UpdateVideoRequest $form)
    {
        $this->authorize('update', $video);

        return $form->persist($video);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Video $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $this->authorize('delete', $video);

        $video->delete();

        if(request()->expectsJson())
            return response(['status' => 'Video successfully deleted!']);

        return back();
    }
}
