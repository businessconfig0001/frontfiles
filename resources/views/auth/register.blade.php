@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
                <h1 class="auth-title title-offset">Create profile</h1>
                <p class="beta-notice"> In order to register you must be part of our beta program</p>
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
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <label><input type="checkbox" v-model="ethics"> I accept the <a href="https://drive.google.com/file/d/0B6hTJyXpVLXaU2F3UkFxamFCeHR6X3ZwTmJKWEp2bERUS2Y4/view" target="_blank">Code of ethics</a></label>   
                            </div>
                            
                            
                        </div>
                        <!-- Button -->
                        <div class="form-group">
                            <div v-if="allow" class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" @click.prevent="submit" :disabled="!ethics">
                                    Submit
                                </button>
                            </div>
                            <div v-else class="col-md-6 col-md-offset-4">
                                <a class="btn btn-primary" @click.prevent="modal" :disabled="!ethics">Submit</a>
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
   <modal-container v-else :showmodal="options.show">
        <div slot="br">
            <h1>Caro(a) amigo(a): <br/> Bem-vindo(a) ao FrontFiles</h1>
            <p>
                Você está prestes a acessar a versão Beta da Plataforma FrontFiles.
                Tenha em mente que esta área está em construção pela comunidade de usuários e temos o enorme prazer de contar com a sua colaboração para ajudar a plataforma a melhorar sua performance.

            </p>
            <h2>FrontFiles é uma comunidade web global de jornalistas e midialivristas.</h2>
            <p>
                Ao tornar-se um FrontFiler você fará parte de um grupo mundial de pessoas empenhadas em construir um novo modelo de fornecimento de notícias e informações, produzidas pelos usuários e baseadas em imagens, vídeos e relatos. Através do trabalho colaborativo - compartilhamento de dados, tecnologia, equipamentos, alojamento, transporte, etc…
            </p>
            <h2>Visamos empoderar a comunidade e tornar nosso trabalho mais fácil e eficiente.</h2>
            <p>
                Ao vender seus arquivos de imagem, vídeo ou ilustração de uma forma rápida, simples e sem burocracia, o usuário se empodera financeiramente. Este é o começo de uma longa e poderosa viagem. Vamos fazê-la juntos.
            </p>
        </div>
        <div slot="es">
            <h1>Estimado amigo: <br/> Bienvenido a FrontFiles</h1>
            <p>
                Está a punto de ingresar a la versión Beta de la plataforma FrontFiles Tenga en cuenta que este área está en construcción por la comunidad de usuarios y estamos muy agradecidos por su ayuda para mejorar su calidad.

            </p>
            <h2>FrontFiles es una comunidad web global de periodistas y medios livres de comunicación.</h2>
            <p>
                Al convertirse en un FrontFiler, usted formará parte de un grupo mundial de personas comprometidas en construir un nuevo modelo de suministro de noticias e informaciones, producidas por los usuarios y basadas en imágenes, vídeos y relatos verdaderos, con efectiva confirmación de los hechos. A través del trabajo colaborativo - compartir datos, tecnologías, equipamientos, alojamiento, transporte, etc ...
            </p>
            <h2>Buscamos empoderar a la comunidad y hacer nuestro trabajo más fácil y eficiente.</h2>
            <p>
                Al vender sus archivos de imagen, vídeo o ilustración de una forma rápida, sencilla y sin burocracia, el usuario se empodera financieramente. Este es el comienzo de un largo y poderoso viaje. Vamos a hacerlo juntos.
            </p>
        </div>
        <div slot="en">
            <h1>Dear friend: <br />Welcome to FrontFiles</h1>
            <p>
                Thank you for joining us on this Beta version and Platform testing. Please note that this is a community work-in-progress area. We are very pleased that you are helping us to improve its quality.
            </p>
            <h2>FrontFiles is a global web-based community of free reporters and journalists.</h2>
            <p>
                By becoming a FrontFiler you will be part of a worldwide group of people committed to building a new model for news and information sourcing, produced by the users and based on true images, footage and reports and effective fact checking. By collaborating - sharing information, technology, equipment, lodging, transportation and more
            </p>
            <h2>We empower ourselves and make our jobs easier.</h2>
            <p>
                By selling our files in a way that’s fast, easy and free of bureaucracy, we find financial empowerment. This is the beginning of a long and powerful journey. Let’s do it together.
            </p>
            <!--
            <h2>Ups! You should be part of our beta program.</h2>
            <p>
               Send an email to <a :href="'mailto:info@frontfiles.com'">info@frontfiles.com</a>. Our team will notify you as soon the platform is open for everyone.
            </p>
            -->
        </div>
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
