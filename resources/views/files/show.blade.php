@extends('layouts.app')

@section('content')

    <div class="show-container">
        <div class="row">
            <div class="block-container">
                <video controls>
                    <source src="{{$file->url}}">
                </video>
                <h2>{{$file->title}}</h2>
                <p>{{$file->description}}</p>
                <ul>
                    <li>#Where: <span>{{$file->where}}</span></li>
                    <li>#When: <span>{{$file->when}}</span></li>
                    <li>#Who: <span>{{$file->who}}</span></li>
                    <li>#What: <span>{{$file->what}}</span></li>
                </ul>
            </div>
        </div>
    </div>

@endsection