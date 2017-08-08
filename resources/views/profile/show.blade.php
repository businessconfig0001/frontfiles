@extends('layouts.app')

@section('content')

<user-profile :user="{{ $user }}" :files="{{ $files }}"></user-profile>

@endsection

@section('modals')
	<modal-container>
		<h2>You are now an official FrontFiler and we are ready to start receiving your editorial footage, images or illustrations.</h2> 
		<p>
			You can complete your profile information whenever you want. After you upload your files, they will be available for sale and for sharing (the compressed copy).During this Beta phase, files can be sold by us directly to the client, and only if they show urgent relevancy. However, you decide whether you wish to sell or not, as well as set the price for all of your files.In the next platform’s phase you will have full control over the sales , which will be automatic and direct from you to the buyer'
		</p>
	</modal-container>
@endsection