<?php

namespace FrontFiles\Http\Controllers\Files;

use FrontFiles\{File, User };
use Laravel\Socialite\Facades\Socialite;
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

        $this->checkIfTokensAreStillValid();

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

        return back();
    }

    /**
     * Verifies if the tokens are still valid.
     */
    protected function checkIfTokensAreStillValid()
    {
        $user = User::find(auth()->user()->id);

        try{
            Socialite::driver('dropbox')->userFromToken($user->dropbox_token);
        } catch(\Exception $e) {
            $user->update(['dropbox_token' => null]);
        }
    }
}
