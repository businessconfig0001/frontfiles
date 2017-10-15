<?php

namespace FrontFiles\Http\Controllers\Home;

use FrontFiles\File;
use FrontFiles\Http\Controllers\Controller;
use FrontFiles\User;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('landing');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function main()
    {
        return view('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inside()
    {
        $files = File::latest()
            ->orderBy('id', 'desc')
            ->paginate(9);

        $jsonfiles = json_encode($files);

        return view('inside', compact('files','jsonfiles'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function community()
    {
        $users = User::orderBy('first_name')
            ->paginate(12);


        $jsonusers= json_encode($users);

        $all_users = json_encode(User::all());

        return view('community', compact('users','jsonusers','all_users'));
    }
}
