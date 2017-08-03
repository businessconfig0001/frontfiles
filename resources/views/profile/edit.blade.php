@extends('layouts.app')

@section('content')

    <p>{{ $user->fullName() }}</p>

    <p>{{ $user->first_name }}</p>

    <p>{{ $user->last_name }}</p>

    <p>{{ $user->email }}</p>

    <p>{{ $user->bio }}</p>

    <p>{{ $user->location }}</p>

    <button>disconnect dropbox</button>

@endsection