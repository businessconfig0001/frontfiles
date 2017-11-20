<?php

namespace FrontFiles\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use FrontFiles\Http\Controllers\Controller;
use FrontFiles\{User, File, Utility\DriversHelper};
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class BackendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);

        $files = File::latest()
            ->orderBy('id', 'desc')
            ->paginate(50);

        return view('backend.index', compact('user', 'files'));
    }

    /**
     * Downloads the original file from the user's Dropbox.
     *
     * @param File $file
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
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
