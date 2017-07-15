@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="block-container">
                <video controls>
                    <source src="{{$video->url}}">
                </video>
                <h2>{{$video->title}}</h2>
                <p>{{$video->description}}</p>
                <ul>
                    <li>#Where: <span>{{$video->where}}</span></li>
                    <li>#When: <span>{{$video->when}}</span></li>
                    <li>#Who: <span>{{$video->who}}</span></li>
                    <li>#What: <span>{{$video->what}}</span></li>
                </ul>
            </div>
        </div>
    </div>

@endsection