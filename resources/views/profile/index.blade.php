@extends('layouts.app')

@section('content')

    <div class="container profile">

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
                <li class="box">
                    <img  class="logo" src="{{$user->avatar}}" alt="">
                    <h3 class="title">Your profile</h3>
                    <p>Go and edit your profile</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Go to your profile</a>
                </li>
                <li class="box">
                    <img  class="logo" src="/images/logo2x.png" alt="">
                    <h3 class="title">Public profile</h3>
                    <p>View your profile as another user</p>
                    <a href="{{ url($user->path()) }}"  target="_blank" class="btn btn-primary">Go to your public profile</a>
                </li>
            </ul>
            
            
        </div>

    </div>
    
@endsection

@section('modals')
    <profile-modal></profile-modal>
@endsection