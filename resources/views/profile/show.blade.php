@extends('layouts.app')

@section('content')

<user-profile :user="{{ $user }}" :files="{{ $files }}" :active="{{ Auth::user()}}"></user-profile>

@endsection