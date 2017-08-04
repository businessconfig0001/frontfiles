@extends('layouts.app')

@section('content')
                <!-- form-container -->
                <section class="form-container">
				    <drag-n-drop :dropbox={{ $dropbox_token}}></drag-n-drop>
                </section><!-- form-container -->
	

                <!-- /modules -->
@endsection