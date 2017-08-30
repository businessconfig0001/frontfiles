@extends('layouts.app')

@section('content')

    <div class="show-container">
        <file-detail :file="{{$file}}"></file-detail>
    </div>

@endsection