@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <files-display :files="{{$files}}"></files-display>
        </div>
    </div>

@endsection
