@extends('layouts.app')

@section('fb-data')
<!-- Facebook Open Graph -->
		<meta property="og:title" 		content="FrontFiles">
		<meta property="og:description" content="{{ $file->title }}">
		<meta property="og:url" 		content="{{ url()->current() }}">
        <meta property="og:type" 		content="article">
        <meta property="og:image" 		content="{{ asset('images/logo2x.png') }}">
@endsection

@section('content')

	@if (Auth::guest())
		<file-detail :fileprop="{{$file}}" :author="'{{$file->owner->fullNameAndLocation()}}'"></file-detail>
	@else
		<file-detail :fileprop="{{$file}}" :user="{{ Auth::user() }}" :author="'{{$file->owner->fullNameAndLocation()}}'"></file-detail>
	@endif
    
@endsection