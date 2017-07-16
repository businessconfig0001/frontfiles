<?php

namespace FrontFiles\Http\Controllers;

use FrontFiles\Http\Requests\{
    CreateFileRequest, UpdateFileRequest
};
use FrontFiles\File;

class FilesController extends Controller
{
    /**
     * FilesController constructor.
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
        $files = File::where('user_id', auth()->user()->id)
            ->latest()
            ->get();

        return request()->wantsJson() ? $files : view('files.index', compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $files = File::where('user_id', auth()->user()->id)
            ->latest()
            ->get();

        return request()->wantsJson() ? $files : view('files.create', compact('files'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateFileRequest $form
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFileRequest $form)
    {
        return $form->persist();
    }

    /**
     * Display the specified resource.
     *
     * @param string $short_id
     * @return \Illuminate\Http\Response
     */
    public function show($short_id)
    {
        $file = File::where('short_id', $short_id)->firstOrFail();

        $this->authorize('view', $file);

        return view('files.show', compact('file'));
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
     * @param File $file
     * @param UpdateFileRequest $form
     * @return \Illuminate\Http\Response
     */
    public function update(File $file, UpdateFileRequest $form)
    {
        $this->authorize('update', $file);

        return $form->persist($file);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param File $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $this->authorize('delete', $file);

        $file->delete();

        if(request()->expectsJson())
            return response(['status' => 'File successfully deleted!']);

        return back();
    }
}
