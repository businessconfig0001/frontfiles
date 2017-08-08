@extends('layouts.app')

@section('content')

    <div class="container profile">

        <div class="row info">
            <h1 class="title">{{ $user->fullName() }}</h1>

            <p>
                <a href="{{ url($user->path()) }}">Your public profile</a>
            </p>

            <p>
                <a href="{{ route('profile.edit') }}">Edit profile</a>
            </p>

            <p>
                Your account type is: {{ $user->roles()->pluck('name')->first() }}
            </p>

        </div>

        <div class="row storage">
            <ul>
                <li class="box">
                    <img  class="logo" src="/images/dropbox_glyph_blue.svg" alt="">
                    <h3 class="title">Dropbox</h3>
                    @if($user->dropbox_token)
                        <p>Dropbox connected!</p>
                    @else
                        <p>Dropbox not configured!</p>
                        <a href="{{ route('profile.dropbox') }}" class="btn btn-primary">Connect to your Dropbox</a>
                    @endif
                </li>
            </ul>
            
            
        </div>

    </div>
    <profile-modal></profile-modal>
@endsection