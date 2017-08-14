@extends('layouts.app')

@section('content')

<user-profile :user="{{ $user }}" :files="{{ $files }}"></user-profile>

@endsection

@section('modals')
	<modal-container>
		<welcome-modal></welcome-modal>	
	</modal-container>
@endsection