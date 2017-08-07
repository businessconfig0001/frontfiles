@extends('layouts.app')

@section('content')
    <!-- form-container -->
    <section class="form-container">
	    <drag-n-drop :files="{{$files}}"></drag-n-drop>
    </section><!-- form-container -->

    <!-- /modules -->
               
@endsection