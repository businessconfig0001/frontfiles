@extends('layouts.app')

@section('content')

<user-profile :user="{{ $user }}"></user-profile>

@endsection