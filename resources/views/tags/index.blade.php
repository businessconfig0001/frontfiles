@extends('layouts.app')

@section('content')
	<h2 class="auth-title">{{ $name }}</h2>
	@if(Auth::guest())
    	<files-display :_files="{{ $jsonfiles }}.data" ></files-display>
   	@else
		<files-display :_files="{{ $jsonfiles}}.data" :activeUser="{{ Auth::user()}}"></files-display>
	@endif

@endsection