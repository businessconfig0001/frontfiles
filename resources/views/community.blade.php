@extends('layouts.app')

@section('content')
 	<div class="container">
		
	    <div class="row">
	    	<h1 class="pioneers">pioneers worldwide</h1>
    		<user-listing :users="{{$jsonusers}}.data"></user-listing>
    	</div>
    </div>

@endsection