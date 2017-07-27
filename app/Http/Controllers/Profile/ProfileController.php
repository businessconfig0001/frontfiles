<?php

namespace FrontFiles\Http\Controllers\Profile;

use FrontFiles\User;
use Kunnu\Dropbox\{ Dropbox, DropboxApp};
use FrontFiles\Http\Controllers\Controller;
use FrontFiles\Http\Requests\UpdateProfileRequest;
use FrontFiles\Http\Requests\CreateOrUpdateUserDropboxToken;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);

        $this->authorize('view', $user);

        $authUrl = '';

        if(!$user->dropbox_token)
        {
            //Configure Dropbox Application
            $appInfo = new DropboxApp(env('DROPBOX_KEY'), env('DROPBOX_SECRET'));

            //DropboxAuthHelper
            $authHelper = (new Dropbox($appInfo))->getAuthHelper();

            //Auth URL + callback URL
            $authUrl = $authHelper->getAuthUrl(route('profile.dropbox.auth'));
        }

        if(request()->expectsJson())
            return response()->json(['data' => $user, 'authUrl' => $authUrl], 200);

        return view('profile.index', compact('user', 'authUrl'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        $this->authorize('view', $user);

        if(request()->expectsJson())
            return response()->json(['data' => $user], 200);

        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
//        $user = User::find(auth()->user()->id);
//
//        $this->authorize('edit', $user);
//
//        if(request()->expectsJson())
//            return response()->json(['data' => $user], 200);
//
//        return view('profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProfileRequest $form
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $form)
    {
        $user = User::find(auth()->user()->id);

        $this->authorize('update', $user);

        return $form->persist($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = User::find(auth()->user()->id);

        $this->authorize('delete', $user);

        $user->delete();

        if(request()->expectsJson())
            return response(['status' => 'Profile successfully deleted!'], 204);

        return redirect()->route('home');
    }


    /**
     * Saves the user dropbox token and redirects to his profile.
     *
     * @param CreateOrUpdateUserDropboxToken $form
     * @return mixed
     */
    public function dropboxAuth(CreateOrUpdateUserDropboxToken $form)
    {
        dd('test');
        $user = User::find(auth()->user()->id);

        $this->authorize('update', $user);

        return $form->persist($user);
    }
}