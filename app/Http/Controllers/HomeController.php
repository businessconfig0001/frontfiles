<?php

namespace App\Http\Controllers;

use App\Video;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('create');
    }

    public function upload(Request $request){
         $this->validate($request, [
            'video' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);
        $file = $request->file('video');
        $extension=$file->getClientOriginalExtension();
        $name =  $request->get('title').time().'.'.$extension;
        $destinationPath = public_path('/videos');

        $file->move($destinationPath,$name);

        $video = new Video();

        $video->title = $request->get('title');
        $video->description = $request->get('description');
        $video->path = $destinationPath.$name;
        $video->user_id = Auth::user()->id;

        $video->save();

        return redirect('upload');

    }
}
