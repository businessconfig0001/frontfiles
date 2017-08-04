@extends('layouts.app')

@section('content')
                <!-- form-container -->
                <section class="form-container">
                	{{ $dropbox_token}}
				    <drag-n-drop :dropbox={{ $dropbox}}></drag-n-drop>
                </section><!-- form-container -->
	

                <!-- /modules -->
@endsection