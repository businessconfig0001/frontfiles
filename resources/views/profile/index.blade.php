@extends('layouts.app')

@section('content')

    <div class="container profile">

        <div class="row info">
            <h1 class="title">{{ $user->name }}</h1>
            <a href="{{ url($user->path()) }}">Your public profile</a>
        </div>

        <div class="row storage">
            <ul>
                <li class="box">
                    <img  class="logo" src="/images/dropbox_glyph_blue.svg" alt="">
                    <h3 class="title">Dropbox</h3>
                    @if($user->dropbox_token)
                        <p>Dropbox configured!</p>
                    @else
                        <p>Dropbox not configured!</p>
                        <a href="{{ $authUrl }}" class="btn btn-primary">Connect to your Dropbox</a>
                    @endif
                </li>
            </ul>
            
            
        </div>

    </div>

@endsection