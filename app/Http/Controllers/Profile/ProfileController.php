<?php

namespace FrontFiles\Http\Controllers\Profile;

use FrontFiles\{ User, File};
use Laravel\Socialite\Facades\Socialite;
use FrontFiles\Http\Controllers\Controller;
use FrontFiles\Http\Requests\UpdateProfileRequest;

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

        if(request()->expectsJson())
            return response()->json(['data' => $user], 200);

        return view('profile.index', compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        $files = File::where('user_id', $user->id)->latest()->get();

        $role = $user->getRoleNames()->toArray()[0];

        if(request()->expectsJson())
            return response()->json([
                'data'  => $user,
                'role'  => $role,
                'files' => $files,
            ], 200);

        return view('profile.show', compact('user','files', 'role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
 public function edit()
    {
        $user = User::find(auth()->user()->id);

        $this->authorize('edit', $user);

        if(request()->expectsJson())
            return response()->json([
                'data' => $user,
                'role' => $user->getRoleNames()->toArray()[0],
            ], 200);

        return view('profile.edit', compact('user'));
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

        return redirect()
            ->route('home')
            ->with('message', 'Account deleted!');
    }

    /**
     * CONNECT USER ACCOUNT TO DROPBOX
     */

    /**
     * Redirects the user tho the Dropbox auth page.
     *
     * @return mixed
     */
    public function dropbox()
    {
        $user = User::find(auth()->user()->id);

        $this->authorize('oauth', $user);

        return Socialite::driver('dropbox')->redirect();
    }

    /**
     * Saves the user dropbox token and redirects to his profile.
     *
     * @return mixed
     */
    public function dropboxCallback()
    {
        $user = User::find(auth()->user()->id);

        $this->authorize('oauth', $user);

        $dropboxUser = Socialite::driver('dropbox')->user();

        $user->update(['dropbox_token' => $dropboxUser->token]);

        return redirect()
            ->route('files.upload')
            ->with('message', 'Dropbox successfully connected!');
    }
}