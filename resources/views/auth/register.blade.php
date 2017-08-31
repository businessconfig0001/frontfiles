@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
                <h1 class="auth-title title-offset">Create profile</h1>
                <p class="beta-notice"> In order to register you have to be part of our beta program</p>
                <div class="auth-form">

                    <form class="form-horizontal" method="POST" action="{{ route('auth.register') }}" enctype="multipart/form-data" id="register_form">
                        {{ csrf_field() }}

                        <!-- First Name -->
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

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
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- /Last Name -->

                        <!-- Avatar -->
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
                        <!-- /Avatar -->

                        <!-- Bio -->
                        <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
                            <label for="bio" class="col-md-4 control-label">About you</label>

                            <div class="col-md-6">
                                <textarea id="bio" name="bio" class="form-control" autofocus>{{ old('bio') }}</textarea>

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
                                <input id="location" type="text" class="form-control" name="location" value="{{ old('location') }}" required autofocus>

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
                            <label for="type" class="col-md-4 control-label offset-label">Type</label>

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

                        <!-- Email -->
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- /Email -->

                        <!-- Password -->
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- /Password -->

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <!-- /Confirm Password -->

                        <!-- Button -->
                        <div class="form-group">
                            <div v-if="allow" class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                            <div v-else class="col-md-6 col-md-offset-4">
                                <a class="btn btn-primary" @click.prevent="modal">Submit</a>
                            </div>
                        </div>
                        <!-- Button -->

                    </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
   <register-modal v-if=allow></register-modal>
   <modal-container v-else>
        <slot name="br">
            
        </slot>
        <slot name="es">
            
        </slot>
        <slot name="en">
            <h2>Ups! You should be part of our beta program.</h2>
            <p>
               Send an email to <a :href="'mailto:info@frontfiles.com'">info@frontfiles.com</a>. Our team will notify you as soon the platform is open for everyone.
            </p>
       </slot>
       
   </modal-container>
@endsection

@section('scripts')
<script>
    window.onload=function(){
        let location=document.getElementById('location')
        location.addEventListener('focus',() => new google.maps.places.Autocomplete(location))
        
    }
    
</script>
@endsection
