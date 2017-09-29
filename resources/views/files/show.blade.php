@extends('layouts.app')

@section('content')

	@if (Auth::guest())
		<file-detail :fileprop="{{$file}}" :author="'{{$file->owner->fullNameAndLocation()}}'"></file-detail>
	@else
		<file-detail :fileprop="{{$file}}" :user="{{ Auth::user() }}" :author="'{{$file->owner->fullNameAndLocation()}}'"></file-detail>
	@endif
    
@endsection