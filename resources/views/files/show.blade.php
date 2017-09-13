@extends('layouts.app')

@section('content')
    <file-detail :fileprop="{{$file}}" :user="{{ Auth::user() }}"></file-detail>
@endsection