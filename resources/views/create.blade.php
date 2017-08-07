@extends('layouts.app')

@section('content')
    <section class="form-container">
	    <drag-n-drop :dropbox={{ $dropbox_token}}></drag-n-drop>
    </section>
@endsection