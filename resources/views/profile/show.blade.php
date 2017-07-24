@extends('layouts.app')

@section('content')

    <div class="container profile">

        <div class="row info">
            <h1 class="title">{{ $user->name }}</h1>
        </div>

        <div class="row storage">
            <ul>
                <li class="box">
                    <img  class="logo" src="/images/googledrive.png" alt="">
                    <h3 class="title">Google Drive</h3>
                    @if($user->google_clientId && $user->google_clientSecret && $user->google_refreshToken && $user->google_folderId)
                        <p>Google Drive configured!</p>
                    @else
                        <p>Google Drive not configured!</p>
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Configure Google Drive</a>
                    @endif
                </li>
                <li class="box">
                    <img  class="logo" src="/images/dropbox_glyph_blue.svg" alt="">
                    <h3 class="title">Dropbox</h3>
                    @if($user->dropbox_token && $user->dropbox_app_name)
                        <p>Dropbox configured!</p>
                    @else
                        <p>Dropbox not configured!</p>
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Configure Dropbox</a>
                    @endif
                </li>
            </ul>
            
            
        </div>

    </div>

@endsection