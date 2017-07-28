@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            <h1>{{ $user->name }}</h1>
        </div>

        <div class="row">
            @if($user->google_clientId && $user->google_clientSecret && $user->google_refreshToken && $user->google_folderId)
                <p>Google Drive configured!</p>
            @else
                <p>Google Drive not configured!<br>
                    Please configure it so that you can save files in your Google Drive.
                </p>
            @endif
            @if($user->dropbox_token && $user->dropbox_app_name)
                <p>Dropbox configured!</p>
            @else
                <p>Dropbox not configured!<br>
                    Please configure it so that you can save files in your Dropbox.
                </p>
            @endif
        </div>

        <div class="row">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit</a>
        </div>

    </div>

@endsection