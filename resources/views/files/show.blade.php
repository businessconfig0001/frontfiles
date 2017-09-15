@extends('layouts.app')

@section('content')
	@if (Auth::guest())
		<file-detail :fileprop="{{$file}}"></file-detail>
	@else
		<file-detail :fileprop="{{$file}}" :user="{{ Auth::user() }}"></file-detail>
	@endif
    
@endsection