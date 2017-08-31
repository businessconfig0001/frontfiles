@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="show-container">
            <file-detail :file="{{$file}}"></file-detail>
        </div> 
    </div>
@endsection