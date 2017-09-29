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

        return view('inside', compact('files'));
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

        return view('community', compact('users'));
    }
}
