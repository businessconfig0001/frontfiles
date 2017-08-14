@extends('layouts.app')

@section('content')
    <section class="form-container">
	    <drag-n-drop :dropbox={{ $dropbox_token}}></drag-n-drop>
    </section>
@endsection

@section('modals')
<modal-container>
	<div slot="pt">
	  
	</div>
	<div slot="br">
	  
	</div>
	<div slot="es">
	  
	</div>
	<div slot="en">
		<h2>For optimal indexing, it is extremely important that you describe and tag your material very precisely.</h2>
		<p>
			Provide a short title and an accurate description of the event. Key words / tags will make it easier to find your work in a search.You must try to answer basic questions like #who, #what, #where, #when, #why, #how.'
		</p>
	</div>

</modal-container>
@endsection