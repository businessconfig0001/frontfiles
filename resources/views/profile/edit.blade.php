@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div>
                <h1 class="auth-title title-offset">Edit profile</h1>
                <div class="auth-form">

                    <form class="form-horizontal" method="POST" action="{{ route('profile.update') }}">
                        {{ csrf_field() }}
                        {!! method_field('patch') !!}

                        <!-- First Name -->
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- /First Name -->

                        <!-- Last Name -->
                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" required autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- /Last Name -->

                        <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
                            <label for="avatar" class="col-md-4 control-label offset-label">Profile picture</label>

                            <div class="col-md-6">
                                <file-input class="file-input" :options="{ name:'avatar',accept:'image',label:'upload picture' }"></file-input>
                                @if ($errors->has('avatar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
                            <label for="bio" class="col-md-4 control-label">Bio</label>

                            <div class="col-md-6">
                                <textarea id="bio" name="bio" class="form-control" autofocus>{{ $user->bio }}</textarea>

                                @if ($errors->has('bio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- /Bio -->

                        <!-- Location -->
                        <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                            <label for="location" class="col-md-4 control-label">Location</label>

                            <div class="col-md-6">
                                <input id="location" type="text" class="form-control" name="location" value="{{ $user->location }}" required autofocus>

                                @if ($errors->has('location'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- /Location -->

                        <!-- Type -->
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type" class="col-md-4 control-label radio-label">Type</label>

                            <div class="col-md-6 register-radio">
                                <div>
                                   <input type="radio" name="type" value="user" class="form-control" id="indu" checked>
                                    <label for="indu">Individual</label> 
                                </div>
                                <div>
                                    <input id="coll" type="radio" name="type" value="corporative" class="form-control">
                                    <label  for="coll">Collective</label>
                                </div>
                                

                                @if ($errors->has('type'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- /Type -->

                        <!-- Button -->
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <input type="submit" class="btn btn-primary" value="Save">
                            </div>
                        </div>
                        <!-- Button -->

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    new google.maps.places.Autocomplete(document.getElementById('location'))
</script>
@endsection
