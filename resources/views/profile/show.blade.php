@extends('layouts.app')

@section('content')
<user-profile :user="{{ $user }}" :files="{{ $files }}" :role="{{ $role }}" :active="{{ Auth::user()}}"></user-profile>

@endsection