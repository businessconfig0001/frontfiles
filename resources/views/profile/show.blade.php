@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            <h1>{{ $user->name }}</h1>
        </div>

        <div class="row">
            @if($user->google_clientId && $user->google_clientSecret && $user->google_refreshToken && $user->google_folderId)
                <p>GDrive configured!</p>
            @else
                <p>GDrive not configured!<br>
                    Please configure it so that you can save files in your drive.
                </p>
            @endif
        </div>

        <div class="row">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit</a>
        </div>

    </div>

@endsection