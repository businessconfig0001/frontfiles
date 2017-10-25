<?php

namespace FrontFiles\Http\Controllers\Home;

use FrontFiles\{User, File};
use Illuminate\Support\Facades\Storage;
use FrontFiles\Http\Controllers\Controller;

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

        $jsonusers = json_encode($users);

        $all_users = json_encode(User::all());

        return view('community', compact('users','jsonusers','all_users'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function slideshow()
    {
        $raw_images = Storage::disk('slideshow')->files();

        $images = [];

        foreach($raw_images as $image)
            $images[] = [
                'name' => pathinfo($image, PATHINFO_FILENAME),
                'src' => $image
            ];

        return response(['images' => $images], 200);
    }
}
