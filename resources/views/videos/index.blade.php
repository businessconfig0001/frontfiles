@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <video-display :videos="{{$videos}}"></video-display>
        </div>
    </div>

@endsection
