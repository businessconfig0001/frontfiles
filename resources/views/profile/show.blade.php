@extends('layouts.app')

@section('content')
<user-profile :user="{{ $user }}" :files="{{ $files }}" :role="{{ $role }}" :activeprop="{{ Auth::user()}}"></user-profile>

@endsection