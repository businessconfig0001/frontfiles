@extends('layouts.app')

@section('content')

	<h1 class="auth-title">Inside</h1>
	<vue-slider class="slider"></vue-slider> 	 
	<div class="container">

	    <div class="row">
			<div class="clearfix map">
				<map-component :data="{{$jsonfiles}}.data"></map-component>	
			</div>
	    	
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