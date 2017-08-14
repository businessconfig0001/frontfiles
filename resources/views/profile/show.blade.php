@extends('layouts.app')

@section('content')

<user-profile :user="{{ $user }}" :files="{{ $files }}"></user-profile>

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
			
		</div>
	</modal-container>
@endsection