@extends('layouts.app')

@section('content')

<user-profile :user="{{ $user }}" :files="{{ $files }}"></user-profile>

@endsection