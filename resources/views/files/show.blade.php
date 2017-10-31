@extends('layouts.app')

@section('fb-data')
<!-- Facebook Open Graph -->
		<meta property="og:site_name" 			content="FrontFiles">
		<meta property="og:title" 				content="{{ $file->title }}">
		<meta property="og:description" 		content="{{ $file->description }}">
		<meta property="og:url" 				content="{{ url()->current() }}">
        <meta property="og:type" 				content="article">
        <meta property="og:image" 				content="{{ asset('images/ff_generic_fb_logo.png') }}">
		<meta property="og:locale" 				content="en_GB">
		<meta property="og:locale:alternate" 	content="pt_PT">
		<meta property="og:locale:alternate" 	content="pt_BR">
@endsection

@section('content')

	@if (Auth::guest())
		<file-detail :fileprop="{{$file}}" :author="'{{$file->owner->fullNameAndLocation()}}'"></file-detail>
	@else
		<file-detail :fileprop="{{$file}}" :user="{{ Auth::user() }}" :author="'{{$file->owner->fullNameAndLocation()}}'"></file-detail>
	@endif
    
@endsection