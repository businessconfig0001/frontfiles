<?php

namespace FrontFiles\Http\Controllers\Tag;

use FrontFiles\File;
use FrontFiles\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @param $name string
     * @return \Illuminate\Http\Response
     */
    public function index($name)
    {
        $files = File::whereHas('tagsWhat', function($q) use ($name){ $q->where('name', $name); })
            ->orderBy('id', 'desc')
            ->paginate(25);

        if(request()->expectsJson())
            return response([
                'data' => $files,
            ], 200);

        return view('tags.index', compact('files'));
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
