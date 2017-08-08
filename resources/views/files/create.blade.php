@extends('layouts.app')

@section('content')
    <!-- form-container -->
    <h1>{{ $dropbox_token }}</h1>
    <section class="form-container">
	    <drag-n-drop :files="{{$files}}" :dropbox="'ddd'"></drag-n-drop>
    </section><!-- form-container -->

    <!-- /modules -->
               
@endsection