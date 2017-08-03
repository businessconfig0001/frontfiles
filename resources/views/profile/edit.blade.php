@extends('layouts.app')

@section('content')

    <h1>{{ $user->fullName() }}</h1>

@endsection