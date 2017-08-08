<?php

namespace FrontFiles\Http\Controllers\Files;

use FrontFiles\{
    File, Inspections\TokenValidator\TokenValidator
};
use FrontFiles\Http\Controllers\Controller;
use FrontFiles\Http\Requests\{ CreateFileRequest, UpdateFileRequest };

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::where('user_id', auth()->user()->id)->latest()->get();

        return request()->wantsJson() ? $files : view('files.index', compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $files = File::where('user_id', auth()->user()->id)->latest()->get();

        $dropbox_token = $this->checkIfDropboxTokenIsStillValid();
        
        if(request()->expectsJson())
            return response([
                'data' => $file,
                'dropbox_token' => $dropbox_token
            ], 200);

        $dropbox_token = json_encode($dropbox_token);

        return view('files.create', compact('files', 'dropbox_token'));
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

        if(request()->expectsJson())
            return $file;

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
            return response(['status' => 'File successfully deleted!'], 204);

        return back()
            ->with('message', 'File deleted!');
    }

    /**
     * Verifies if the Dropbox token is still valid.
     *
     * @return bool
     */
    protected function checkIfDropboxTokenIsStillValid() : bool
    {
        try{
            return (new TokenValidator)->check('dropbox', auth()->user()->id);
        } catch(\Exception $e){
            return false;
        }
    }
}
