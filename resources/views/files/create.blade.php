@extends('layouts.app')

@section('content')
	<div class="bg-photo bg-create">
	</div>
    <!-- form-container -->
    <section class="form-container">
	    <drag-n-drop :files="{{$files}}"></drag-n-drop>
    </section><!-- form-container -->

    <!-- /modules -->
               
@endsection