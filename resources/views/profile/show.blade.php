@extends('layouts.app')

@section('content')
	@if (Auth::guest())
		<user-profile :user="{{ $user }}" :files="{{ $files }}" :role="{{ $role }}"></user-profile>
	@else
		<user-profile :user="{{ $user }}" :files="{{ $files }}" :role="{{ $role }}" :activeprop="{{ Auth::user()}}"></user-profile>
	@endif


@endsection