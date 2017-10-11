@extends('layouts.app')

@section('content')
 	<div class="container">
		
	    <div class="row">
	    	<map-component :data="{{$jsonusers}}.data"></map-component>
	    	<h1 class="pioneers">pioneers worldwide</h1>
    		<user-listing :users="{{$jsonusers}}.data"></user-listing>
    	</div>

    	{{$users->links()}}
    </div>

@endsection