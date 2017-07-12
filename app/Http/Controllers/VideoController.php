<?php

namespace App\Http\Controllers;

use App\Video;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
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

    public function store(Request $request){
         $this->validate($request, [
            'video' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('video')) {
            if ($request->file('video')->isValid()) {

                $file = $request->file('video');
                $extension = $file->getClientOriginalExtension();
                $name = $request->get('title') . uniqid() . '.' . $extension;
                $destinationPath = public_path('/videos/');
                //$file = $request->file('video')->move($destinationPath,$name);

                $video = new Video();
                $video->title = $request->get('title');
                $video->description = $request->get('description');
                $video->user_id = Auth::user()->id;
                $video->filename=$name;

                // Copy to remote
                ini_set('memory_limit', '-1');
                $path =  $request->file('video')->storeAs(
                    'usercontents',$name, 'azure'
                );

                $url = config('filesystems.disks.azure.url').$path;
                $video->url=$url;
                $video->save();

                return redirect('/upload')->with(array('status'=>'Video uploaded!'));
            }
            return redirect('/upload')->with(array('error'=>'Video file is not valid'));
        }
        return redirect('/upload')->with(array('error'=>'Video file is not available'));
    }
}
