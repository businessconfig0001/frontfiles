@extends('layouts.app')

@section('content')

    
	<div class="container">
		<h1 class="auth-title">Inside</h1>
	    <div class="row">
	    @guest	
	        <files-display :_files="{{$jsonfiles}}.data"></files-display>
	     @endguest
	     @auth
			<files-display :_files="{{$jsonfiles}}.data" :activeuser="{{Auth::user()}}"></files-display>
	     @endauth
	    </div>

	    {{$files->links()}}
	</div>



@endsection