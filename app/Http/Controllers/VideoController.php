<?php

namespace App\Http\Controllers;

use App\Video;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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



                return response()->json(array('status'=>'Avatar updated!'));

            }
            return response()->json(array('error'=>'Avatar file is not valid'));
        }

        if ($request->hasFile('video')) {
            if ($request->file('video')->isValid()) {

                $file = $request->file('video');
                $extension = $file->getClientOriginalExtension();
                $name = $request->get('title') . time() . '.' . $extension;
                $destinationPath = public_path('/videos');

                $file_final=$file->move($destinationPath, $name);

                $video = new Video();

                $video->title = $request->get('title');
                $video->description = $request->get('description');
                $video->path = $destinationPath . $name;
                $video->user_id = Auth::user()->id;

                // Copy to remote
                $path = $file_final->store(
                    'videos', 'azure'
                );

                $url = config('filesystems.disks.azure.url').$path;
                $video->url=$url;

                $video->save();

                return redirect('/upload')->json(array('status'=>'Video uploaded!'));
            }
            return redirect('/upload')->json(array('error'=>'Video file is not valid'));
        }
        return redirect('/upload')->json(array('error'=>'Video file is not available'));
    }
}
