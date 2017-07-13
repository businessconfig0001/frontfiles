@extends('layouts.app')

@section('content')
                <!-- form-container -->
                <section class="form-container">
				    <drag-n-drop :videos="{{$videos}}"></drag-n-drop>
                </section><!-- form-container -->

                <!-- /modules -->
@endsection