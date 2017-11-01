<?php

namespace FrontFiles\Http\Controllers\Files;

use FrontFiles\{
    File, Inspections\TokenValidator\TokenValidator, Utility\DriversHelper
};
use FrontFiles\Http\Controllers\Controller;
use FrontFiles\Http\Requests\{ CreateFileRequest, UpdateFileRequest };
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

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
                'data' => $files,
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

        $FBOpenGraphImg = asset('images/ff_generic_fb_logo.png');

        if($file->processed)
        {
            if($file->type === 'image') $FBOpenGraphImg = $file->azure_url;
            if($file->type === 'video') $FBOpenGraphImg = asset('images/ff_generic_fb_video_thumbnail.png');
        }

        if(request()->expectsJson())
            return response([
                'data' => $file,
            ], 200);

        return view('files.show', compact('file', 'FBOpenGraphImg'));
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
     * Downloads the original file from the user's Dropbox.
     *
     * @param File $file
     * @return $this
     * @throws FileNotFoundException
     */
    public function downloadFile(File $file)
    {
        $this->authorize('download', $file);

        $filesystem = DriversHelper::userDropbox($file->owner->dropbox_token);

        if(!$filesystem->has($file->name))
            throw new FileNotFoundException('We couln\'t find this file!');

        Storage::disk('local')->put($file->name, $filesystem->read($file->name));

        return response()
            ->download(public_path('userFiles/').$file->name)
            ->deleteFileAfterSend(true);
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
